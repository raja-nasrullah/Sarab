@extends('admin.layouts.app')

@section('title', 'Dynamic Tables | Sarab 2026 v4')
@section('page', 'tables-dynamic')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Tables</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Dynamic</span>
@endsection

@section('content')
<div class="page-wrapper">

  <div class="page-header">
    <div class="page-header-row">
      <div>
        <div class="page-pretitle">Tables</div>
        <h1 class="page-title">Server data — orders</h1>
      </div>
      <div class="page-actions">
        <button class="btn btn-outline">Refresh</button>
        <button class="btn btn-primary">Export CSV</button>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Orders</div>
        <div class="card-subtitle">{{ $orders->count() }} total orders</div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table" data-datatable data-page-length="25">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Table</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody id="orders-tbody">
          <!-- Rows rendered by JavaScript -->
        </tbody>
      </table>
    </div>
  </div>

</div>

@section('scripts')
<script>
    // ============================================
    // ✅ ORDERS DATA FROM YOUR DATABASE
    // ============================================
    const orders = @json($orders);

    // Convert DB data to the format the JS expects
    const formattedOrders = orders.map((order) => ({
        id: order.id,
        customer: order.customer ? order.customer.name : 'Guest',
        initials: order.customer ? order.customer.name.substring(0, 2).toUpperCase() : 'G',
        table: order.table ? order.table.table_number : 'N/A',
        total: order.total_amount,
        status: order.status,
        date: new Date(order.order_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
    }));

    // ============================================
    // ✅ STATUS COLORS
    // ============================================
    const statusColors = {
        'completed': 'green',
        'pending': 'yellow',
        'cancelled': 'red'
    };

    // ============================================
    // ✅ RENDER THE TABLE
    // ============================================
    function renderOrders() {
        const tbody = document.getElementById('orders-tbody');
        if (!tbody) return;

        tbody.innerHTML = formattedOrders.map(order => `
            <tr>
                <td class="cell-mono">#${order.id}</td>
                <td class="cell-strong">
                    <div class="cell-customer">
                        <div class="cell-avatar" style="background:var(--primary);width:24px;height:24px;font-size:10px;color:white;">
                            ${order.initials}
                        </div>
                        <span>${order.customer}</span>
                    </div>
                </td>
                <td>${order.table}</td>
                <td class="cell-strong">$${Number(order.total).toFixed(2)}</td>
                <td>
                    <span class="status status-${statusColors[order.status] || 'blue'}">
                        ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                    </span>
                </td>
                <td>${order.date}</td>
            </tr>
        `).join('');
    }

    // ============================================
    // ✅ INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', renderOrders);
</script>
@endsection