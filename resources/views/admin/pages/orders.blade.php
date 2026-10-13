@extends('admin.layouts.app')

@section('title', 'Orders | Sarab 2026 v4')
@section('page', 'orders')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Shop</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Orders</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Shop</div>
                <h1 class="page-title">Orders</h1>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.orders.export') }}" class="btn btn-outline">Export CSV</a>
                <!-- <button class="btn btn-primary">+ Manual order</button> -->
            </div>
        </div>
    </div>

    <!-- Stat row -->
    <div class="row col-3" style="margin-bottom:16px">
        <div class="card">
            <div class="stat">
                <div class="stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total orders</div>
                    <div class="stat-value-row">
                        <span class="stat-value">{{ $orders->count() }}</span>
                        <span class="stat-change up" style="color:#28a745;">↑ 12%</span>
                    </div>
                    <div class="stat-subtext">Active orders</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="stat">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Revenue</div>
                    <div class="stat-value-row">
                        <span class="stat-value">${{ number_format($orders->sum('total_amount'), 2) }}</span>
                        <span class="stat-change up" style="color:#28a745;">↑ 18%</span>
                    </div>
                    <div class="stat-subtext">Total revenue</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="stat">
                <div class="stat-icon yellow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value-row">
                        <span class="stat-value">{{ $orders->where('status', 'pending')->count() }}</span>
                        <span class="stat-change down" style="color:#dc3545;">↓ 3%</span>
                    </div>
                    <div class="stat-subtext">Awaiting processing</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">All orders</div>
                <div class="card-subtitle">{{ $orders->count() }} results</div>
            </div>
            <div class="card-options">
                <label style="font-size:11.5px;color:var(--text-muted);margin-right:6px">Status</label>
                <select class="form-control" style="width:170px;height:32px" aria-label="Filter by status" id="status-filter">
                    <option value="all">All statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-color);">
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Order</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Customer</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Items</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Total</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Payment</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Date</th>
                            <th style="padding:12px 16px;text-align:right;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;"></th>
                        </tr>
                    </thead>
                    <tbody id="orders-tbody">
                        @foreach($orders as $order)
                        <tr style="border-bottom:1px solid var(--border-color);">
                            <td style="padding:12px 16px;">
                                <a href="{{ route('admin.order.detail', ['id' => $order->id]) }}" style="color:var(--primary);font-weight:500;text-decoration:none;">#{{ $order->id }}</a>                            </td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:{{ ['#1abb9c', '#3498db', '#9b59b6', '#f39c12', '#e74c3c', '#2ecc71'][$loop->index % 6] }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:12px;">
                                        {{ $order->customer ? substr($order->customer->name, 0, 2) : 'G' }}
                                    </div>
                                    <span style="font-weight:500;">{{ $order->customer ? $order->customer->name : 'Guest' }}</span>
                                </div>
                            </td>
                            <td style="padding:12px 16px;text-align:center;">{{ $order->orderItems->count() }}</td>
                            <td style="padding:12px 16px;font-weight:600;">${{ number_format($order->total_amount, 2) }}</td>
                            
                            {{-- ✅ UPDATED: STATUS DROPDOWN COLUMN --}}
                            <td style="padding:12px 16px;">
                                <select class="form-control status-dropdown" data-order-id="{{ $order->id }}" style="padding:4px 8px;height:32px;font-size:12px;border-radius:8px;border:1px solid #e9ecef;background:#fff;cursor:pointer;min-width:120px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }} style="color:#ffc107;">Pending</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }} style="color:#28a745;">Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }} style="color:#dc3545;">Cancelled</option>
                                </select>
                            </td>
                            
                            <td style="padding:12px 16px;font-size:12px;color:var(--text-muted);">
    @php
        $pm = $order->payment_method ?? 'N/A';
        $pmLabel = ucfirst(str_replace('_', ' ', $pm));
    @endphp
    {{ $pmLabel }}
</td>
                            <td style="padding:12px 16px;font-size:13px;color:var(--text-muted);">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            
                            {{-- ✅ ACTION COLUMN WITH INVOICE ICON --}}
                            <td style="padding:12px 16px;text-align:right;">
                                @if($order->status == 'completed' && $order->invoice && $order->invoice->id)
                                    <a href="{{ route('admin.invoice', $order->invoice->id) }}" class="tb-btn" aria-label="View Invoice" title="View Invoice">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                            <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                                        </svg>
                                    </a>
                                @else
                                    <span style="font-size:10px;color:var(--text-muted);">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stat { display: flex; align-items: center; gap: 16px; padding: 16px; }
    .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
    .stat-icon.teal { background: #1abb9c; }
    .stat-icon.green { background: #28a745; }
    .stat-icon.yellow { background: #ffc107; }
    .stat-content { flex: 1; min-width: 0; }
    .stat-label { font-size: 12px; color: var(--text-muted); margin-bottom: 2px; }
    .stat-value-row { display: flex; align-items: center; gap: 8px; }
    .stat-value { font-size: 20px; font-weight: 700; color: var(--text); }
    .stat-change { font-size: 12px; font-weight: 600; }
    .stat-subtext { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
    .tb-btn { width: 28px; height: 28px; border: none; background: transparent; border-radius: var(--radius-sm); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-secondary); transition: background 120ms, color 120ms; }
    .tb-btn:hover { background: var(--bg-surface-secondary); color: var(--text); }
</style>
@endpush


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ============================================
           STATUS FILTER (client-side row hiding)
        ============================================ */
        const statusFilter = document.getElementById('status-filter');
        const tbody        = document.getElementById('orders-tbody');

        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                const selectedStatus = this.value.toLowerCase();
                tbody.querySelectorAll('tr').forEach(row => {
                    const sel = row.querySelector('.status-dropdown');
                    if (!sel) return;
                    const rowStatus = sel.value.toLowerCase();
                    row.style.display = (selectedStatus === 'all' || rowStatus === selectedStatus) ? '' : 'none';
                });
            });
        }

        /* ============================================
           STATUS DROPDOWN → PUT /admin/orders/{id}/status
           (delegated listener = single binding, no double fires)
        ============================================ */
        tbody.addEventListener('change', function (e) {
            if (!e.target.classList.contains('status-dropdown')) return;

            const selectEl  = e.target;
            const orderId   = selectEl.dataset.orderId;
            const newStatus = selectEl.value;
            const row       = selectEl.closest('tr');

            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    showNotification('❌ Failed: ' + data.message, 'error');
                    return;
                }

                // Keep dropdown in sync with DB
                selectEl.value = data.status;

                showNotification('✅ Order status updated to ' + newStatus, 'success');

                // Update the action cell (invoice icon or "N/A")
                const actionCell = row.querySelector('td:last-child');

                if (newStatus === 'completed' && data.invoice_id) {
                    actionCell.innerHTML = `
                        <a href="/admin/invoice/${data.invoice_id}" class="tb-btn" title="View Invoice" aria-label="View Invoice">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                            </svg>
                        </a>`;
                } else {
                    actionCell.innerHTML = `<span style="font-size:10px;color:var(--text-muted);">N/A</span>`;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showNotification('❌ Network error updating status.', 'error');
            });
        });

        /* ============================================
           PUSHER REAL-TIME NOTIFICATIONS
        ============================================ */
        if (typeof window.Echo !== 'undefined') {
            console.log('🔊 Pusher connected!');

            window.Echo.channel('admin-orders')
                .listen('NewOrderPlaced', (e) => {
                    console.log('🆕 New Order:', e);
                    showNotification('🆕 New Order #' + e.order_id + ' - $' + e.total_amount, 'success');
                    setTimeout(() => location.reload(), 1500);
                })
                .listen('OrderStatusUpdated', (e) => {
                    console.log('🔄 Order Status Updated:', e);
                    showNotification('🔄 Order #' + e.order_id + ' ' + e.old_status + ' → ' + e.new_status, 'info');
                });
        } else {
            console.warn('⚠️ Echo not initialized');
        }
    });

    /* ============================================
       TOAST HELPER
    ============================================ */
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.custom-toast');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = 'custom-toast';

        let bgColor = '#28a745';
        if (type === 'error')        bgColor = '#dc3545';
        else if (type === 'info')    bgColor = '#17a2b8';
        else if (type === 'warning') bgColor = '#ffc107';

        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px; padding: 12px 24px;
            background: ${bgColor};
            color: ${type === 'warning' ? '#212529' : 'white'};
            border-radius: 8px; z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease; font-size: 14px; font-weight: 500;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    /* ============================================
       Inject animation CSS once
    ============================================ */
    if (!document.getElementById('pusher-styles')) {
        const style = document.createElement('style');
        style.id = 'pusher-styles';
        style.innerHTML = `
            @keyframes slideIn  { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0);     opacity: 1; } }
            @keyframes slideOut { from { transform: translateX(0);    opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
        `;
        document.head.appendChild(style);
    }
</script>
@endsection
