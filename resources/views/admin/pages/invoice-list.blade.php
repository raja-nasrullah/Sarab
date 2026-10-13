@extends('admin.layouts.app')

@section('title', 'Invoices | Sarab 2026 v4')
@section('page', 'invoices')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Billing</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Invoices</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Billing</div>
                <h1 class="page-title">Invoices</h1>
            </div>
            <div class="page-actions">
                <button class="btn btn-outline">Export CSV</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">All Invoices</div>
                <div class="card-subtitle">Manage all billing records</div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                {{-- YAJRA DATATABLE FOR INVOICES --}}
                <table class="table" id="invoicesTable" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-color);">
                            <th>Invoice #</th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stat { display: flex; align-items: center; gap: 16px; padding: 16px; }
    .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
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
    $(document).ready(function() {
        // 1. Initialize DataTable for Invoices
        var table = $('#invoicesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/invoices/data",
            columns: [
                { 
                    data: 'invoice_number', 
                    name: 'invoice_number',
                    render: function(data) { 
                        return '<span style="font-weight:500;color:var(--text);">' + data + '</span>'; 
                    }
                },
                { 
                    data: 'order_id', 
                    name: 'order_id',
                    render: function(data) { 
                        return '<a href="' + '{{ route('admin.orders') }}' + '" style="color:var(--primary);text-decoration:none;">#' + data + '</a>'; 
                    }
                },
                { 
                    data: 'customer', 
                    name: 'customer',
                    render: function(data) {
                        if (!data) return 'Guest';
                        var initial = data.substring(0, 2).toUpperCase();
                        return '<div style="display:flex;align-items:center;gap:8px;"><div style="width:32px;height:32px;border-radius:50%;background:#1abb9c;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:12px;">' + initial + '</div><span style="font-weight:500;">' + data + '</span></div>';
                    }
                },
                { 
                    data: 'total_amount', 
                    name: 'total_amount',
                    render: function(data) { 
                        return '<span style="font-weight:600;">$' + parseFloat(data).toFixed(2) + '</span>'; 
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data) {
                        var bg = data == 'paid' ? '#28a74520' : '#ffc10720';
                        var color = data == 'paid' ? '#28a745' : '#ffc107';
                        return '<span style="background:' + bg + ';color:' + color + ';padding:4px 12px;border-radius:12px;font-size:11px;font-weight:600;">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                    }
                },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function(data) { 
                        return '<span style="font-size:13px;color:var(--text-muted);">' + new Date(data).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + '</span>'; 
                    }
                },
                { 
                    data: 'id', 
                    name: 'id',
                    orderable: false, 
                    searchable: false,
                    render: function(data) { 
                        // ✅ FIXED: Used direct URL concatenation without Laravel route()
                        return '<div style="display:flex;justify-content:flex-end;"><a href="/admin/invoice/' + data + '" class="tb-btn" aria-label="View Invoice" title="View Invoice"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg></a></div>'; 
                    }
                }
            ],
            responsive: true,
            order: [[0, 'desc']],
            pageLength: 10,
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> Loading...'
            }
        });
    });
</script>
@endsection