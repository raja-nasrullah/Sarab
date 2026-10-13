@extends('admin.layouts.app')

@section('content')
<div class="p-6">

    <!-- Header Section -->
    <div class="menu-page-header">
        <div class="header-title-wrapper">
            <h1>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Purchase History
            </h1>
            <p>Track all inventory restocking purchases</p>
        </div>
        <a href="{{ route('admin.addpurchase') }}" class="btn-add-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Purchase
        </a>
    </div>

    <!-- Table Section -->
    <div class="menu-table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                    <tr>
                        <td class="col-id">#{{ $purchase->id }}</td>
                        <td class="col-name">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</td>
                        <td class="col-price">${{ number_format($purchase->total_amount, 2) }}</td>
                        <td class="col-actions">
                            <a href="javascript:void(0);" onclick="viewPurchaseItems({{ $purchase->id }})" class="action-btn btn-edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Items
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:24px;color:#888;">
                            No purchases found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Purchase Items Modal --}}
<div id="purchaseItemsModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;max-width:650px;width:90%;max-height:80vh;overflow:auto;padding:20px;position:relative;">
        <button onclick="closePurchaseModal()" style="position:absolute;top:10px;right:14px;background:none;border:none;font-size:22px;cursor:pointer;">&times;</button>
        <h3 style="margin-top:0;">Purchase Items</h3>
        <div id="purchaseItemsBody">Loading…</div>
    </div>
</div>

<script>
function viewPurchaseItems(id) {
    const modal = document.getElementById('purchaseItemsModal');
    const body  = document.getElementById('purchaseItemsBody');
    body.innerHTML = 'Loading…';
    modal.style.display = 'flex';

    fetch(`/admin/purchases/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        // Support both snake_case and camelCase responses
        const items = data.purchase_items || data.purchaseItems || [];

        if (!items.length) {
            body.innerHTML = '<p>No items found for this purchase.</p>';
            return;
        }

        let html = `<table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd;">Item</th>
                    <th style="text-align:right;padding:8px;border-bottom:1px solid #ddd;">Qty</th>
                    <th style="text-align:right;padding:8px;border-bottom:1px solid #ddd;">Price</th>
                    <th style="text-align:right;padding:8px;border-bottom:1px solid #ddd;">Subtotal</th>
                </tr>
            </thead>
            <tbody>`;

        items.forEach(item => {
            const name = (item.inventory && item.inventory.name) ? item.inventory.name : 'Item #' + (item.inventory_id ?? '');
            const qty  = parseFloat(item.quantity) || 0;
            const pr   = parseFloat(item.price)    || 0;
            html += `<tr>
                <td style="padding:8px;border-bottom:1px solid #eee;">${name}</td>
                <td style="text-align:right;padding:8px;border-bottom:1px solid #eee;">${qty}</td>
                <td style="text-align:right;padding:8px;border-bottom:1px solid #eee;">$${pr.toFixed(2)}</td>
                <td style="text-align:right;padding:8px;border-bottom:1px solid #eee;">$${(qty * pr).toFixed(2)}</td>
            </tr>`;
        });

        html += '</tbody></table>';
        body.innerHTML = html;
    })
    .catch(err => {
        console.error('Failed to load purchase items:', err);
        body.innerHTML = '<p style="color:red;">Failed to load items.</p>';
    });
}

function closePurchaseModal() {
    document.getElementById('purchaseItemsModal').style.display = 'none';
}

// Close on backdrop click
document.addEventListener('click', function (e) {
    const modal = document.getElementById('purchaseItemsModal');
    if (e.target === modal) closePurchaseModal();
});

// Close on ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closePurchaseModal();
});
</script>

@endsection