<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Gari Bondhu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Animate.css for SweetAlert animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Translation Dictionaries -->
    <script src="/lang/en.js"></script>
    <script src="/lang/bn.js"></script>
    
    <script>
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: var(--bs-body-bg); }
        
        /* Dark Mode Specific Overrides */
        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] header.bg-white {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .bg-light {
            background-color: #2c2c2c !important;
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .form-label {
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .border, 
        [data-bs-theme="dark"] .border-bottom,
        [data-bs-theme="dark"] .border-top {
            border-color: #333 !important;
        }
        
        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background-color: #1a2a33;
            width: 250px;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        
        .sidebar.collapsed { width: 80px; }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .dropdown-toggle::after,
        .sidebar.collapsed hr { display: none; }
        .sidebar.collapsed .sidebar-brand-text { display: none; }
        .sidebar.collapsed .nav-link { text-align: center; padding-left: 0; padding-right: 0; }
        .sidebar.collapsed .nav-link i { margin-right: 0 !important; font-size: 1.25rem; }
        .sidebar.collapsed .submenu-caret { display: none; }
        
        /* Layout Wrapper */
        .content-wrapper {
            margin-left: 250px;
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper.collapsed { margin-left: 80px; }
        
        @media (max-width: 767.98px) {
            .sidebar { transform: translateX(-100%); width: 250px !important; }
            .sidebar.show { transform: translateX(0); }
            .sidebar.collapsed { transform: translateX(-100%); }
            .content-wrapper { margin-left: 0 !important; }
            
            /* Overlay */
            .sidebar-overlay {
                position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
                background: rgba(0,0,0,0.5); z-index: 1035; display: none;
            }
            .sidebar-overlay.show { display: block; }
        }

        .sidebar .nav-link { color: #ced4da; font-weight: 500; transition: all 0.2s; border-radius: 8px; margin: 2px 10px; }
        .sidebar .nav-link:hover { color: #fff; background-color: rgba(255,255,255,0.1); transform: translateX(4px); }
        .sidebar.collapsed .nav-link:hover { transform: scale(1.1); }
        .sidebar .nav-link.active { color: #fff; background-color: #0d6efd; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3); }
        
        .content-area { padding: 20px; }

        /* Glassmorphism Navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        [data-bs-theme="dark"] .glass-navbar {
            background: rgba(30, 30, 30, 0.85) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
    </style>
</head>
<body>
    <div id="app">
        
        <!-- Mobile Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 py-3" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-car-front-fill fs-3 text-primary ms-3 me-2"></i>
                <span class="fs-4 fw-bold sidebar-brand-text">RAC Admin</span>
            </a>
            <hr class="text-white">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span class="sidebar-text" data-i18n="admin_nav_dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check me-2"></i> <span class="sidebar-text" data-i18n="admin_nav_bookings">Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cars.index') }}" class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                        <i class="bi bi-car-front me-2"></i> <span class="sidebar-text" data-i18n="admin_nav_fleet">Fleet (Cars)</span>
                    </a>
                </li>
                <hr class="text-white">
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-people me-2"></i> <span class="sidebar-text" data-i18n="admin_nav_customers">Customers</span>
                    </a>
                </li>
                <li>
                    <a href="#settingsSubmenu" data-bs-toggle="collapse" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-gear me-2"></i> <span class="sidebar-text" data-i18n="admin_nav_settings">Settings</span> <i class="bi bi-caret-down-fill float-end mt-1 submenu-caret sidebar-text"></i>
                    </a>
                    <ul class="collapse nav flex-column ms-3 {{ request()->routeIs('admin.settings.*') ? 'show' : '' }}" id="settingsSubmenu" data-bs-parent=".nav-pills">
                        <li class="nav-item w-100">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link text-white {{ request()->routeIs('admin.settings.index') ? 'fw-bold text-primary' : '' }}">
                                <i class="bi bi-dot"></i> <span class="sidebar-text" data-i18n="admin_nav_general">General</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="{{ route('admin.settings.categories.index') }}" class="nav-link text-white {{ request()->routeIs('admin.settings.categories.*') ? 'fw-bold text-primary' : '' }}">
                                <i class="bi bi-dot"></i> <span class="sidebar-text" data-i18n="admin_nav_categories">Car Categories</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="{{ route('admin.settings.pricing_rules.index') }}" class="nav-link text-white {{ request()->routeIs('admin.settings.pricing_rules.*') ? 'fw-bold text-primary' : '' }}">
                                <i class="bi bi-dot"></i> <span class="sidebar-text" data-i18n="admin_nav_pricing_rules">Pricing Rules</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <hr class="text-white">
            <div class="dropdown mt-3 px-3">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->guard('admin')->user()->name ?? 'Admin') }}&background=0d6efd&color=fff" alt="mdo" width="32" height="32" class="rounded-circle me-2">
                    <strong class="sidebar-text">{{ auth()->guard('admin')->user()->name ?? 'Admin' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#" data-i18n="admin_nav_profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST" class="no-confirm">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" data-i18n="admin_nav_signout">Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="content-wrapper" id="contentWrapper">
            
            <!-- Topbar -->
            <header class="navbar navbar-expand-lg glass-navbar px-4 py-3 shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link text-dark text-decoration-none me-3" id="sidebarToggle" type="button">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarAdmin">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item me-2">
                                <button id="langToggleAdmin" class="btn btn-link text-dark nav-link" title="Toggle Language">
                                    <i class="bi bi-translate fs-5"></i> <span id="langLabel" class="fw-bold small ms-1">EN</span>
                                </button>
                            </li>
                            <!-- Theme Toggle -->
                            <li class="nav-item me-3">
                                <button class="btn btn-link nav-link px-2" id="theme-toggle" title="Toggle Theme">
                                    <i class="bi bi-moon-stars-fill"></i>
                                </button>
                            </li>

                            <!-- Notifications Dropdown -->
                            @php
                                $adminUser = auth()->guard('admin')->user();
                                $unreadNotifications = $adminUser ? $adminUser->unreadNotifications : collect();
                            @endphp
                            <li class="nav-item dropdown me-3">
                                <a class="nav-link position-relative" href="#" id="navbarDropdownNotifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell-fill fs-5"></i>
                                    @if($unreadNotifications->count() > 0)
                                        <span class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownNotifications" style="width: 320px; max-height: 400px; overflow-y: auto;">
                                    <li><h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                        Notifications
                                        @if($unreadNotifications->count() > 0)
                                            <form action="{{ route('admin.notifications.markAllRead') }}" method="POST" class="d-inline no-confirm m-0 p-0">
                                                @csrf
                                                <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0">Mark all read</button>
                                            </form>
                                        @endif
                                    </h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    @if($adminUser)
                                        @forelse($adminUser->notifications()->limit(5)->get() as $notification)
                                            <li class="{{ $notification->unread() ? 'bg-light' : '' }}">
                                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="no-confirm m-0 p-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-2 text-wrap" style="font-size: 0.85rem;">
                                                        @if($notification->unread()) <span class="badge bg-primary me-1">New</span> @endif
                                                        <strong>{{ $notification->data['message'] ?? 'New Notification' }}</strong><br>
                                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                        @empty
                                            <li><span class="dropdown-item text-center text-muted small">No notifications</span></li>
                                        @endforelse
                                    @endif
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill text-primary" href="/" target="_blank" data-i18n="admin_view_website">View Website <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="content-area flex-grow-1">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Vue 3 CDN -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('themeToggleAdmin');
            if (toggleBtn) {
                const icon = toggleBtn.querySelector('i');
                const current = document.documentElement.getAttribute('data-bs-theme');
                if (current === 'dark') {
                    icon.classList.replace('bi-moon-stars', 'bi-sun');
                    toggleBtn.classList.replace('text-dark', 'text-light');
                }

                toggleBtn.addEventListener('click', () => {
                    const theme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', theme);
                    localStorage.setItem('theme', theme);
                    
                    const langBtn = document.getElementById('langToggleAdmin');
                    
                    if(theme === 'dark') {
                        icon.classList.replace('bi-moon-stars', 'bi-sun');
                        toggleBtn.classList.replace('text-dark', 'text-light');
                        if (langBtn) langBtn.classList.replace('text-dark', 'text-light');
                    } else {
                        icon.classList.replace('bi-sun', 'bi-moon-stars');
                        toggleBtn.classList.replace('text-light', 'text-dark');
                        if (langBtn) langBtn.classList.replace('text-light', 'text-dark');
                    }
                });
            }
        });

        // Language Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const langToggle = document.getElementById('langToggleAdmin');
            const langLabel = document.getElementById('langLabel');
            let currentLang = localStorage.getItem('lang') || 'bn';
            
            const applyTranslations = (lang) => {
                if(!window.translations || !window.translations[lang]) return;
                
                const dict = window.translations[lang];
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if(dict[key]) {
                        el.innerText = dict[key];
                    }
                });
                
                if(langLabel) {
                    langLabel.innerText = lang === 'en' ? 'BN' : 'EN';
                }
            };
            
            // Check dark mode for the lang button
            if (langToggle && document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                langToggle.classList.replace('text-dark', 'text-light');
            }

            setTimeout(() => applyTranslations(currentLang), 100);

            if(langToggle) {
                langToggle.addEventListener('click', () => {
                    currentLang = currentLang === 'en' ? 'bn' : 'en';
                    localStorage.setItem('lang', currentLang);
                    applyTranslations(currentLang);
                });
            }

            // Sidebar Toggle Logic
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    // Check if mobile
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                        overlay.classList.toggle('show');
                    } else {
                        sidebar.classList.toggle('collapsed');
                        contentWrapper.classList.toggle('collapsed');
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("Success!") }}',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: 'top-end',
                    background: '#198754',
                    color: '#fff',
                    iconColor: '#fff',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Oops...") }}',
                    text: "{{ session('error') }}",
                    showConfirmButton: true,
                    confirmButtonColor: '#fff',
                    background: '#dc3545',
                    color: '#fff',
                    iconColor: '#fff',
                    customClass: { confirmButton: 'btn btn-outline-light' },
                    showClass: { popup: 'animate__animated animate__shakeX' }
                });
            @endif
            
            @if($errors->any())
                let errorHtml = '<ul class="text-start mb-0">';
                @foreach($errors->all() as $error)
                    errorHtml += '<li>{{ $error }}</li>';
                @endforeach
                errorHtml += '</ul>';
                
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Validation Error") }}',
                    html: errorHtml,
                    showConfirmButton: true,
                    confirmButtonColor: '#fff',
                    background: '#dc3545',
                    color: '#fff',
                    iconColor: '#fff',
                    customClass: { confirmButton: 'btn btn-outline-light' },
                    showClass: { popup: 'animate__animated animate__shakeX' }
                });
            @endif

            // Global Form Submit SweetAlert Confirmation
            const allPostForms = document.querySelectorAll('form[method="POST"]');
            allPostForms.forEach(form => {
                if(form.classList.contains('no-confirm')) return;
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    let isDelete = form.classList.contains('delete-form') || form.querySelector('input[name="_method"][value="DELETE"]');
                    let actionText = isDelete ? "You won't be able to revert this!" : "Do you want to save these changes?";
                    let confirmText = isDelete ? "Yes, delete it!" : "Yes, save it!";
                    let iconType = isDelete ? "warning" : "question";
                    let confirmColor = isDelete ? '#dc3545' : '#198754';
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: actionText,
                        icon: iconType,
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmText
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
