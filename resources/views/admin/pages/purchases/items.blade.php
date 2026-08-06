<!-- Purchase Items Modal -->
<div id="purchaseItemsModal" class="modal-backdrop" hidden>
    <div class="modal" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Purchase Items</h3>
            <button type="button" class="modal-close" onclick="closePurchaseModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body" style="padding: 0;">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-color-light);">
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted);">
                    <span>Purchase #<strong id="modalPurchaseId" style="color: var(--text);">-</strong></span>
                    <span>Date: <strong id="modalPurchaseDate" style="color: var(--text);">-</strong></span>
                </div>
            </div>
            
            <div style="padding: 16px 20px; max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color-light);">
                            <th style="text-align: left; padding: 8px 4px; color: var(--text-muted); font-weight: 600;">Item</th>
                            <th style="text-align: center; padding: 8px 4px; color: var(--text-muted); font-weight: 600;">Qty</th>
                            <th style="text-align: right; padding: 8px 4px; color: var(--text-muted); font-weight: 600;">Price</th>
                            <th style="text-align: right; padding: 8px 4px; color: var(--text-muted); font-weight: 600;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="modalItemsBody">
                        <!-- Items will be injected here via JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-color-light); display: flex; justify-content: flex-end;">
                <div style="text-align: right;">
                    <div style="font-size: 12px; color: var(--text-muted);">Grand Total</div>
                    <div style="font-size: 20px; font-weight: 700; color: var(--text);" id="modalGrandTotal">$0.00</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to open the modal and fetch data
    function viewPurchaseItems(purchaseId) {
        console.log("Function called! ID: " + purchaseId);
        const modal = document.getElementById('purchaseItemsModal');
        const purchaseIdEl = document.getElementById('modalPurchaseId');
        const purchaseDateEl = document.getElementById('modalPurchaseDate');
        const itemsBody = document.getElementById('modalItemsBody');
        const grandTotalEl = document.getElementById('modalGrandTotal');

        // Reset the modal
        itemsBody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">Loading items...</td></tr>';
        modal.hidden = false;

        // Fetch the data from the API
        fetch(`/api/purchases/${purchaseId}`)
            .then(response => {
                if (!response.ok) throw new Error('Purchase not found');
                return response.json();
            })
            .then(data => {
                // Update header
                purchaseIdEl.textContent = data.id;
                purchaseDateEl.textContent = new Date(data.purchase_date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                });

                // Calculate grand total
                let grandTotal = 0;
                
                // Build rows
                let rowsHtml = '';
                
                // If no items found
                if (data.purchase_items.length === 0) {
                    rowsHtml = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">No items found for this purchase.</td></tr>';
                } else {
                    data.purchase_items.forEach(item => {
                        const total = (item.quantity * item.price).toFixed(2);
                        grandTotal += parseFloat(total);
                        
                        rowsHtml += `
                            <tr style="border-bottom: 1px solid var(--border-color-light);">
                                <td style="padding: 10px 4px; font-weight: 500; color: var(--text);">
                                    ${item.inventory ? item.inventory.name : 'Unknown Item'}
                                </td>
                                <td style="padding: 10px 4px; text-align: center; color: var(--text-secondary);">
                                    ${item.quantity}
                                </td>
                                <td style="padding: 10px 4px; text-align: right; color: var(--text-secondary);">
                                    $${parseFloat(item.price).toFixed(2)}
                                </td>
                                <td style="padding: 10px 4px; text-align: right; font-weight: 500; color: var(--text);">
                                    $${total}
                                </td>
                            </tr>
                        `;
                    });
                }
                
                itemsBody.innerHTML = rowsHtml;
                grandTotalEl.textContent = '$' + grandTotal.toFixed(2);
            })
            .catch(error => {
                itemsBody.innerHTML = `<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--red);">Error: ${error.message}</td></tr>`;
            });
    }

    // Function to close the modal
    function closePurchaseModal() {
        document.getElementById('purchaseItemsModal').hidden = true;
    }

    // Close modal when clicking outside the box
    document.getElementById('purchaseItemsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePurchaseModal();
        }
    });
</script>