<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Events\NewOrderPlaced; // ✅ ADD THIS
use App\Events\OrderStatusUpdated; // ✅ ADD THIS (we'll create it)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 👇 THIS METHOD PASSES DATA TO THE ADMIN VIEW
    public function adminIndex()
    {
        // Fetch all orders with their related customer, table, user, and items
        $orders = Order::with('customer', 'table', 'user', 'orderItems.menuItem', 'invoice')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.pages.orders', compact('orders'));
    }

    // ✅ NEW: Show a list of all invoices
    public function invoiceIndex()
    {
        $invoiceList = Invoice::with('order.customer', 'order.orderItems.menuItem')
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('admin.pages.invoice', compact('invoiceList'));
    }

    public function showInvoice($id = null)
    {
        if (!$id) return redirect()->route('admin.orders');
        $invoice = Invoice::with('order.customer', 'order.orderItems.menuItem')->findOrFail($id);
        return view('admin.pages.invoice', compact('invoiceList'));
    }
    
    public function index()
    {
        $orders = Order::with('customer', 'table', 'user', 'orderItems.menuItem')->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'table_id' => 'nullable|exists:restaurant_tables,id',
            // ✅ REMOVE 'user_id' from validation since we will force it manually
            'total_amount' => 'required|numeric|min:0',
            'status' => 'sometimes|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // ✅ CRITICAL FIX: Prepare the data manually
            $orderData = $request->except('items');
            
            // ✅ Force the logged-in user's ID (Admin) instead of trusting the request
            $orderData['user_id'] = Auth::id(); 

            $order = Order::create($orderData);

            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            // ✅ 🔔 BROADCAST NEW ORDER NOTIFICATION
            broadcast(new NewOrderPlaced($order))->toOthers();

            return response()->json($order->load('orderItems'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create order: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with('customer', 'table', 'user', 'orderItems.menuItem')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $request->validate([
            'status' => 'sometimes|in:pending,completed,cancelled',
            'total_amount' => 'sometimes|numeric|min:0',
        ]);

        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function placeOrderFromWeb(Request $request)
{
    $request->validate([
        'customer_name'    => 'required|string|max:255',
        'customer_email'   => 'required|email|max:255',
        'customer_phone'   => 'required|string|max:30',                // ✅ NEW
        'customer_address' => 'required|string|max:1000',              // ✅ NEW
        'payment_method'   => 'required|in:cash_on_delivery,card,upi', // ✅ NEW
        'items'            => 'required|array|min:1',
        'items.*.id'       => 'required|exists:menu_items,id',
        'items.*.quantity' => 'required|integer|min:1',
        'total_amount'     => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Save phone on the customer too
        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $request->customer_email],
            [
                'name'  => $request->customer_name,
                'phone' => $request->customer_phone,
            ]
        );

        // If customer already existed, still update their phone number
        if (!$customer->wasRecentlyCreated) {
            $customer->update(['phone' => $request->customer_phone]);
        }

        $order = Order::create([
            'customer_id'    => $customer->id,
            'order_date'     => now(),
            'total_amount'   => $request->total_amount,
            'status'         => 'pending',
            'phone'          => $request->customer_phone,    // ✅ NEW
            'address'        => $request->customer_address,  // ✅ NEW
            'payment_method' => $request->payment_method,    // ✅ NEW
        ]);

        foreach ($request->items as $itemData) {
            $menuItem = \App\Models\MenuItem::find($itemData['id']);

            if (!$menuItem) {
                throw new \Exception("Menu item with ID " . $itemData['id'] . " not found.");
            }
            if (is_null($menuItem->price)) {
                throw new \Exception("Menu item '" . $menuItem->name . "' has a NULL price in the database.");
            }

            OrderItem::create([
                'order_id'     => $order->id,
                'menu_item_id' => $itemData['id'],
                'quantity'     => $itemData['quantity'],
                'price'        => $menuItem->price,
            ]);
        }

        DB::commit();

        broadcast(new NewOrderPlaced($order))->toOthers();

        Session::forget('cart');
        return redirect()->route('order.confirmation', ['id' => $order->id]);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to place order: ' . $e->getMessage());
    }
}
    public function updateStatus(Request $request, $id)
    {
        $order = \App\Models\Order::find($id);
        
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $oldStatus = $order->status; // ✅ Store old status
        $order->status = $request->status;
        $order->save();
        
        $invoiceId = null;
        
        if ($request->status === 'completed') {
            // ✅ Reuse existing invoice if it already exists
            $existing = \App\Models\Invoice::where('order_id', $order->id)->first();

            if ($existing) {
                $invoiceId = $existing->id;
            } else {
                $invoiceController = new InvoiceController();
                $response = $invoiceController->generateInvoice($order->id);
                $data = json_decode($response->getContent(), true);
                if (isset($data['invoice']['id'])) {
                    $invoiceId = $data['invoice']['id'];
                }
            }
        }

        // ✅ 🔔 BROADCAST ORDER STATUS UPDATE
        broadcast(new OrderStatusUpdated($order, $oldStatus))->toOthers();

        return response()->json([
            'success' => true, 
            'message' => 'Status updated successfully',
            'invoice_id' => $invoiceId
        ]);
    }

    // ✅ Show Order Confirmation Page
    public function showOrderConfirmation($id)
    {
        // Fetch the order with its items and customer
        $order = \App\Models\Order::with('customer', 'orderItems.menuItem')->findOrFail($id);

        // Return the confirmation view
        return view('website.pages.order-confirmation', compact('order'));
    }
    public function exportCsv()
{
    $orders = Order::with('customer', 'orderItems.menuItem', 'invoice')
                    ->orderBy('created_at', 'desc')
                    ->get();

    $fileName = 'orders_export_' . date('Y-m-d_H-i') . '.csv';

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = [
        'Order ID',
        'Customer Name',
        'Customer Email',
        'Customer Phone',     // ✅ NEW
        'Delivery Address',   // ✅ NEW
        'Payment Method',     // ✅ NEW
        'Items Count',
        'Items',
        'Total Amount',
        'Status',
        'Order Date'
    ];

    $callback = function () use ($orders, $columns) {
        $file = fopen('php://output', 'w');

        // UTF-8 BOM for Excel
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header row
        fputcsv($file, $columns);

        foreach ($orders as $order) {
            $itemNames = $order->orderItems->map(function ($item) {
                $name = $item->menuItem->name ?? 'Item';
                return $name . ' x' . $item->quantity;
            })->implode(', ');

            fputcsv($file, [
                '#' . $order->id,
                $order->customer->name  ?? 'Guest',
                $order->customer->email ?? '-',
                $order->phone           ?? $order->customer->phone ?? '-',  // ✅ NEW
                $order->address         ?? '-',                             // ✅ NEW
                ucfirst(str_replace('_', ' ', $order->payment_method ?? '-')), // ✅ NEW
                $order->orderItems->count(),
                $itemNames,
                number_format($order->total_amount, 2),
                ucfirst($order->status),
                $order->order_date
                    ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d H:i')
                    : ($order->created_at ? $order->created_at->format('Y-m-d H:i') : '-'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
/**
 * Show a single order in the admin panel.
 */
public function showAdminDetail($id)
{
    $order = Order::with([
        'customer',
        'table',
        'user',
        'orderItems.menuItem',
        'invoice',
    ])->findOrFail($id);

    return view('admin.pages.order_detail', compact('order'));
}

}