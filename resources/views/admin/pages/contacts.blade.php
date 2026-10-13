@extends('admin.layouts.app')
@section('title', 'Contact Messages | Sarab 2026 v4')
@section('page', 'contacts')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Contact Messages</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Team</div>
                <h1 class="page-title">Contact Messages</h1>
            </div>
            <!-- <div class="page-actions">
                <button class="btn btn-outline">Export CSV</button>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 8h8M8 4v8"/></svg>
                    Refresh
                </button>
            </div> -->
        </div>
    </div>

    <div class="row col-3" id="contacts-grid"></div>
@endsection

@section('scripts')
    <script>
        // ============================================
        // ✅ PASS REAL CONTACT DATA FROM DATABASE
        // ============================================
        const dbContacts = @json($contacts);

        // Color palette for the avatars
        const colorMap = { 
            primary:'linear-gradient(135deg,var(--primary),var(--primary-dk))', 
            azure:'linear-gradient(135deg,var(--azure),#1d6fa5)', 
            purple:'linear-gradient(135deg,var(--purple),#8a2da0)', 
            yellow:'linear-gradient(135deg,var(--yellow),#c97f00)', 
            red:'linear-gradient(135deg,var(--red),#a82b2b)', 
            green:'linear-gradient(135deg,var(--green),#1a8a32)', 
            blue:'linear-gradient(135deg,var(--blue),#0550a0)' 
        };

        const colors = ['primary', 'azure', 'purple', 'yellow', 'red', 'green', 'blue'];

        // Format the database contacts into the card structure
        const contacts = dbContacts.map((contact, index) => [
            contact.name,           // Name
            contact.name.substring(0, 2).toUpperCase(), // Initials
            colors[index % colors.length], // Color
            contact.email,          // Role (Using Email as the subtitle)
            contact.subject,        // Subject (Using as "Projects" placeholder)
            contact.message,        // Message (Using as "Tasks" placeholder)
            contact.created_at      // Date (Using as "Messages" placeholder)
        ]);

        const grid = document.getElementById('contacts-grid');

        if (contacts.length === 0) {
            grid.innerHTML = `
                <div class="col-12 text-center" style="padding:60px 0;color:var(--text-muted);">
                    <h4>No contact messages yet</h4>
                    <p>Messages from the public contact form will appear here.</p>
                </div>
            `;
        } else {
            grid.innerHTML = contacts.map(([name, ini, col, email, subject, message, date], idx) => `
                <div class="contact-card" data-idx="${idx}">
                    <div class="av" style="background:${colorMap[col]}">${ini}</div>
                    <div class="name">${name}</div>
                    <div class="role" style="font-size:11px;color:var(--text-muted);">${email}</div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:12px;padding:0 8px;text-align:center;">
                        ${subject}
                    </div>
                    <div style="display:flex;gap:6px;justify-content:center;margin-bottom:12px">
                        <!-- <button class="btn btn-outline btn-sm" data-action="message">Reply</button> -->
                        <button class="btn btn-primary btn-sm" data-action="view">View</button>
                    </div>
                    <div class="stats">
                        <div><strong style="font-size:12px;">${message.substring(0, 20)}${message.length > 20 ? '...' : ''}</strong></div>
                        <div style="font-size:10px;color:var(--text-muted);margin-top:4px;">
                            ${new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Handle button clicks
        grid.addEventListener('click', (e) => {
            const card = e.target.closest('.contact-card');
            if (!card) return;
            const idx = parseInt(card.dataset.idx, 10);
            const c = contacts[idx];
            if (!c) return;
            const action = e.target.closest('[data-action]')?.dataset.action;
            const [name, , , email, subject, message] = c;
            
            if (action === 'message') {
                alert(`Reply to ${name} (${email})`);
            } else if (action === 'view') {
                alert(`Message from ${name}:\n\nSubject: ${subject}\nMessage: ${message}`);
            } else if (!e.target.closest('button')) {
                alert(`Contact: ${name}\nEmail: ${email}\nSubject: ${subject}`);
            }
        });
    </script>
@endsection