@extends('admin.layouts.app')

@section('title', 'Order #' . $order->id . ' | Sarab 2026 v4')
@section('page', 'order-detail')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Shop</span>
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('admin.orders') }}" class="breadcrumb-item">Orders</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">#{{ $order->id }}</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Shop ·
                    <a href="{{ route('admin.orders') }}" style="color:var(--primary)">Orders</a>
                </div>
                <h1 class="page-title">
                    Order #{{ $order->id }}
                    <span class="status status-{{ $order->status == 'completed' ? 'green' : ($order->status == 'cancelled' ? 'red' : 'yellow') }}"
                          style="vertical-align:middle;margin-left:8px">
                        {{ ucfirst($order->status) }}
                    </span>
                </h1>
            </div>
            <div class="page-actions">
                <button class="btn btn-outline" onclick="window.print()">Print</button>
                @if($order->status === 'completed' && $order->invoice)
                    <a href="{{ route('admin.invoice', $order->invoice->id) }}" class="btn btn-primary">View Invoice</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row col-8-4">
        <!-- LEFT -->
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- ITEMS --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Items · {{ $order->orderItems->count() }}</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="width:60px">Qty</th>
                                    <th style="width:100px">Price</th>
                                    <th style="width:100px">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="cell-customer">
                                                <div class="cell-avatar" style="background:var(--primary-lt);color:var(--primary)">
                                                    {{ strtoupper(substr($item->menuItem->name ?? 'IT', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="cell-strong">{{ $item->menuItem->name ?? 'Item' }}</div>
                                                    <div style="font-size:11.5px;color:var(--text-muted)">Menu item #{{ $item->menu_item_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td class="cell-strong">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TOTALS --}}
                <div style="padding:14px 20px;border-top:1px solid var(--border-color-light);display:flex;justify-content:flex-end">
                    <table style="font-size:13px">
                        <tr>
                            <td style="padding:2px 16px 2px 0;color:var(--text-secondary)">Subtotal</td>
                            <td style="text-align:right;min-width:90px">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 16px 2px 0;color:var(--text-secondary)">Shipping</td>
                            <td style="text-align:right">$0.00</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 16px 2px 0;color:var(--text);font-weight:var(--font-weight-bold);border-top:1px solid var(--border-color-light)">Total</td>
                            <td style="text-align:right;font-weight:var(--font-weight-bold);font-size:15px;border-top:1px solid var(--border-color-light);padding-top:6px">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- NOTES (static example, keep as-is or wire up later) --}}
            <div class="card">
                <div class="card-header"><div class="card-title">Order notes</div></div>
                <div class="card-body" style="padding:8px 16px">
                    <textarea class="form-control" rows="2" placeholder="Add a note for your team…" aria-label="Order note"></textarea>
                </div>
            </div>
        </div>

        <!-- RIGHT (SIDEBAR) -->
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- CUSTOMER --}}
            <div class="card">
                <div class="card-header"><div class="card-title">Customer</div></div>
                <div class="card-body" style="padding:14px 16px">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                        <div class="cell-avatar" style="background:linear-gradient(135deg,var(--primary),var(--primary-dk));width:40px;height:40px;font-size:13px">
                            {{ strtoupper(substr($order->customer->name ?? 'G', 0, 2)) }}
                        </div>
                        <div>
                            <div class="cell-strong">{{ $order->customer->name ?? 'Guest' }}</div>
                            <div style="font-size:11.5px;color:var(--text-muted)">
                                {{ $order->customer->email ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Email</span>
                        <a href="mailto:{{ $order->customer->email ?? '' }}" style="color:var(--primary);font-size:12.5px">
                            {{ $order->customer->email ?? '-' }}
                        </a>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Phone</span>
                        <span class="value">{{ $order->phone ?? $order->customer->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- SHIPPING ADDRESS (dynamic) --}}
            <div class="card">
                <div class="card-header"><div class="card-title">Delivery address</div></div>
                <div class="card-body" style="padding:14px 16px;font-size:12.5px;color:var(--text-secondary);line-height:1.6">
                    <strong style="color:var(--text)">{{ $order->customer->name ?? 'Guest' }}</strong><br>
                    {{ $order->address ?? 'No address provided' }}
                </div>
            </div>

            {{-- PAYMENT (dynamic) --}}
            <div class="card">
                <div class="card-header"><div class="card-title">Payment</div></div>
                <div class="card-body" style="padding:14px 16px">
                    <div class="order-info-row">
                        <span class="label">Method</span>
                        <span class="value">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                        </span>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Status</span>
                        <span class="status status-{{ $order->status == 'completed' ? 'green' : ($order->status == 'cancelled' ? 'red' : 'yellow') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection