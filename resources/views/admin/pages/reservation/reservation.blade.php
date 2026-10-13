@extends('admin.layouts.app')

@section('title', 'Reservations | Sarab 2026 v4')
@section('page', 'reservations')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Restaurant</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Reservations</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Restaurant</div>
                <h1 class="page-title">Reservations</h1>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.reservations.export') }}" class="btn btn-outline">
                    Export CSV
                </a>
                <a href="{{ route('admin.addreservation') }}" class="btn btn-primary">
                    + Add Reservation
                </a>
            </div>
        </div>
    </div>

    <!-- Stat row -->
    <div class="row col-3" style="margin-bottom:16px">
        <div class="card">
            <div class="stat">
                <div class="stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M3 10h18M8 2v4M16 2v4"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Reservations</div>
                    <div class="stat-value-row">
                        <span class="stat-value">{{ $reservations->count() }}</span>
                    </div>
                    <div class="stat-subtext">All time bookings</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="stat">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Confirmed</div>
                    <div class="stat-value-row">
                        <span class="stat-value">{{ $reservations->where('status', 'confirmed')->count() }}</span>
                    </div>
                    <div class="stat-subtext">Ready for guests</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="stat">
                <div class="stat-icon yellow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value-row">
                        <span class="stat-value">{{ $reservations->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="stat-subtext">Awaiting confirmation</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">All Reservations</div>
                <div class="card-subtitle">{{ $reservations->count() }} results</div>
            </div>
            <div class="card-options">
                <label style="font-size:11.5px;color:var(--text-muted);margin-right:6px">Status</label>
                <select class="form-control" style="width:170px;height:32px" id="status-filter">
                    <option value="all">All statuses</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table" id="reservationsTable" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-color);">
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Table</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guests</th>
                            <th>Status</th>
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
    $(document).ready(function() {
        // Initialize DataTable with search box hidden
        var table = $('#reservationsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/reservations/data",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'customer', name: 'customer' },
                { data: 'table', name: 'table' },
                { data: 'reservation_date', name: 'reservation_date' },
                { data: 'reservation_time', name: 'reservation_time' },
                { data: 'guests', name: 'guests' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            responsive: true,
            order: [[0, 'desc']],
            pageLength: 10,
            searching: false,          // 👈 Hides the search box
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> Loading...'
            }
        });

        // Status filter
        const statusFilter = document.getElementById('status-filter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value.toLowerCase();
                if (selectedStatus === 'all') {
                    table.column(6).search('').draw();
                } else {
                    table.column(6).search(selectedStatus, true, false).draw();
                }
            });
        }
    });
</script>
@endsection