// resources/js/app.js
import '../scss/main.scss';
import '../js/charts.js'

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Gentelella 2026 v4 loaded successfully!');

    // ============================================
    // THEME TOGGLE
    // ============================================
    const themeToggle = document.querySelector('.theme-toggle');
    const htmlElement = document.documentElement;

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        htmlElement.setAttribute('data-theme', savedTheme);
        if (themeToggle) {
            themeToggle.setAttribute('aria-pressed', savedTheme === 'dark' ? 'true' : 'false');
        }
    } else {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            htmlElement.setAttribute('data-theme', 'dark');
            if (themeToggle) {
                themeToggle.setAttribute('aria-pressed', 'true');
            }
        }
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            this.setAttribute('aria-pressed', newTheme === 'dark' ? 'true' : 'false');
            document.documentElement.dispatchEvent(new Event('themechange'));
            console.log('Theme changed to:', newTheme);
        });
    }

    // ============================================
    // PROFILE DROPDOWN TOGGLE
    // ============================================
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileMenu = document.getElementById('profile-dropdown-menu');

    if (profileBtn && profileMenu) {
        profileMenu.classList.remove('show');
        profileBtn.setAttribute('aria-expanded', 'false');
        
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu !== profileMenu) {
                    menu.classList.remove('show');
                    const btn = document.querySelector(`[aria-controls="${menu.id}"]`);
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            });
            
            const isOpen = profileMenu.classList.contains('show');
            if (isOpen) {
                profileMenu.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                profileMenu.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                profileMenu.classList.remove('show');
                if (profileBtn) {
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && profileMenu.classList.contains('show')) {
                profileMenu.classList.remove('show');
                profileBtn.setAttribute('aria-expanded', 'false');
                profileBtn.focus();
            }
        });

        profileMenu.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                profileMenu.classList.remove('show');
                profileBtn.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // ============================================
    // SIDEBAR TOGGLE (FIXED)
    // ============================================
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.getElementById('sidebar') || document.querySelector('.sidebar');
    const body = document.body;
    const backdrop = document.getElementById('sidebar-backdrop') || document.querySelector('.sidebar-backdrop');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Sidebar toggle clicked!'); // Debug
            
            // Check if mobile
            if (window.innerWidth <= 768) {
                // Mobile: toggle overlay
                sidebar.classList.toggle('open');
                body.classList.toggle('sidebar-open');
                if (backdrop) {
                    backdrop.classList.toggle('show');
                }
            } else {
                // Desktop: toggle collapsed state
                body.classList.toggle('sidebar-collapsed');
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                console.log('Sidebar collapsed:', isCollapsed);
            }
        });
    }

    // Close sidebar on backdrop click (mobile)
    if (backdrop) {
        backdrop.addEventListener('click', function() {
            sidebar.classList.remove('open');
            body.classList.remove('sidebar-open');
            backdrop.classList.remove('show');
        });
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            body.classList.remove('sidebar-open');
            if (backdrop) {
                backdrop.classList.remove('show');
            }
        }
    });

    // Restore sidebar state (desktop only)
    if (window.innerWidth > 768) {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            body.classList.add('sidebar-collapsed');
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            body.classList.remove('sidebar-open');
            if (backdrop) {
                backdrop.classList.remove('show');
            }
            
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                body.classList.add('sidebar-collapsed');
            } else {
                body.classList.remove('sidebar-collapsed');
            }
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    });

    // ============================================
    // NAV DROPDOWN TOGGLE
    // ============================================
    const dropdownToggles = document.querySelectorAll('.nav-dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parent = this.closest('.nav-dropdown');
            if (parent) {
                parent.classList.toggle('open');
            }
        });
    });

    // ============================================
    // HEADER DROPDOWN TOGGLE (Notifications, Messages)
    // ============================================
    const dropdownBtns = document.querySelectorAll('.header-dropdown > .header-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.header-dropdown');
            const menu = dropdown.querySelector('.dropdown-menu');
            
            document.querySelectorAll('.header-dropdown .dropdown-menu.show').forEach(m => {
                if (m !== menu) {
                    m.classList.remove('show');
                }
            });
            
            if (menu) {
                menu.classList.toggle('show');
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.header-dropdown')) {
            document.querySelectorAll('.header-dropdown .dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // ============================================
    // FILE MANAGER BUTTONS
    // ============================================
    const newFolderBtn = document.getElementById('new-folder-btn');
    if (newFolderBtn) {
        newFolderBtn.addEventListener('click', function() {
            alert('New Folder button clicked!');
        });
    }

    const uploadBtn = document.getElementById('upload-btn');
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function() {
            alert('Upload button clicked!');
        });
    }

    const viewGridBtn = document.getElementById('view-grid');
    const viewListBtn = document.getElementById('view-list');
    const gridView = document.getElementById('fm-grid');

    if (viewGridBtn && viewListBtn && gridView) {
        viewGridBtn.addEventListener('click', function() {
            viewGridBtn.classList.add('active');
            viewListBtn.classList.remove('active');
            gridView.classList.remove('view-list');
            gridView.classList.add('view-grid');
        });

        viewListBtn.addEventListener('click', function() {
            viewListBtn.classList.add('active');
            viewGridBtn.classList.remove('active');
            gridView.classList.remove('view-grid');
            gridView.classList.add('view-list');
        });
    }

    // ============================================
    // INBOX BUTTONS
    // ============================================
    const markAllReadBtn = document.querySelector('.btn-outline');
    if (markAllReadBtn && markAllReadBtn.textContent.trim() === 'Mark all read') {
        markAllReadBtn.addEventListener('click', function() {
            alert('Mark all read clicked!');
        });
    }

    const composeBtn = document.querySelector('.btn-primary .btn-primary');
    if (composeBtn && composeBtn.textContent.trim() === 'Compose') {
        composeBtn.addEventListener('click', function() {
            alert('Compose button clicked!');
        });
    }

    // ============================================
    // PAGE ACTIONS BUTTONS
    // ============================================
    document.querySelectorAll('.page-actions .btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const btnText = this.textContent.trim();
            console.log(`Button clicked: ${btnText}`);
        });
    });

    console.log('All event listeners attached successfully!');
});

// ============================================
// FILE MANAGER INITIALIZATION
// ============================================
if (typeof initFileManager === 'undefined') {
    window.initFileManager = function() {
        console.log('File Manager initialized');
    };
}

// ============================================
// RE-INIT CHARTS ON THEME CHANGE
// ============================================
document.documentElement.addEventListener('themechange', function() {
    const chartsScript = document.querySelector('script[src*="charts"]');
    if (chartsScript) {
        console.log('Theme changed, charts will be re-rendered');
    }
});