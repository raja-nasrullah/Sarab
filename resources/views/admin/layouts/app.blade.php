<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sarab 2026 v4')</title>
    
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    {{-- Vite Assets - SCSS and JS --}}
    @vite(['public/assets/admin/scss/main.scss', 'public/assets/admin/js/app.js'])
    @vite(['resources/js/app.js']) 

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Additional Styles --}}
    @stack('styles')
</head>
<body data-shell="admin" data-page="@yield('page', 'dashboard')" data-breadcrumb="@yield('breadcrumb', '')">

    {{-- Sidebar Backdrop (for mobile) --}}
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    {{-- Sidebar --}}
    @section('sidebar')
        <aside class="sidebar" id="sidebar">
            @include('admin.partials.sidebar')
        </aside>
    @show

    {{-- Main Content --}}
    <main class="main">
        <div class="page-wrapper">
            
            {{-- Header --}}
            @section('header')
                @include('admin.partials.header')
            @show

            {{-- Page Content --}}
            <div class="page-content">
                @yield('content')
            </div>

            {{-- Footer --}}
            @section('footer')
                @include('admin.partials.footer')
            @show

        </div>
    </main>

    {{-- Additional Scripts (if any) --}}
    @stack('scripts')
    
    {{-- Page specific scripts --}}
    @yield('scripts')

    {{-- ✅ PERFECT SIDEBAR TOGGLE SCRIPT --}}
        {{-- ✅ SIDEBAR RESIZE/DRAG SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const resizeHandle = document.getElementById('sidebar-resize-handle');
            const body = document.body;
            let isResizing = false;
            let startX, startWidth;

            if (!sidebar || !resizeHandle) return;

            resizeHandle.addEventListener('mousedown', function(e) {
                isResizing = true;
                startX = e.clientX;
                startWidth = sidebar.offsetWidth;
                body.style.cursor = 'col-resize';
                body.style.userSelect = 'none';
            });

            document.addEventListener('mousemove', function(e) {
                if (!isResizing) return;
                let newWidth = startWidth + (e.clientX - startX);
                if (newWidth < 64) newWidth = 64;
                if (newWidth > 450) newWidth = 450;
                sidebar.style.width = newWidth + 'px';
            });

            document.addEventListener('mouseup', function() {
                if (isResizing) {
                    isResizing = false;
                    body.style.cursor = 'default';
                    body.style.userSelect = 'auto';
                }
            });
        });
    </script>
    <!-- DataTables JS -->
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- Additional Scripts (if any) --}}
    @stack('scripts')
    
    {{-- Page specific scripts --}}
    @yield('scripts')
</body>
</html>