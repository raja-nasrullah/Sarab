@extends('admin.layouts.app')

@section('title', 'Settings | Gentelella 2026 v4')
@section('page', 'settings')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Settings</span>
@endsection

@section('content')
    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-header-row">
                <div>
                    <div class="page-pretitle">Workspace</div>
                    <h1 class="page-title">Settings</h1>
                </div>
            </div>
        </div>

        <div class="settings-layout">
            <!-- ── SECTION NAV ── -->
            <aside class="settings-nav">
                <a class="settings-nav-link active" href="#account">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="8" cy="5" r="3"/>
                        <path d="M2 14a6 6 0 0112 0"/>
                    </svg> 
                    Account
                </a>
                <a class="settings-nav-link" href="#notifications">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8 2a4 4 0 00-4 4c0 4-2 5-2 5h12s-2-1-2-5a4 4 0 00-4-4z"/>
                        <path d="M7 14a1 1 0 002 0"/>
                    </svg> 
                    Notifications
                </a>
                <a class="settings-nav-link" href="#privacy">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8 1l6 2v4c0 4-3 7-6 8-3-1-6-4-6-8V3l6-2z"/>
                    </svg> 
                    Privacy & security
                </a>
                <a class="settings-nav-link" href="#appearance">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="8" cy="8" r="3"/>
                        <path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.2 3.2l1.4 1.4M11.4 11.4l1.4 1.4M3.2 12.8l1.4-1.4M11.4 4.6l1.4-1.4"/>
                    </svg> 
                    Appearance
                </a>
                <a class="settings-nav-link" href="#integrations">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="2" width="5" height="5" rx="1"/>
                        <rect x="9" y="2" width="5" height="5" rx="1"/>
                        <rect x="2" y="9" width="5" height="5" rx="1"/>
                        <rect x="9" y="9" width="5" height="5" rx="1"/>
                    </svg> 
                    Integrations
                </a>
                <a class="settings-nav-link" href="#billing">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="1" y="4" width="14" height="9" rx="1.5"/>
                        <path d="M1 7h14"/>
                    </svg> 
                    Billing
                </a>
                <a class="settings-nav-link" href="#team">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="6" cy="6" r="2.5"/>
                        <circle cx="11" cy="6" r="2"/>
                        <path d="M1 14a5 5 0 0110 0M11 9a4 4 0 014 5"/>
                    </svg> 
                    Team
                </a>
                <div class="settings-nav-sep"></div>
                <a class="settings-nav-link danger" href="#danger">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8 1l7 13H1L8 1z"/>
                        <path d="M8 6v4M8 12h.01"/>
                    </svg> 
                    Danger zone
                </a>
            </aside>

            <!-- ── SECTIONS ── -->
            <div class="settings-content">
                <!-- ACCOUNT -->
                <section class="settings-section" id="account">
                    <h2 class="settings-section-title">Account</h2>
                    <p class="settings-section-desc">Update your personal information and profile details.</p>
                    <form class="settings-form">
                        <div class="settings-row">
                            <label>Profile picture</label>
                            <div class="settings-control profile-control">
                                <div class="profile-preview" style="background:linear-gradient(135deg,var(--primary),var(--primary-dk))">A</div>
                                <div>
                                    <button type="button" class="btn btn-outline btn-sm">Upload new</button>
                                    <button type="button" class="btn btn-outline btn-sm">Remove</button>
                                    <div class="settings-hint">JPG, PNG, or GIF. Max 2 MB.</div>
                                </div>
                            </div>
                        </div>
                        <div class="settings-row">
                            <label for="full-name">Full name</label>
                            <input class="form-control" id="full-name" type="text" value="Aigars Silkalns" required>
                        </div>
                        <div class="settings-row">
                            <label for="email">Email address</label>
                            <input class="form-control" id="email" type="email" value="aigars@example.com" required>
                        </div>
                        <div class="settings-row">
                            <label for="role">Role</label>
                            <input class="form-control" id="role" type="text" value="Administrator">
                        </div>
                        <div class="settings-row">
                            <label for="timezone">Timezone</label>
                            <select class="form-control" id="timezone">
                                <option>(UTC+02:00) Riga</option>
                                <option>(UTC+00:00) London</option>
                                <option>(UTC-05:00) New York</option>
                                <option>(UTC-08:00) Los Angeles</option>
                            </select>
                        </div>
                        <div class="settings-actions">
                            <button type="reset" class="btn btn-outline">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </section>

                <!-- NOTIFICATIONS -->
                <section class="settings-section" id="notifications">
                    <h2 class="settings-section-title">Notifications</h2>
                    <p class="settings-section-desc">Choose what you want to be notified about.</p>
                    <div class="settings-toggle-list">
                        <div class="settings-toggle-row">
                            <div><div class="label">Email digest</div><div class="desc">Daily summary of your activity</div></div>
                            <div class="toggle on"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">Project updates</div><div class="desc">When projects you're on change status</div></div>
                            <div class="toggle on"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">@mentions</div><div class="desc">Push when someone mentions you in a comment</div></div>
                            <div class="toggle on"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">Marketing emails</div><div class="desc">Product news and newsletters</div></div>
                            <div class="toggle"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">Weekly report</div><div class="desc">Performance metrics every Monday</div></div>
                            <div class="toggle on"></div>
                        </div>
                    </div>
                </section>

                <!-- PRIVACY -->
                <section class="settings-section" id="privacy">
                    <h2 class="settings-section-title">Privacy & security</h2>
                    <p class="settings-section-desc">Manage how your account is secured.</p>
                    <div class="settings-toggle-list">
                        <div class="settings-toggle-row">
                            <div><div class="label">Two-factor authentication</div><div class="desc">Add a second factor to every login</div></div>
                            <div class="toggle on"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">Public profile</div><div class="desc">Allow your profile to be searchable</div></div>
                            <div class="toggle on"></div>
                        </div>
                        <div class="settings-toggle-row">
                            <div><div class="label">Activity tracking</div><div class="desc">Share usage data to improve the product</div></div>
                            <div class="toggle"></div>
                        </div>
                    </div>
                    <div class="settings-row" style="margin-top:16px">
                        <label>Active sessions</label>
                        <div class="settings-control session-list">
                            <div class="session-row">
                                <div><div class="device">MacBook Pro · Safari</div><div class="meta">Riga, LV · current session</div></div>
                                <span class="status status-green">Active</span>
                            </div>
                            <div class="session-row">
                                <div><div class="device">iPhone 15 · Mobile Safari</div><div class="meta">Riga, LV · 2h ago</div></div>
                                <button class="btn btn-outline btn-sm">Revoke</button>
                            </div>
                            <div class="session-row">
                                <div><div class="device">Chrome · Linux</div><div class="meta">London, UK · 3 days ago</div></div>
                                <button class="btn btn-outline btn-sm">Revoke</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- APPEARANCE -->
                <section class="settings-section" id="appearance">
                    <h2 class="settings-section-title">Appearance</h2>
                    <p class="settings-section-desc">Make the dashboard match your aesthetic.</p>
                    <div class="settings-row">
                        <label>Theme</label>
                        <div class="settings-control theme-options">
                            <label class="theme-option"><input type="radio" name="theme" value="light"><span>Light</span></label>
                            <label class="theme-option"><input type="radio" name="theme" value="dark"><span>Dark</span></label>
                            <label class="theme-option"><input type="radio" name="theme" value="system" checked><span>System</span></label>
                        </div>
                    </div>
                    <div class="settings-row">
                        <label>Density</label>
                        <div class="settings-control theme-options">
                            <label class="theme-option"><input type="radio" name="density" value="comfortable" checked><span>Comfortable</span></label>
                            <label class="theme-option"><input type="radio" name="density" value="compact"><span>Compact</span></label>
                        </div>
                    </div>
                </section>

                <!-- INTEGRATIONS -->
                <section class="settings-section" id="integrations">
                    <h2 class="settings-section-title">Integrations</h2>
                    <p class="settings-section-desc">Connect Gentelella with the tools you already use.</p>
                    <div class="integrations-grid">
                        <!-- Integration items -->
                    </div>
                </section>

                <!-- BILLING -->
                <section class="settings-section" id="billing">
                    <h2 class="settings-section-title">Billing</h2>
                    <p class="settings-section-desc">Manage your subscription and payment method.</p>
                    <div class="billing-current">
                        <div>
                            <div class="plan-name">Pro plan</div>
                            <div class="plan-meta">$29 / month · renews May 28, 2026</div>
                        </div>
                        <div style="display:flex;gap:6px">
                            <button class="btn btn-outline">Change plan</button>
                            <button class="btn btn-outline">Cancel</button>
                        </div>
                    </div>
                </section>

                <!-- TEAM -->
                <section class="settings-section" id="team">
                    <h2 class="settings-section-title">Team</h2>
                    <p class="settings-section-desc">Manage who can access this workspace.</p>
                    <div class="settings-actions" style="justify-content:flex-start;margin-bottom:12px">
                        <button class="btn btn-primary">+ Invite member</button>
                    </div>
                    <div class="session-list">
                        <!-- Team members -->
                    </div>
                </section>

                <!-- ─── DANGER ZONE ─── -->
                <section class="settings-section" id="danger">
                    <h2 class="settings-section-title">Danger zone</h2>
                    <p class="settings-section-desc">Irreversible actions. Be careful.</p>
                    
                    <!-- Export Data -->
                    <div class="danger-row">
                        <div>
                            <div class="label">Export all data</div>
                            <div class="desc">Download a JSON archive of everything in this workspace</div>
                        </div>
                        <button class="btn btn-outline" id="export-data-btn">Export</button>
                    </div>
                    
                    <!-- Transfer Ownership -->
                    <div class="danger-row">
                        <div>
                            <div class="label">Transfer ownership</div>
                            <div class="desc">Transfer ownership to another team member. You'll keep your account but lose admin privileges.</div>
                        </div>
                        <button class="btn btn-outline" id="transfer-ownership-btn">Transfer</button>
                    </div>
                    
                    <!-- Delete Account -->
                    <div class="danger-row danger-critical">
                        <div>
                            <div class="label">Delete account</div>
                            <div class="desc">Permanently delete this account and all associated data</div>
                        </div>
                        <button class="btn btn-outline" style="color:var(--red);border-color:var(--red)" id="delete-account-btn">Delete</button>
                    </div>
                </section>
            </div>
        </div>

    </div>

    {{-- ─── MODALS ─── --}}

    {{-- Transfer Modal --}}
    <div class="modal-backdrop" id="transfer-modal-backdrop" hidden>
        <div class="modal" id="transfer-modal" role="dialog" aria-modal="true">
            <div class="modal-header">
                <h3 class="modal-title">Transfer workspace ownership</h3>
                <button class="modal-close" data-modal-close aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 3l10 10M13 3L3 13"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:16px">
                    Transfer ownership to another team member. You'll keep your account but lose admin privileges.
                </p>
                <div class="form-group">
                    <label class="form-label" for="transfer-user">Transfer to</label>
                    <select class="form-control" id="transfer-user">
                        <option value="sarah@example.com">Sarah Kowalski (sarah@example.com)</option>
                        <option value="michael@example.com">Michael Reyes (michael@example.com)</option>
                        <option value="emily@example.com">Emily Wang (emily@example.com)</option>
                        <option value="diego@example.com">Diego Reyes (diego@example.com)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Cancel</button>
                <button class="btn btn-danger" id="confirm-transfer">Transfer</button>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div class="modal-backdrop" id="delete-modal-backdrop" hidden>
        <div class="modal" id="delete-modal" role="dialog" aria-modal="true">
            <div class="modal-header">
                <h3 class="modal-title" style="color:var(--red)">Delete account permanently?</h3>
                <button class="modal-close" data-modal-close aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 3l10 10M13 3L3 13"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="margin-bottom:16px">
                    <svg class="alert-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="8" cy="8" r="6"/>
                        <path d="M5 5l6 6M11 5l-6 6"/>
                    </svg>
                    <div class="alert-body">
                        <strong>Warning!</strong> This will permanently delete your account, all projects, and all associated data. This action cannot be undone.
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="delete-confirm">
                        Type <strong style="color:var(--red)">DELETE</strong> to confirm
                    </label>
                    <input class="form-control" id="delete-confirm" type="text" placeholder="Type DELETE here..." autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Cancel</button>
                <button class="btn btn-danger" id="confirm-delete" disabled>Delete account</button>
            </div>
        </div>
    </div>

    {{-- Toast container --}}
    <div id="toast-container" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px"></div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── Toast System ───
            function showToast(message, options = {}) {
                const { variant = 'info', duration = 3000 } = options;
                const container = document.getElementById('toast-container');
                
                const colors = {
                    success: '#2fb344',
                    error: '#d63939',
                    warning: '#f59f00',
                    info: '#1ABB9C'
                };
                
                const toast = document.createElement('div');
                toast.style.cssText = `
                    background: #fff;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                    padding: 14px 20px;
                    font-size: 13px;
                    color: #1a1a1a;
                    border-left: 4px solid ${colors[variant] || colors.info};
                    animation: slideIn 0.3s ease;
                    min-width: 280px;
                    max-width: 400px;
                `;
                
                toast.innerHTML = `
                    <div style="display:flex;align-items:center;gap:10px">
                        <span>${message}</span>
                        <button onclick="this.closest('div').remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:#999;font-size:18px;padding:0 4px;">×</button>
                    </div>
                `;
                
                container.appendChild(toast);
                
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.style.opacity = '0';
                        toast.style.transition = 'opacity 0.3s';
                        setTimeout(() => {
                            if (toast.parentNode) toast.remove();
                        }, 300);
                    }
                }, duration);
            }

            // ─── Modal System ───
            function openModal(modalId) {
                const backdrop = document.getElementById(modalId + '-backdrop');
                const modal = document.getElementById(modalId);
                if (backdrop) {
                    backdrop.hidden = false;
                    document.body.style.overflow = 'hidden';
                    setTimeout(() => {
                        const firstInput = modal?.querySelector('input, select, button:not(.modal-close)');
                        if (firstInput) firstInput.focus();
                    }, 50);
                }
            }

            function closeModal(modalId) {
                const backdrop = document.getElementById(modalId + '-backdrop');
                if (backdrop) {
                    backdrop.hidden = true;
                    document.body.style.overflow = '';
                }
            }

            // ─── EXPORT DATA (Downloads JSON file) ───
            document.getElementById('export-data-btn').addEventListener('click', function() {
                showToast('Exporting data... This may take a moment', { variant: 'info' });
                
                // Simulate data export - in real app, this would fetch from API
                const exportData = {
                    workspace: 'Gentelella',
                    exported_at: new Date().toISOString(),
                    users: [
                        { id: 1, name: 'Aigars Silkalns', email: 'aigars@example.com', role: 'Owner' },
                        { id: 2, name: 'Sarah Kowalski', email: 'sarah@example.com', role: 'Admin' },
                        { id: 3, name: 'Michael Reyes', email: 'michael@example.com', role: 'Editor' }
                    ],
                    projects: [
                        { id: 1, name: 'Acme Website Redesign', status: 'In Progress' },
                        { id: 2, name: 'Mobile App v2', status: 'Planning' }
                    ],
                    settings: {
                        theme: 'system',
                        density: 'comfortable',
                        notifications: true
                    }
                };

                // Create and download the file
                setTimeout(() => {
                    try {
                        const json = JSON.stringify(exportData, null, 2);
                        const blob = new Blob([json], { type: 'application/json' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `export-${new Date().toISOString().slice(0, 10)}.json`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                        
                        showToast('Data exported successfully!', { variant: 'success' });
                    } catch (error) {
                        showToast('Error exporting data: ' + error.message, { variant: 'error' });
                    }
                }, 1500);
            });

            // ─── Transfer Ownership ───
            document.getElementById('transfer-ownership-btn').addEventListener('click', function() {
                openModal('transfer-modal');
            });

            document.getElementById('confirm-transfer').addEventListener('click', function() {
                const select = document.getElementById('transfer-user');
                const user = select.value;
                const name = select.selectedOptions[0].text;
                closeModal('transfer-modal');
                showToast(`Workspace ownership transferred to ${name}`, { variant: 'success' });
            });

            // ─── Delete Account ───
            document.getElementById('delete-account-btn').addEventListener('click', function() {
                openModal('delete-modal');
                document.getElementById('delete-confirm').value = '';
                document.getElementById('confirm-delete').disabled = true;
            });

            document.getElementById('delete-confirm').addEventListener('input', function() {
                const confirmBtn = document.getElementById('confirm-delete');
                confirmBtn.disabled = this.value.trim() !== 'DELETE';
            });

            document.getElementById('confirm-delete').addEventListener('click', function() {
                if (this.disabled) return;
                closeModal('delete-modal');
                showToast('Account deleted successfully', { variant: 'error' });
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 1500);
            });

            // ─── Modal Close Handlers ───
            document.querySelectorAll('[data-modal-close]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    if (modal) {
                        closeModal(modal.id);
                    }
                });
            });

            document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                backdrop.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const modal = this.querySelector('.modal');
                        if (modal) {
                            closeModal(modal.id);
                        }
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-backdrop:not([hidden])').forEach(function(backdrop) {
                        const modal = backdrop.querySelector('.modal');
                        if (modal) {
                            closeModal(modal.id);
                        }
                    });
                }
            });

            // ─── Section Nav ───
            const navLinks = document.querySelectorAll('.settings-nav-link');
            navLinks.forEach(function(a) {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        navLinks.forEach(function(l) { l.classList.remove('active'); });
                        this.classList.add('active');
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // ─── Auto-highlight nav link on scroll ───
            const sections = document.querySelectorAll('.settings-section');
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        navLinks.forEach(function(l) {
                            l.classList.toggle('active', l.getAttribute('href') === '#' + id);
                        });
                    }
                });
            }, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });
            sections.forEach(function(s) { observer.observe(s); });

            // ─── Toggle switches ───
            document.querySelectorAll('.toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    this.classList.toggle('on');
                });
            });
        });
    </script>

    <style>
        /* ─── Toast Animation ─── */
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* ─── Modal Styles ─── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-backdrop[hidden] {
            display: none !important;
        }

        .modal {
            background: var(--bg-surface, #fff);
            border-radius: var(--radius-lg, 12px);
            max-width: 480px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 24px 64px rgba(15, 23, 42, 0.2);
            animation: modalIn 0.25s ease;
        }

        @keyframes modalIn {
            from { transform: scale(0.95) translateY(10px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border-color-light);
        }

        .modal-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--text-muted);
            border-radius: var(--radius-sm);
            transition: background 120ms, color 120ms;
        }

        .modal-close:hover {
            background: var(--bg-surface-secondary);
            color: var(--text);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            padding: 16px 24px 20px;
            border-top: 1px solid var(--border-color-light);
        }

        .modal-footer .btn {
            min-width: 80px;
        }

        .btn-danger {
            background: var(--red);
            color: #fff;
            border: 1px solid var(--red);
            padding: 6px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 120ms, opacity 120ms;
        }

        .btn-danger:hover {
            background: var(--red-dk, #b32b2b);
        }

        .btn-danger:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-danger:disabled:hover {
            background: var(--red);
        }

        /* ─── Danger Zone Styles ─── */
        .danger-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color-light);
            gap: 12px;
        }

        .danger-row:last-child {
            border-bottom: none;
        }

        .danger-row .label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .danger-row .desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .danger-row.danger-critical .label {
            color: var(--red);
        }

        .danger-row .btn {
            flex-shrink: 0;
        }
    </style>
@endsection