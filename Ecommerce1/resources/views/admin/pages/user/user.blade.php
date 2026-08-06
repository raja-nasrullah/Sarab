@extends('admin.layouts.app')

@section('title', 'User Management | Gentelella 2026 v4')
@section('page', 'user-management')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item">Admin</span>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Users</span>
@endsection

@section('content')

  <div class="page-header">
    <div class="page-header-row">
      <div>
        <div class="page-pretitle">Admin</div>
        <h1 class="page-title">User management</h1>
      </div>
      <div class="page-actions">
        <button class="btn btn-outline">Export</button>
        <button class="btn btn-primary" id="invite-btn">+ Invite user</button>
      </div>
    </div>
  </div>

  <!-- Stat row (Dynamic from database) -->
  <div class="row col-3" style="margin-bottom:16px">
    <div class="card">
        <div class="stat">
            <div class="stat-icon teal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total users</div>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $users->count() }}</span>
                </div>
                <div class="stat-subtext">Registered users</div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="stat">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 1l3 6 6 .9-4.5 4.4 1 6.7L12 16l-5.5 3 1-6.7L3 7.9 9 7z"/></svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Recently joined</div>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $users->where('created_at', '>=', now()->subDays(7))->count() }}</span>
                </div>
                <div class="stat-subtext">Last 7 days</div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="stat">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Pending invites</div>
                <div class="stat-value-row">
                    <span class="stat-value">0</span>
                </div>
                <div class="stat-subtext">Awaiting acceptance</div>
            </div>
        </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" style="gap:12px;flex-wrap:wrap">
      <div class="users-filters">
        <div class="search-box" style="width:240px">
          <svg class="s-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="5"/><path d="M11 11l3.5 3.5"/></svg>
          <input type="text" id="users-search" placeholder="Search by name or email…" aria-label="Search users">
        </div>
        <select class="form-control" id="filter-role" style="width:140px;height:32px" aria-label="Filter by role">
          <option value="">All roles</option>
          <option value="Owner">Owner</option>
          <option value="Admin">Admin</option>
          <option value="Editor">Editor</option>
          <option value="Viewer">Viewer</option>
        </select>
        <select class="form-control" id="filter-status" style="width:140px;height:32px" aria-label="Filter by status">
          <option value="">All statuses</option>
          <option value="active">Active</option>
          <option value="pending">Pending</option>
          <option value="suspended">Suspended</option>
        </select>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th style="width:40px"><input type="checkbox" id="select-all" aria-label="Select all rows"></th>
              <th>User</th>
              <th>Role</th>
              <th>Status</th>
              <th>Last active</th>
              <th>Joined</th>
              <th data-orderable="false"></th>
            </tr>
          </thead>
          <tbody id="users-rows"></tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
    // ============================================
    // SETUP: Pass Laravel data to JavaScript
    // ============================================
    const DB_USERS = @json($users);
    
    // Convert Laravel collection to the format the JS expects
    // Since our database doesn't have roles, statuses, or last_active, we set defaults
    const USERS = DB_USERS.map((user, index) => ({
        name: user.name,
        email: user.email,
        ini: user.name.substring(0, 2).toUpperCase(),
        col: ['primary', 'azure', 'purple', 'yellow', 'red', 'green', 'blue'][index % 7],
        role: 'User', // Default role since database doesn't have one
        status: 'active', // Default status since database doesn't have one
        lastActive: '—',
        joined: new Date(user.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }),
        pending: false
    }));

    // ============================================
    // CONFIGURATION (From your original template)
    // ============================================
    const COLORS = { primary:'var(--primary)', azure:'var(--azure)', purple:'var(--purple)', yellow:'var(--yellow)', red:'var(--red)', green:'var(--green)', blue:'var(--blue)', gray:'var(--text-disabled)' };
    const STATUS_CLS = { active:'green', pending:'yellow', suspended:'red' };
    const ROLE_CLS   = { Owner:'purple', Admin:'red', Editor:'blue', Viewer:'green' };
    const ROLES = ['Owner', 'Admin', 'Editor', 'Viewer'];

    let filterText = '', filterRole = '', filterStatus = '';

    // ============================================
    // RENDER FUNCTION
    // ============================================
    function visible() {
      const q = filterText.toLowerCase();
      return USERS.filter((u) =>
        (!q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)) &&
        (!filterRole || u.role === filterRole) &&
        (!filterStatus || u.status === filterStatus)
      );
    }

    function render() {
      const rows = document.getElementById('users-rows');
      const items = visible();
      rows.innerHTML = items.map((u, idx) => `
        <tr data-email="${u.email}">
          <td><input type="checkbox" class="row-cb" aria-label="Select row"></td>
          <td>
            <div class="cell-customer">
              <div class="cell-avatar${u.pending ? ' pending' : ''}" style="background:${u.pending ? 'var(--bg-surface-secondary)' : COLORS[u.col]};color:${u.pending ? 'var(--text-muted)' : 'white'}">${u.ini}</div>
              <div>
                <div class="cell-strong">${u.pending ? '<em style="font-style:normal;color:var(--text-muted)">Invited</em>' : u.name}</div>
                <div style="font-size:11.5px;color:var(--text-muted)">${u.email}</div>
              </div>
            </div>
          </td>
          <td><button type="button" class="role-chip role-${ROLE_CLS[u.role]}" data-role-edit data-email="${u.email}">${u.role} <svg width="10" height="10" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 6l4 4 4-4"/></svg></button></td>
          <td><span class="status status-${STATUS_CLS[u.status]}">${u.status[0].toUpperCase() + u.status.slice(1)}</span></td>
          <td style="font-size:12.5px;color:var(--text-muted)">${u.lastActive}</td>
          <td style="font-size:12.5px;color:var(--text-muted)">${u.joined}</td>
          <td><button class="card-opt-btn" data-row-menu data-email="${u.email}" aria-label="More"><svg viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="3" r="1.2"/><circle cx="8" cy="8" r="1.2"/><circle cx="8" cy="13" r="1.2"/></svg></button></td>
        </tr>
      `).join('');
    }

    // ============================================
    // EVENT LISTENERS (Filters, Modals, Menus)
    // ============================================
    document.getElementById('users-search').addEventListener('input', (e) => { filterText = e.target.value; render(); });
    document.getElementById('filter-role').addEventListener('change', (e) => { filterRole = e.target.value; render(); });
    document.getElementById('filter-status').addEventListener('change', (e) => { filterStatus = e.target.value; render(); });

    document.getElementById('select-all').addEventListener('change', (e) => {
      document.querySelectorAll('#users-rows .row-cb').forEach((cb) => { cb.checked = e.target.checked; });
    });

    document.getElementById('users-rows').addEventListener('click', (e) => {
      const roleBtn = e.target.closest('[data-role-edit]');
      const moreBtn = e.target.closest('[data-row-menu]');
      
      // Role edit menu
      if (roleBtn) {
        e.stopPropagation();
        const email = roleBtn.dataset.email;
        const u = USERS.find((x) => x.email === email);
        if (!u) return;
        // Simple alert for now since we can't import openMenu from module
        alert(`Edit role for ${u.name}. Current role: ${u.role}`);
      } 
      // More options menu
      else if (moreBtn) {
        e.stopPropagation();
        const email = moreBtn.dataset.email;
        const u = USERS.find((x) => x.email === email);
        if (!u) return;
        alert(`Options for ${u.name}\n\nEmail: ${u.email}\nRole: ${u.role}\nStatus: ${u.status}`);
      }
    });

    // Invite user button
    document.getElementById('invite-btn').addEventListener('click', (e) => {
      e.stopPropagation();
      const email = prompt("Enter email address to invite:");
      if (email && email.trim() !== "") {
        USERS.push({ 
            name: email, 
            email: email, 
            ini: '?', 
            col: 'gray', 
            role: 'Editor', 
            status: 'pending', 
            lastActive: '—', 
            joined: 'just now', 
            pending: true 
        });
        render();
        alert(`Invite sent to ${email}`);
      }
    });

    // ============================================
    // INITIAL RENDER
    // ============================================
    render();
</script>
@endsection