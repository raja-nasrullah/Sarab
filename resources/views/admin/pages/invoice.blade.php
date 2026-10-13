@extends('admin.layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number . ' | Sarab 2026 v4')
@section('page', 'invoices')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Billing</span>
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('admin.invoices') }}" class="breadcrumb-item">Invoices</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">{{ $invoice->invoice_number }}</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Billing</div>
                <h1 class="page-title">Invoice {{ $invoice->invoice_number }}</h1>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.invoices') }}" class="btn btn-outline">← Back to Invoices</a>
                <button class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>

    <div class="card" style="padding:24px;">
        <div style="display:flex;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 style="font-size:18px;font-weight:700;margin:0;">Invoice Details</h2>
                <p style="color:var(--text-muted);font-size:13px;margin:4px 0 0;">{{ $invoice->invoice_number }}</p>
            </div>
            <div style="text-align:right;">
                <span style="background:{{ $invoice->status == 'paid' ? '#28a74520' : '#ffc10720' }};color:{{ $invoice->status == 'paid' ? '#28a745' : '#ffc107' }};padding:6px 16px;border-radius:12px;font-size:12px;font-weight:600;">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
            <div>
                <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Billed To</div>
                <div style="font-weight:600;margin-top:4px;">{{ $invoice->order->customer->name ?? 'Guest' }}</div>
                <div style="color:var(--text-muted);font-size:13px;">{{ $invoice->order->customer->email ?? '-' }}</div>
<div style="color:var(--text-muted);font-size:13px;">{{ $invoice->order->phone ?? $invoice->order->customer->phone ?? '-' }}</div>           </div>
            <div style="text-align:right;">
                <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Order #</div>
                <div style="font-weight:600;margin-top:4px;">#{{ $invoice->order->id ?? '-' }}</div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:8px;">
                    Issued: {{ \Carbon\Carbon::parse($invoice->issued_date)->format('M d, Y') }}<br>
                    Due: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                </div>
            </div>
        </div>

        <table class="table" style="width:100%;border-collapse:collapse;margin-bottom:24px;">
            <thead>
                <tr style="border-bottom:1px solid var(--border-color);">
                    <th style="text-align:left;padding:12px 0;">Item</th>
                    <th style="text-align:center;padding:12px 0;">Qty</th>
                    <th style="text-align:right;padding:12px 0;">Price</th>
                    <th style="text-align:right;padding:12px 0;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->orderItems as $item)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:12px 0;">{{ $item->menuItem->name ?? 'Item' }}</td>
                        <td style="text-align:center;padding:12px 0;">{{ $item->quantity }}</td>
                        <td style="text-align:right;padding:12px 0;">${{ number_format($item->price, 2) }}</td>
                        <td style="text-align:right;padding:12px 0;font-weight:600;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display:flex;justify-content:flex-end;">
            <div style="min-width:280px;">
                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                    <span style="color:var(--text-muted);">Subtotal</span>
                    <span>${{ number_format($invoice->subtotal ?? 0, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                    <span style="color:var(--text-muted);">Discount ({{ $invoice->discount_percent ?? 0 }}%)</span>
                    <span>-${{ number_format(($invoice->subtotal ?? 0) * ($invoice->discount_percent ?? 0) / 100, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                    <span style="color:var(--text-muted);">Tax ({{ $invoice->tax_percent ?? 0 }}%)</span>
                    <span>+${{ number_format(($invoice->subtotal ?? 0) * ($invoice->tax_percent ?? 0) / 100, 2) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-top:2px solid var(--border-color);margin-top:6px;font-size:18px;font-weight:700;">
                    <span>Total</span>
                    <span>${{ number_format($invoice->total_amount ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection