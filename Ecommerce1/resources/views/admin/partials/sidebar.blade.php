<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <div class="brand-icon">G</div>
            <div class="brand-name">Gentelella <span class="badge">v4</span></div>
        </a>
        <button class="sidebar-toggle" aria-label="Toggle sidebar">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
        <path d="M3 12h18M3 6h18M3 18h18"/>
    </svg>
</button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav">
            
            {{-- ============================================ --}}
            {{-- GENERAL SECTION --}}
            {{-- ============================================ --}}
            <li class="nav-section">
                <span class="nav-section-title">GENERAL</span>
            </li>

            {{-- Dashboards --}}
            <li class="nav-item nav-dropdown {{ request()->is('/') || request()->is('index*') ? 'open' : '' }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    <span>Dashboards</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="nav-link">Overview</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('index2') ? 'active' : '' }}">
                        <a href="{{ route('index2') }}" class="nav-link">Analytics</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('index3') ? 'active' : '' }}">
                        <a href="{{ route('index3') }}" class="nav-link">Sales</a>
                    </li>
                </ul>
            </li>

            {{-- Tables --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin.tables*') ? 'open' : '' }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <line x1="3" y1="9" x2="21" y2="9"/>
                        <line x1="3" y1="15" x2="21" y2="15"/>
                        <line x1="9" y1="21" x2="9" y2="9"/>
                    </svg>
                    <span>Tables</span>
                    <span class="badge badge-new" style="margin-left:auto;background:#3498db;color:white;padding:2px 8px;border-radius:12px;font-size:9px;line-height:1.4;text-transform:uppercase;font-weight:700">New</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item {{ request()->routeIs('admin.tables') ? 'active' : '' }}">
                        <a href="{{ route('admin.tables') }}" class="nav-link">Static</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.tables.dynamic') ? 'active' : '' }}">
                        <a href="{{ route('admin.tables.dynamic') }}" class="nav-link">Dynamic</a>
                    </li>
                </ul>
            </li>

            {{-- Charts --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin.chart*') ? 'open' : '' }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <line x1="18" y1="20" x2="18" y2="10"/>
                        <line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                    <span>Charts</span>
                    <span class="badge badge-new" style="margin-left:auto;background:#3498db;color:white;padding:2px 8px;border-radius:12px;font-size:9px;line-height:1.4;text-transform:uppercase;font-weight:700">New</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item {{ request()->routeIs('admin.charts') ? 'active' : '' }}">
                        <a href="{{ route('admin.charts') }}" class="nav-link">Chart cards</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.echarts') ? 'active' : '' }}">
                        <a href="{{ route('admin.echarts') }}" class="nav-link">ECharts gallery</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.other.charts') ? 'active' : '' }}">
                        <a href="{{ route('admin.other.charts') }}" class="nav-link">SVG charts</a>
                    </li>
                </ul>
            </li>

            {{-- ============================================ --}}
            {{-- E-COMMERCE SECTION --}}
            {{-- ============================================ --}}
            <li class="nav-section">
                <span class="nav-section-title">E-COMMERCE</span>
            </li>

            {{-- Storefront --}}
            <li class="nav-item {{ request()->routeIs('admin.ecommerce') ? 'active' : '' }}">
                <a href="{{ route('admin.ecommerce') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                    </svg>
                    <span>Storefront</span>
                </a>
            </li>

            {{-- Menu --}}
            <li class="nav-item {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                <a href="{{ route('admin.menu') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="4" y1="12" x2="20" y2="12"/>
                        <line x1="4" y1="18" x2="20" y2="18"/>
                    </svg>
                    <span>Menu</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.purchases') ? 'active' : '' }}">
                <a href="{{ route('admin.purchases') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Purchases</span>
                </a>
            </li>
            {{-- Reservations --}}
            <li class="nav-item {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                <a href="{{ route('admin.reservations') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M3 10h18M8 2v4M16 2v4"/>
                    </svg>
                    <span>Reservations</span>
                </a>
            </li>

            {{-- Product --}}
            <li class="nav-item {{ request()->routeIs('admin.product.detail') ? 'active' : '' }}">
                <a href="{{ route('admin.product.detail') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M21 16V8l-9-5-9 5v8l9 5 9-5z"/>
                        <path d="M3.3 7.3L12 12l8.7-4.7M12 22V12"/>
                    </svg>
                    <span>Product</span>
                </a>
            </li>

            {{-- Orders Dropdown --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin.order*') ? 'open' : '' }}">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    <span>Orders</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders') }}" class="nav-link">All orders</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.order.detail') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.detail') }}" class="nav-link">Order detail</a>
                    </li>
                </ul>
            </li>

            {{-- Invoice --}}
            <li class="nav-item {{ request()->routeIs('admin.invoices') ? 'active' : '' }}">
    <a href="{{ route('admin.invoices') }}" class="nav-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
            <rect x="2" y="5" width="20" height="14" rx="2"/>
            <line x1="2" y1="10" x2="22" y2="10"/>
        </svg>
        <span>Invoices</span>
    </a>
</li>

            {{-- Pricing --}}
            <li class="nav-item {{ request()->routeIs('admin.pricing.tables') ? 'active' : '' }}">
                <a href="{{ route('admin.pricing.tables') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M20 13l-7 7a2 2 0 01-2.83 0L3 12.83V4h8.83L20 12.17a2 2 0 010 2.83z"/>
                        <circle cx="7.5" cy="7.5" r="1.5"/>
                    </svg>
                    <span>Pricing</span>
                </a>
            </li>

            {{-- ============================================ --}}
            {{-- PROJECTS SECTION --}}
            {{-- ============================================ --}}
            <li class="nav-section">
                <span class="nav-section-title">PROJECTS</span>
            </li>

            {{-- All projects --}}
            <li class="nav-item {{ request()->routeIs('admin.projects') ? 'active' : '' }}">
                <a href="{{ route('admin.projects') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M3 7a2 2 0 012-2h4l2 2h7a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                    </svg>
                    <span>All projects</span>
                </a>
            </li>

            {{-- Project detail --}}
            <li class="nav-item {{ request()->routeIs('admin.project.detail') ? 'active' : '' }}">
                <a href="{{ route('admin.project.detail') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>Project detail</span>
                </a>
            </li>

            {{-- ============================================ --}}
            {{-- ADMIN SECTION --}}
            {{-- ============================================ --}}
            <li class="nav-section">
                <span class="nav-section-title">ADMIN</span>
            </li>
            {{-- Chat --}}
            <li class="nav-item {{ request()->routeIs('admin.chat') ? 'active' : '' }}">
                <a href="{{ route('admin.chat') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                    </svg>
                    <span>Chat</span>
                </a>
            </li>
            {{-- Contacts --}}
            <li class="nav-item {{ request()->routeIs('admin.contacts') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Contact Messages</span>
                </a>
            </li>

            {{-- User management --}}
            <li class="nav-item {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                <a href="{{ route('admin.user') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/>
                    </svg>
                    <span>User management</span>
                </a>
            </li>

            {{-- Your profile --}}
            <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Your profile</span>
                </a>
            </li>

            {{-- Settings --}}
            <li class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                    </svg>
                    <span>Settings</span>
                </a>
            </li>

            {{-- Help center --}}
            <li class="nav-item {{ request()->routeIs('admin.faq') ? 'active' : '' }}">
                <a href="{{ route('admin.faq') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.1 9a3 3 0 015.8 1c0 2-3 3-3 3"/>
                        <circle cx="12" cy="17" r="0.5" fill="currentColor"/>
                    </svg>
                    <span>Help center</span>
                </a>
            </li>

    {{-- ============================================ --}}
{{-- USER PROFILE AT BOTTOM WITH DROPDOWN --}}
{{-- ============================================ --}}
<div class="sidebar-footer">
    <div class="sidebar-user" id="sidebar-user-dropdown">
        <div class="user-avatar" style="background:linear-gradient(135deg,var(--primary),var(--primary-dk))">
            <span>A</span>
        </div>
        <div class="user-info">
            <div class="user-name">Aigars Silkalns</div>
            <div class="user-role">Admin</div>
        </div>
        <button class="user-settings" aria-label="User menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </button>
    </div>
    
    {{-- User Dropdown Menu --}}
    <div class="user-dropdown" id="user-dropdown" hidden>
        <div class="user-dropdown-header">
            <div class="user-dropdown-avatar" style="background:linear-gradient(135deg,var(--primary),var(--primary-dk))">
                <span>A</span>
            </div>
            <div>
                <div class="user-dropdown-name">Aigars Silkalns</div>
                <div class="user-dropdown-email">aigars@example.com</div>
            </div>
        </div>
        
        <div class="user-dropdown-divider"></div>
        
        <div class="user-dropdown-section">
            <div class="user-dropdown-label">ACCOUNT</div>
            <a href="{{ route('admin.profile') }}" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Your profile
            </a>
            <a href="{{ route('admin.settings') }}" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                </svg>
                Settings
            </a>
            <a href="#" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M3 9h18M9 21V9"/>
                </svg>
                Account settings
            </a>
        </div>
        
        <div class="user-dropdown-divider"></div>
        
        <div class="user-dropdown-section">
            <div class="user-dropdown-label">LAYOUTS</div>
            <a href="{{ route('admin.theme') }}" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 2v3M12 19v3M2 12h3M19 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>
                </svg>
                Theme generator
            </a>
        </div>
        
        <div class="user-dropdown-divider"></div>
        
        <div class="user-dropdown-section">
            <div class="user-dropdown-label">SUPPORT</div>
            <a href="#" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                </svg>
                Keyboard shortcuts
            </a>
            <a href="{{ route('admin.faq') }}" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.1 9a3 3 0 015.8 1c0 2-3 3-3 3"/>
                    <circle cx="12" cy="17" r="0.5" fill="currentColor"/>
                </svg>
                Help & support
            </a>
            <a href="{{ route('lock.screen') }}" class="user-dropdown-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                Lock screen
            </a>
        </div>
        
        <div class="user-dropdown-divider"></div>
        
        <div class="user-dropdown-footer">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;width:100%;">
                @csrf
                <button type="submit" class="user-dropdown-item user-dropdown-danger" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    </div>
</div>
</aside>