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
                Add New Purchase
            </h1>
            <p>Record new inventory stock arrival</p>
        </div>
        <a href="{{ route('admin.purchases') }}" class="btn-add-item" style="background:#6b7280;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Purchases
        </a>
    </div>

    <!-- Form Section -->
    <div class="menu-table-container" style="padding: 24px;">
        <form action="{{ route('admin.addpurchase.store') }}" method="POST" id="addPurchaseForm">
            @csrf

            <div class="form-row" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label for="purchase_date" class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" id="purchase_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                    @error('purchase_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Total Amount</label>
                    <input type="text" id="total_amount_display" class="form-control" value="$0.00" readonly style="background:var(--bg-surface-secondary);">
                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                </div>
            </div>

            <hr style="border-color: var(--border-color-light); margin: 20px 0;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h4 style="font-size: 1rem; font-weight: 600; color: var(--text);">Items Purchased</h4>
                <button type="button" id="addItemRow" class="btn btn-primary" style="height: 32px; padding: 0 12px; font-size: 12px;">
                    + Add Item
                </button>
            </div>

            <div id="itemsContainer">
                <div class="item-row" style="display: grid; grid-template-columns: 1fr 100px 100px 40px; gap: 12px; margin-bottom: 10px; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Inventory Item</label>
                        <select name="items[0][inventory_id]" class="form-control" required>
                            <option value="">Select Item</option>
                            @foreach($inventoryItems as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Qty</label>
                        <input type="number" name="items[0][quantity]" class="form-control" step="0.01" min="0.01" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="items[0][price]" class="form-control item-price" step="0.01" min="0" required>
                    </div>
                    <button type="button" class="action-btn btn-delete remove-item" style="margin-bottom: 0;">✕</button>
                </div>
            </div>

            <hr style="border-color: var(--border-color-light); margin: 20px 0;">

            <div class="form-actions right">
                <button type="submit" class="btn-add-item" style="border: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Save Purchase
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('itemsContainer');
    const addBtn = document.getElementById('addItemRow');
    let rowCount = 1;

    // Add new item row
    addBtn.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.className = 'item-row';
        newRow.style.cssText = 'display: grid; grid-template-columns: 1fr 100px 100px 40px; gap: 12px; margin-bottom: 10px; align-items: end;';
        newRow.innerHTML = `
            <div class="form-group" style="margin-bottom: 0;">
                <select name="items[${rowCount}][inventory_id]" class="form-control" required>
                    <option value="">Select Item</option>
                    @foreach($inventoryItems as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->unit }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="number" name="items[${rowCount}][quantity]" class="form-control" step="0.01" min="0.01" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <input type="number" name="items[${rowCount}][price]" class="form-control item-price" step="0.01" min="0" required>
            </div>
            <button type="button" class="action-btn btn-delete remove-item" style="margin-bottom: 0;">✕</button>
        `;
        container.appendChild(newRow);
        rowCount++;
    });

    // Remove item row
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            const row = e.target.closest('.item-row');
            if (container.children.length > 1) {
                row.remove();
                updateTotal();
            } else {
                alert('You must have at least one item.');
            }
        }
    });

    // Update total amount
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('input[name*="[price]"]').value) || 0;
            total += qty * price;
        });
        document.getElementById('total_amount').value = total.toFixed(2);
        document.getElementById('total_amount_display').value = '$' + total.toFixed(2);
    }

    // Listen for changes on quantity or price inputs
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[name*="[quantity]"], input[name*="[price]"]')) {
            updateTotal();
        }
    });
});
</script>
@endsection