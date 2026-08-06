<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; // ✅ Correctly placed at the top!

class InvoiceController extends Controller
{
    /**
     * ✅ NEW METHOD: Generate an Invoice for a specific Order
     */
    public function generateInvoice($orderId)
    {
        // 1. Find the order
        $order = Order::with('customer')->find($orderId);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // 2. Check if an invoice already exists for this order
        $existingInvoice = Invoice::where('order_id', $order->id)->first();

        if ($existingInvoice) {
            return response()->json([
                'success' => false, 
                'message' => 'An invoice for this order already exists.',
                'invoice' => $existingInvoice
            ]);
        }

        // 3. Create the Invoice (UPDATED TO MATCH YOUR MIGRATION)
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            
            // ✅ FIX: Added the missing required fields from your migration
            'issued_date' => now(),                     // Required by migration
            'due_date' => now()->addDays(30),           // Required by migration
            'subtotal' => $order->total_amount,         // Required by migration
            'discount_percent' => 0,                    // Default 0
            'tax_percent' => 0,                         // Default 0
            
            'total_amount' => $order->total_amount,
            'status' => 'paid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice generated successfully!',
            'invoice' => $invoice
        ]);
    }

    /**
     * Display the specified invoice (For your View page)
     */
    public function show($id)
    {
        $invoice = Invoice::with('order.customer', 'order.orderItems.menuItem')->find($id);

        if (!$invoice) {
            return redirect()->route('admin.orders')->with('error', 'Invoice not found');
        }

        return view('admin.pages.invoice', compact('invoice'));
    }

    /**
     * Display a listing of the invoices (For your Sidebar list)
     */
    public function index()
    {
        $invoiceList = Invoice::with('order.customer', 'order.orderItems.menuItem')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.pages.invoice', compact('invoiceList'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $request->validate([
            'status' => 'sometimes|in:paid,unpaid',
        ]);

        $invoice->update($request->all());

        return response()->json(['message' => 'Invoice updated successfully', 'invoice' => $invoice]);
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }

    // ✅ NEW METHOD: Fetch data for Yajra DataTables
    public function getInvoicesData(Request $request)
    {
        $invoices = Invoice::with('order.customer')
                        ->orderBy('created_at', 'desc');

        return DataTables::of($invoices)
            ->addColumn('customer', function ($invoice) {
                return $invoice->order->customer ? $invoice->order->customer->name : 'Guest';
            })
            ->addColumn('order_id', function ($invoice) {
                return $invoice->order->id;
            })
            ->addColumn('action', function ($invoice) {
                return '<a href="' . route('admin.invoice', $invoice->id) . '" class="tb-btn" aria-label="View Invoice" title="View Invoice">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                            </svg>
                        </a>';
            })
            ->editColumn('status', function ($invoice) {
                $bg = $invoice->status == 'paid' ? '#28a74520' : '#ffc10720';
                $color = $invoice->status == 'paid' ? '#28a745' : '#ffc107';
                return '<span style="background:' . $bg . ';color:' . $color . ';padding:4px 12px;border-radius:12px;font-size:11px;font-weight:600;">' . ucfirst($invoice->status) . '</span>';
            })
            ->editColumn('total_amount', function ($invoice) {
                return '$' . number_format($invoice->total_amount, 2);
            })
            ->editColumn('created_at', function ($invoice) {
                return \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y');
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}