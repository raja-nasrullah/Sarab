@extends('admin.layouts.app')

@section('title', 'Sales dashboard | Gentelella 2026 v4')
@section('page', 'dashboard-3')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Dashboards</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Sales</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Sales</div>
                <h1 class="page-title">Pipeline & performance</h1>
            </div>
            <div class="page-actions">
                <button class="btn btn-outline">Q1 2026</button>
                <button class="btn btn-primary">+ New deal</button>
            </div>
        </div>
    </div>
  <!-- ── Row 1: Pipeline KPIs ── -->
  <div class="row col-4">
    <div class="card">
      <div class="card-header"><div><div class="card-title">Total Revenue</div><div class="card-subtitle">Completed orders</div></div></div>
      <div class="card-body" style="padding:8px 16px 16px">
        <div style="font-size:30px;font-weight:600;letter-spacing:-1px;color:var(--text);line-height:1">${{ number_format($totalRevenue, 2) }}</div>
        <div style="font-size:11.5px;color:var(--text-muted);margin-top:6px">Total earnings</div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div><div class="card-title">Total Orders</div><div class="card-subtitle">All time</div></div></div>
      <div class="card-body" style="padding:8px 16px 16px">
        <div style="font-size:30px;font-weight:600;letter-spacing:-1px;color:var(--green);line-height:1">{{ $totalOrders }}</div>
        <div style="font-size:11.5px;color:var(--text-muted);margin-top:6px">Total sales</div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div><div class="card-title">Total Customers</div><div class="card-subtitle">Registered guests</div></div></div>
      <div class="card-body" style="padding:8px 16px 16px">
        <div style="font-size:30px;font-weight:600;letter-spacing:-1px;color:var(--text);line-height:1">{{ $totalCustomers }}</div>
        <div style="font-size:11.5px;color:var(--text-muted);margin-top:6px">Active members</div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div><div class="card-title">Menu Items</div><div class="card-subtitle">Available for order</div></div></div>
      <div class="card-body" style="padding:8px 16px 16px">
        <div style="font-size:30px;font-weight:600;letter-spacing:-1px;color:var(--text);line-height:1">{{ $totalMenuItems }}</div>
        <div style="font-size:11.5px;color:var(--text-muted);margin-top:6px">Active menu</div>
      </div>
    </div>
  </div>

  <!-- ── Row 2: Quarterly target gauge + Mixed orders chart ── -->
  <div class="row col-4-8">
    <div class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Quarterly target</div>
          <div class="card-subtitle">$284k of $1M goal</div>
        </div>
      </div>
      <div class="chart-area" style="height:240px">
        <div data-chart="gauge" style="width:100%;height:100%"></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Recent Orders</div>
          <div class="card-subtitle">Last 5 transactions</div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
              <tr>
                <td><span class="cell-strong">#{{ $order->id }}</span></td>
                <td>
                  <div class="cell-customer">
                    <div class="cell-avatar" style="background:var(--primary);width:24px;height:24px;font-size:10px;">
                      {{ $order->customer ? substr($order->customer->name, 0, 2) : 'G' }}
                    </div>
                    <span>{{ $order->customer ? $order->customer->name : 'Guest' }}</span>
                  </div>
                </td>
                <td class="cell-strong">${{ number_format($order->total_amount, 2) }}</td>
                <td>
                  <span class="status status-{{ $order->status == 'completed' ? 'green' : ($order->status == 'pending' ? 'yellow' : 'red') }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- ── Row 3: Pipeline stages + Lead sources donut ── -->
  <div class="row col-8-4">
    <div class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Upcoming Reservations</div>
          <div class="card-subtitle">Pending & confirmed</div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Guest</th>
                <th>Table</th>
                <th>Date/Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($upcomingReservations as $res)
              <tr>
                <td>
                  <div class="cell-customer">
                    <div class="cell-avatar" style="background:var(--blue);width:24px;height:24px;font-size:10px;">
                      {{ $res->customer ? substr($res->customer->name, 0, 2) : 'G' }}
                    </div>
                    <span>{{ $res->customer ? $res->customer->name : 'Guest' }}</span>
                  </div>
                </td>
                <td>{{ $res->table ? $res->table->table_number : 'N/A' }}</td>
                <td style="font-size:12px;">
                  {{ \Carbon\Carbon::parse($res->reservation_date)->format('M d') }}
                  <br>
                  {{ \Carbon\Carbon::parse($res->reservation_time)->format('h:i A') }}
                </td>
                <td>
                  <span class="status status-{{ $res->status == 'confirmed' ? 'green' : ($res->status == 'pending' ? 'yellow' : 'red') }}">
                    {{ ucfirst($res->status) }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div class="card-title">Quick Stats</div></div>
      <div class="card-body">
        <div style="display:flex;flex-direction:column;gap:12px">
          <div>
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px"><span class="cell-strong">Pending Reservations</span><span style="color:var(--text-muted)"><strong style="color:var(--text)">{{ $pendingReservations ?? 0 }}</strong> requests</span></div>
            <div class="progress-thin"><div class="bar" style="width:40%;background:var(--yellow)"></div></div>
          </div>
          <div>
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px"><span class="cell-strong">Conversion Rate</span><span style="color:var(--text-muted)"><strong style="color:var(--text)">87%</strong> avg</span></div>
            <div class="progress-thin"><div class="bar" style="width:87%;background:var(--green)"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection