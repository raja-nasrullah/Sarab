@extends('admin.layouts.app')

@section('title', 'Tables | Gentelella 2026 v4')
@section('page', 'tables')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Data</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Customers</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Data</div>
                <h1 class="page-title">Customers</h1>
            </div>
            <div class="page-actions">
                <button class="btn btn-outline">Docs</button>
                <button class="btn btn-outline">Export</button>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 8h8M8 4v8"/>
                    </svg>
                    Add customer
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">All customers</div>
                <div class="card-subtitle">{{ $customers->count() }} total customers</div>
            </div>
            <div class="card-options" style="display:flex;gap:8px;align-items:center">
                <div class="search-box" style="width:200px">
                    <svg class="s-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="7" cy="7" r="5"/>
                        <path d="M11 11l3.5 3.5"/>
                    </svg>
                    <input type="text" id="table-search" placeholder="Search customers..." aria-label="Search customers">
                </div>
                <button class="btn btn-outline btn-sm">Export CSV</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="customers-table">
                <thead>
                    <tr>
                        <th style="width:32px">
                            <input type="checkbox" id="select-all" style="margin:0" aria-label="Select all rows">
                        </th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th style="width:32px"></th>
                    </tr>
                </thead>
                <tbody id="customers-tbody">
                    <!-- Rows rendered by JavaScript -->
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;font-size:13px;color:var(--text-muted)">
            <div id="table-info">Showing customers</div>
            <div class="pagination" id="table-pagination">
                <button class="page-btn" data-page="prev" disabled aria-label="Previous">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 4l-4 4 4 4"/></svg>
                </button>
                <button class="page-btn active" data-page="1">1</button>
                <button class="page-btn" data-page="next" aria-label="Next">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 4l4 4-4 4"/></svg>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Custom Toast Function (Kept the same)
        function showToast(message, options = {}) {
            const { variant = 'info', duration = 3000 } = options;
            
            const existing = document.querySelectorAll('.toast-container');
            existing.forEach(el => el.remove());
            
            const container = document.createElement('div');
            container.className = 'toast-container';
            
            const colors = {
                success: '#2fb344',
                error: '#d63939',
                warning: '#f59f00',
                info: '#1ABB9C'
            };
            
            container.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 9999;
                max-width: 400px;
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                padding: 16px 20px;
                font-size: 13px;
                color: #1a1a1a;
                border-left: 4px solid ${colors[variant] || colors.info};
                animation: slideIn 0.3s ease;
            `;
            
            container.innerHTML = `
                <div style="display:flex;align-items:center;gap:10px">
                    <span>${message}</span>
                    <button onclick="this.closest('.toast-container').remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:#999;font-size:18px;padding:0 4px;">×</button>
                </div>
            `;
            
            document.body.appendChild(container);
            
            setTimeout(() => {
                if (container.parentNode) {
                    container.style.opacity = '0';
                    container.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        if (container.parentNode) container.remove();
                    }, 300);
                }
            }, duration);
        }

        // Custom Menu Function (Kept the same)
        function openMenu(trigger, items) {
            const existing = document.querySelector('.dropdown-menu-container');
            if (existing) existing.remove();
            
            const container = document.createElement('div');
            container.className = 'dropdown-menu-container';
            container.style.cssText = `
                position: fixed;
                z-index: 9999;
                min-width: 180px;
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                padding: 6px 0;
                font-size: 13px;
                color: #1a1a1a;
            `;
            
            const rect = trigger.getBoundingClientRect();
            const left = Math.min(rect.left, window.innerWidth - 200);
            const top = Math.min(rect.bottom + 4, window.innerHeight - 300);
            container.style.left = left + 'px';
            container.style.top = top + 'px';
            
            items.forEach(item => {
                if (item === '-') {
                    const divider = document.createElement('div');
                    divider.style.cssText = 'height:1px;background:#e5e7eb;margin:4px 8px';
                    container.appendChild(divider);
                    return;
                }
                
                const btn = document.createElement('button');
                btn.textContent = item.label;
                btn.style.cssText = `
                    display: block;
                    width: 100%;
                    padding: 6px 16px;
                    border: none;
                    background: transparent;
                    text-align: left;
                    cursor: pointer;
                    color: #1a1a1a;
                    font-size: 13px;
                    transition: background 0.15s;
                    font-family: inherit;
                `;
                
                btn.addEventListener('mouseenter', () => {
                    btn.style.background = '#f3f4f6';
                });
                btn.addEventListener('mouseleave', () => {
                    btn.style.background = 'transparent';
                });
                
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    container.remove();
                    if (item.action) item.action();
                });
                
                container.appendChild(btn);
            });
            
            document.body.appendChild(container);
            
            setTimeout(() => {
                document.addEventListener('click', function closeMenu(e) {
                    if (!container.contains(e.target) && e.target !== trigger) {
                        container.remove();
                        document.removeEventListener('click', closeMenu);
                    }
                });
            }, 10);
            
            document.addEventListener('keydown', function closeOnEsc(e) {
                if (e.key === 'Escape') {
                    container.remove();
                    document.removeEventListener('keydown', closeOnEsc);
                }
            });
        }

        // ============================================
        // ✅ CUSTOMERS DATA FROM YOUR DATABASE
        // ============================================
        const customers = @json($customers);

        // Convert DB data to the format the JS expects
        const formattedCustomers = customers.map((customer, index) => ({
            id: customer.id,
            name: customer.name,
            initials: customer.name.substring(0, 2).toUpperCase(),
            color: ['primary', 'azure', 'purple', 'yellow', 'red', 'green', 'blue'][index % 7],
            phone: customer.phone || 'N/A',
            email: customer.email,
            status: 'Active', // Default status (since DB doesn't have it yet)
            joined: new Date(customer.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
        }));

        // ============================================
        // ✅ COLORS AND STATUSES
        // ============================================
        const colorMap = {
            primary: 'var(--primary)',
            azure: 'var(--azure)',
            purple: 'var(--purple)',
            yellow: 'var(--yellow)',
            red: 'var(--red)',
            green: 'var(--green)',
            blue: 'var(--blue)'
        };

        const statusColors = {
            'Active': 'green',
            'Pending': 'yellow',
            'Inactive': 'red',
            'Trial': 'blue'
        };

        // ============================================
        // ✅ PAGINATION AND SEARCH LOGIC
        // ============================================
        let currentPage = 1;
        const perPage = 10;
        let filteredCustomers = [...formattedCustomers];
        let searchTerm = '';

        function renderTable() {
            const search = searchTerm.toLowerCase();
            filteredCustomers = formattedCustomers.filter(c => 
                c.name.toLowerCase().includes(search) ||
                c.phone.toLowerCase().includes(search) ||
                c.email.toLowerCase().includes(search)
            );

            const totalPages = Math.ceil(filteredCustomers.length / perPage);
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageItems = filteredCustomers.slice(start, end);

            const tbody = document.getElementById('customers-tbody');
            if (!tbody) return;

            tbody.innerHTML = pageItems.map(c => `
                <tr data-id="${c.id}">
                    <td><input type="checkbox" class="row-cb" style="margin:0" aria-label="Select row"></td>
                    <td>
                        <div class="cell-customer">
                            <div class="cell-avatar" style="background:${colorMap[c.color]};color:white">${c.initials}</div>
                            <span class="cell-strong">${c.name}</span>
                        </div>
                    </td>
                    <td>${c.phone}</td>
                    <td>${c.email}</td>
                    <td><span class="status status-${statusColors[c.status]}">${c.status}</span></td>
                    <td>${c.joined}</td>
                    <td>
                        <button class="card-opt-btn row-menu" data-id="${c.id}" aria-label="Row actions">
                            <svg viewBox="0 0 16 16" fill="currentColor">
                                <circle cx="3" cy="8" r="1.4"/>
                                <circle cx="8" cy="8" r="1.4"/>
                                <circle cx="13" cy="8" r="1.4"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `).join('');

            // Update pagination
            const pagination = document.getElementById('table-pagination');
            if (!pagination) return;
            
            let paginationHtml = `
                <button class="page-btn" data-page="prev" ${currentPage <= 1 ? 'disabled' : ''} aria-label="Previous">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 4l-4 4 4 4"/></svg>
                </button>
            `;
            
            for (let i = 1; i <= Math.min(totalPages, 5); i++) {
                paginationHtml += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }
            
            if (totalPages > 5) {
                paginationHtml += `<span class="page-ellipsis">…</span>`;
                paginationHtml += `<button class="page-btn" data-page="${totalPages}">${totalPages}</button>`;
            }
            
            paginationHtml += `
                <button class="page-btn" data-page="next" ${currentPage >= totalPages ? 'disabled' : ''} aria-label="Next">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 4l4 4-4 4"/></svg>
                </button>
            `;
            
            pagination.innerHTML = paginationHtml;

            // Update info
            const total = filteredCustomers.length;
            const showing = Math.min(total, end);
            const infoEl = document.getElementById('table-info');
            if (infoEl) {
                infoEl.textContent = total > 0 ? `Showing ${start + 1}-${showing} of ${total} customers` : 'No customers found';
            }

            bindEvents();
        }

        function bindEvents() {
            // Search
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                const newInput = searchInput.cloneNode(true);
                searchInput.parentNode.replaceChild(newInput, searchInput);
                
                newInput.addEventListener('input', (e) => {
                    searchTerm = e.target.value;
                    currentPage = 1;
                    renderTable();
                });
            }

            // Select all
            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                const newSelectAll = selectAll.cloneNode(true);
                selectAll.parentNode.replaceChild(newSelectAll, selectAll);
                
                newSelectAll.addEventListener('change', function() {
                    document.querySelectorAll('.row-cb').forEach(cb => cb.checked = this.checked);
                });
            }

            // Pagination
            const pagination = document.getElementById('table-pagination');
            if (pagination) {
                const newPagination = pagination.cloneNode(true);
                pagination.parentNode.replaceChild(newPagination, pagination);
                
                newPagination.addEventListener('click', (e) => {
                    const btn = e.target.closest('.page-btn');
                    if (!btn || btn.disabled) return;
                    const page = btn.dataset.page;
                    const totalPages = Math.ceil(filteredCustomers.length / perPage);
                    
                    if (page === 'prev') currentPage = Math.max(1, currentPage - 1);
                    else if (page === 'next') currentPage = Math.min(totalPages, currentPage + 1);
                    else currentPage = parseInt(page);
                    
                    renderTable();
                });
            }

            // Row menu
            document.querySelectorAll('.row-menu').forEach(btn => {
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);
                
                newBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const id = parseInt(newBtn.dataset.id);
                    const customer = formattedCustomers.find(c => c.id === id);
                    if (!customer) return;
                    
                    openMenu(newBtn, [
                        { label: 'View profile', action: () => showToast(`Viewing ${customer.name}`) },
                        { label: 'Edit customer', action: () => showToast(`Editing ${customer.name}`) },
                        { label: 'Send email', action: () => showToast(`Email sent to ${customer.name}`) },
                        '-',
                        { label: 'Delete', action: () => showToast(`Deleted ${customer.name}`, { variant: 'error' }) }
                    ]);
                });
            });

            // Row checkboxes
            document.querySelectorAll('.row-cb').forEach(cb => {
                const newCb = cb.cloneNode(true);
                cb.parentNode.replaceChild(newCb, cb);
                
                newCb.addEventListener('change', function() {
                    const allChecked = document.querySelectorAll('.row-cb:checked').length;
                    const total = document.querySelectorAll('.row-cb').length;
                    const selectAllEl = document.getElementById('select-all');
                    if (selectAllEl) {
                        selectAllEl.checked = allChecked === total && total > 0;
                    }
                });
            });
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', renderTable);
    </script>
@endsection