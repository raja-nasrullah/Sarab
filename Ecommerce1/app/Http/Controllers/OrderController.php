<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;       // ✅ THIS LINE MUST BE HERE!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    return view('admin.pages.invoice', compact('invoice'));
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
            'user_id' => 'nullable|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'sometimes|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create($request->except('items'));

            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();
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
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $customer = \App\Models\Customer::firstOrCreate(
                ['email' => $request->customer_email],
                [
                    'name' => $request->customer_name,
                    'phone' => 'N/A'
                ]
            );

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_date' => now(),
                'total_amount' => $request->total_amount,
                'status' => 'pending',
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
                    'order_id' => $order->id,
                    'menu_item_id' => $itemData['id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $menuItem->price,
                ]);
            }

            DB::commit();

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

    $order->status = $request->status;
    $order->save();
    
    $invoiceId = null;
    
    if ($request->status === 'completed') {
        // ✅ Call the InvoiceController to generate the invoice
        $invoiceController = new InvoiceController();
        $response = $invoiceController->generateInvoice($order->id);
        
        // Decode the JSON response to get the ID
        $data = json_decode($response->getContent(), true);
        if (isset($data['invoice']['id'])) {
            $invoiceId = $data['invoice']['id'];
        }
    }

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
}