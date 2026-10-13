<!-- Your Custom CSS - NOW USING CORRECT PATHS -->
<link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">

<style>
    /* Dropdown Styles */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .user-dropdown-btn {
        background: var(--primary);
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 30px;
        color: white;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .user-dropdown-btn:hover {
        background: #15a08a;
    }
    
    .user-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 110%;
        min-width: 220px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        padding: 8px 0;
        z-index: 9999;
        border: 1px solid #eee;
    }
    
    .user-dropdown-menu.show {
        display: block;
    }
    
    .user-dropdown-menu .dropdown-header {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
    }
    
    .user-dropdown-menu .dropdown-header .name {
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }
    
    .user-dropdown-menu .dropdown-header .email {
        font-size: 12px;
        color: #6c757d;
    }
    
    .user-dropdown-menu .dropdown-header .role {
        font-size: 11px;
        color: #1abb9c;
        font-weight: 500;
        margin-top: 2px;
    }
    
    .user-dropdown-menu .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: #333;
        text-decoration: none;
        font-size: 13px;
        transition: background 0.2s;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }
    
    .user-dropdown-menu .dropdown-item:hover {
        background: #f5f5f5;
    }
    
    .user-dropdown-menu .dropdown-item i {
        width: 18px;
        text-align: center;
    }
    
    .user-dropdown-menu .dropdown-divider {
        margin: 6px 16px;
        border: none;
        border-top: 1px solid #eee;
    }
    
    .user-dropdown-menu .dropdown-item.logout {
        color: #dc3545;
    }
    
    .user-dropdown-menu .dropdown-item.logout:hover {
        background: #fce4e4;
    }

    /* 🛒 Cart Button Styles */
    .cart-btn-container {
        position: relative;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-size: 20px;
        transition: color 0.3s;
    }
    .cart-btn-container:hover {
        color: var(--primary);
    }
    .cart-badge {
        position: absolute;
        top: -6px;
        right: -8px;
        background: #dc3545;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50%;
        min-width: 18px;
        text-align: center;
        line-height: 14px;
        display: none; /* Hidden by default, JS shows it */
    }
    .cart-badge.show {
        display: block;
    }
</style>

<!-- ============================================================
     TOP BAR
     ============================================================ -->
<div id="topbar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="top-contact d-flex flex-wrap">
                <span><i class="fas fa-phone-alt"></i>+1 (800) 123-4567</span>
                <span><i class="fas fa-envelope"></i>hello@sarabfood.com</span>
                <span><i class="fas fa-map-marker-alt"></i>42 Flavor Street, NY</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="ttag">
                    <i class="fas fa-fire me-1"></i>Free Delivery Today!
                </span>

                <div class="tsoc">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     NAVBAR
     ============================================================ -->
<nav class="navbar navbar-expand-lg" id="nav">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="blogo">
                <div class="bico">
                    <i class="fas fa-utensils"></i>
                </div>

                <div>
                    <div class="bname">Sar<span>ab</span></div>
                    <div class="bsub">Fast Food & Restaurant</div>
                </div>
            </div>
        </a>


        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <i class="fas fa-bars" style="color:var(--primary);font-size:1.35rem;"></i>
        </button>


        <div class="collapse navbar-collapse" id="navmenu">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">
                        Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">
                        Reservation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        Contact
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <button id="navSearchBtn" title="Search">
                    <i class="fas fa-search"></i>
                </button>

                <!-- 🛒 ADDED: CART LINK WITH BADGE -->
                <!-- <a href="{{ route('cart.show') }}" class="cart-btn-container" title="View Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartBadge">0</span>
                </a> -->
                
                @if(Session::has('user'))
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <button class="user-dropdown-btn" id="userDropdownBtn" onclick="toggleDropdown()">
                            <i class="fas fa-user-circle" style="font-size:18px;"></i>
                            <span>{{ Session::get('user.name') }}</span>
                            <i class="fas fa-chevron-down" style="font-size:10px;"></i>
                        </button>
                        
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="dropdown-header">
                                <div class="name">{{ Session::get('user.name') }}</div>
                                <div class="email">{{ Session::get('user.email') }}</div>
                                <div class="role">Role: {{ Session::get('user.role') }}</div>
                            </div>
                            
                            <a href="{{ route('home') }}" class="dropdown-item">
                                <i class="fas fa-home"></i> Home
                            </a>
                            
                            @if(Session::get('user.role') === 'Administrator')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                                </a>
                            @endif
                            
                            <hr class="dropdown-divider">
                            
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="dropdown-item logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- If not logged in, show Sign Up -->
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="border-radius:30px;padding:6px 18px;">
                        <i class="fas fa-user-plus me-1"></i>
                        Sign Up
                    </a>
                @endif
                
                <a href="{{ route('menu') }}" class="nav-link nav-cta">
                    <i class="fas fa-shopping-bag me-1"></i>
                    Order Now
                </a>
            </div>

        </div>
    </div>
</nav>

<script src="{{ asset('assets/website/js/jquery-3.7.1.min.js') }}"></script>

<script>
function toggleDropdown() {
    var menu = document.getElementById('userDropdownMenu');
    if (menu.classList.contains('show')) {
        menu.classList.remove('show');
    } else {
        menu.classList.add('show');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    var dropdown = document.querySelector('.user-dropdown');
    if (dropdown && !dropdown.contains(event.target)) {
        var menu = document.getElementById('userDropdownMenu');
        if (menu) {
            menu.classList.remove('show');
        }
    }
});

// Close dropdown with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        var menu = document.getElementById('userDropdownMenu');
        if (menu) {
            menu.classList.remove('show');
        }
    }
});

// 🛒 Function to Update Cart Badge
function updateCartBadge() {
    // Fetch current cart count from the server using the route we made earlier
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartBadge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.add('show');
            } else {
                badge.classList.remove('show');
            }
        })
        .catch(err => console.error('Error fetching cart count:', err));
}

// Run on page load to set the initial count
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});
</script>