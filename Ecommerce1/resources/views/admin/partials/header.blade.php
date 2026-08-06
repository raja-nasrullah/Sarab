{{-- resources/views/partials/header.blade.php --}}
<header class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" type="button" aria-label="Open menu" aria-controls="sidebar" aria-expanded="false">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <span class="current" aria-current="page">Home</span>
        </nav>
    </div>

    <div class="search-box">
        <svg class="s-icon" width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <circle cx="7" cy="7" r="5"></circle>
            <path d="M11 11l3.5 3.5"></path>
        </svg>
        <input type="text" id="topbar-search" placeholder="Search pages or run a command…" aria-label="Search">
        <kbd>⌘K</kbd>
    </div>

    <div class="topbar-right">
        <a class="tb-btn tb-docs" href="https://gentelella.colorlib.com/docs/" target="_blank" rel="noopener" title="Documentation">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M4 4h11a4 4 0 014 4v13H8a4 4 0 01-4-4V4z"></path>
                <path d="M4 17a4 4 0 014-4h11"></path>
            </svg>
            <span>Docs</span>
        </a>

        <button class="tb-btn theme-toggle" type="button" title="Toggle theme" aria-label="Toggle theme" aria-pressed="false">
            <svg class="theme-icon-light" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
            </svg>
            <svg class="theme-icon-dark" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </button>

        <button class="tb-btn tb-notifications" type="button" title="Notifications" aria-label="Notifications" aria-haspopup="dialog" aria-expanded="false">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M12 3a6 6 0 00-6 6c0 6-3 7-3 7h18s-3-1-3-7a6 6 0 00-6-6z"></path>
                <path d="M10.5 21a1.5 1.5 0 003 0"></path>
            </svg>
            <span class="dot"></span>
        </button>

        <button class="tb-btn tb-messages" type="button" title="Messages" aria-label="Messages" aria-haspopup="dialog" aria-expanded="false">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <rect x="2" y="4" width="20" height="16" rx="3"></rect>
                <path d="M2 7l10 6 10-6"></path>
            </svg>
        </button>

        {{-- ============================================ --}}
        {{-- PROFILE DROPDOWN --}}
        {{-- ============================================ --}}
        <div class="header-dropdown profile-dropdown">
            <button class="tb-avatar" type="button" aria-label="Account menu" aria-haspopup="menu" aria-expanded="false" id="profile-dropdown-btn">
                <span class="avatar-letter">A</span>
                <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div class="dropdown-menu" id="profile-dropdown-menu">
                <div class="dropdown-header">
                    <div class="dropdown-user">
                        <div class="user-avatar" style="background:linear-gradient(135deg,var(--primary),var(--primary-dk));width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:14px">
                            A
                        </div>
                        <div>
                            <div class="user-name" style="font-size:13px;font-weight:600;color:var(--text)">Aigars Silkalns</div>
                            <div class="user-email" style="font-size:11px;color:var(--text-muted)">aigars@example.com</div>
                        </div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-section">
                    <div class="dropdown-label">ACCOUNT</div>
                    <a href="{{ route('admin.profile') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Profile
                    </a>
                    <a href="{{ route('admin.settings') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path>
                        </svg>
                        Account settings
                    </a>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-section">
                    <div class="dropdown-label">LAYOUTS</div>
                    <a href="{{ route('admin.theme') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 2v3M12 19v3M2 12h3M19 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"></path>
                        </svg>
                        Theme generator
                    </a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); alert('Keyboard shortcuts: ⌘K to search, ⌘/ for help')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                        </svg>
                        Keyboard shortcuts
                    </a>
                    <a href="{{ route('admin.faq') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.1 9a3 3 0 015.8 1c0 2-3 3-3 3"></path>
                            <circle cx="12" cy="17" r="0.5" fill="currentColor"></circle>
                        </svg>
                        Help & support
                    </a>
                    <a href="{{ route('lock.screen') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                            <path d="M7 11V7a5 5 0 0110 0v4"></path>
                        </svg>
                        Lock screen
                    </a>
                </div>

                <div class="dropdown-divider"></div>

                {{-- FIXED: Logout using POST form --}}
                <form method="POST" action="{{ route('logout') }}" style="margin:0;width:100%;">
    @csrf
    <button type="submit" class="dropdown-item dropdown-danger" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit;font-size:12.5px;padding:6px 16px;display:flex;align-items:center;gap:10px;color:var(--red);border-radius:var(--radius-sm);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Sign out
    </button>
</form>
            </div>
        </div>
    </div>
</header>