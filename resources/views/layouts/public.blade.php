<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gari Bondhu | Premium Car Rental</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Animate.css for SweetAlert animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Translation Dictionaries -->
    <script src="/lang/en.js"></script>
    <script src="/lang/bn.js"></script>
    
    <!-- Vue App Initialization -->
    <script>
        // Set theme immediately to prevent flash
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
    </script>
    
    <style>
        :root {
            /* California Beaches Palette */
            --theme-color-1: #FFC067;
            --theme-color-2: #66F4FF;
            --theme-color-3: #66C4FF;
            --theme-color-4: #7D99AA;

            /* Override Bootstrap Primary (Using the blue as primary) */
            --bs-primary: var(--theme-color-3);
            --bs-primary-rgb: 102, 196, 255;
        }

        body { 
            font-family: 'Inter', sans-serif;
            padding-top: 60px;
            padding-bottom: 60px;
            background-color: var(--bs-body-bg); 
        }

        /* Dark Mode Specific Overrides */
        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .card {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .bg-light {
            background-color: #2c2c2c !important;
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .text-dark {
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .border, 
        [data-bs-theme="dark"] .border-bottom,
        [data-bs-theme="dark"] .border-top {
            border-color: #333 !important;
        }

        /* Polished UI Overrides */
        .btn-primary {
            background-color: var(--theme-color-3) !important;
            border-color: var(--theme-color-3) !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(102, 196, 255, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #55b3ed !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 196, 255, 0.4);
        }

        .text-primary {
            color: var(--theme-color-3) !important;
        }
        .bg-primary {
            background-color: var(--theme-color-3) !important;
        }
        
        .badge.bg-primary {
            background-color: var(--theme-color-3) !important;
            color: #fff;
        }

        /* Card Styling */
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 40px rgba(102, 196, 255, 0.08) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        /* Top accent border for all cards */
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--theme-color-1), var(--theme-color-2), var(--theme-color-3), var(--theme-color-4));
        }

        /* Sidebar active links */
        .list-group-item.active {
            background-color: var(--theme-color-3) !important;
            border-color: var(--theme-color-3) !important;
            color: white !important;
        }

        /* Glassmorphism Navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
            transition: box-shadow 0.3s ease, background 0.3s ease;
        }
        .glass-navbar.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        }
        
        [data-bs-theme="dark"] .glass-navbar {
            background: rgba(26, 42, 51, 0.85) !important; /* cool dark slate */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        [data-bs-theme="dark"] .glass-navbar.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }
        
        .navbar-brand { transition: transform 0.3s; }
        .navbar-brand:hover { transform: scale(1.05); }
        
        /* Contact page icons */
        .bg-primary.rounded-circle {
            background-color: var(--theme-color-2) !important;
            color: #000 !important; /* contrast for the bright cyan */
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1503377215949-b98fc2062536?q=80&w=2000&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top glass-navbar shadow-sm" id="publicNavbar">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary fs-4" href="/">Gari Bondhu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Center Links -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('home') }}" data-i18n="nav_home">Home</a></li>
                        
                        @auth('web')
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('customer.dashboard') }}" data-i18n="nav_dashboard">Dashboard</a></li>
                        @endauth
                        
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('search') }}" data-i18n="nav_fleet">Fleet</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('contact') }}" data-i18n="nav_contact">Contact</a></li>
                    </ul>

                    <!-- Right Links -->
                    <ul class="navbar-nav align-items-center">
                        @auth('web')
                            @php
                                $unreadNotifications = auth()->user()->unreadNotifications;
                            @endphp
                            <li class="nav-item dropdown me-2">
                                <a class="nav-link position-relative px-2" href="#" id="customerNotifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell-fill fs-5 text-dark"></i>
                                    @if($unreadNotifications->count() > 0)
                                        <span class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="customerNotifications" style="width: 320px; max-height: 400px; overflow-y: auto;">
                                    <li><h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                        Notifications
                                        @if($unreadNotifications->count() > 0)
                                            <form action="{{ route('customer.notifications.markAllRead') }}" method="POST" class="d-inline no-confirm m-0 p-0">
                                                @csrf
                                                <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0">Mark all read</button>
                                            </form>
                                        @endif
                                    </h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    @forelse(auth()->user()->notifications()->limit(5)->get() as $notification)
                                        <li class="{{ $notification->unread() ? 'bg-light' : '' }}">
                                            <form action="{{ route('customer.notifications.read', $notification->id) }}" method="POST" class="no-confirm m-0 p-0">
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
                                </ul>
                            </li>
                        @endauth

                        <li class="nav-item me-2">
                            <button id="langTogglePublic" class="btn btn-sm btn-outline-primary fw-bold" title="Toggle Language">BN</button>
                        </li>
                        <li class="nav-item me-3">
                            <button id="themeTogglePublic" class="btn btn-link text-primary nav-link fw-bold p-0" title="Toggle Theme">
                                <i class="bi bi-moon-stars fs-5"></i>
                            </button>
                        </li>

                        @auth('web')
                            <li class="nav-item border-start ps-3">
                                <form action="{{ route('customer.logout') }}" method="POST" class="d-inline no-confirm">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm fw-bold" data-i18n="nav_logout">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item border-start ps-3">
                                <a class="btn btn-primary btn-sm fw-bold" href="{{ route('login') }}" data-i18n="nav_login">Login / Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-light py-3 fixed-bottom border-top border-secondary">
            <div class="container text-center">
                <p class="mb-0 small">&copy; {{ date('Y') }} <span data-i18n="footer_copy">Gari Bondhu Platform. All rights reserved.</span></p>
            </div>
        </footer>
    </div>

    <!-- Vue 3 CDN -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vue App Initialization -->
    <script>
        const { createApp, ref, onMounted } = Vue;
        
        // Reactive language state for Vue
        const currentVueLang = ref(localStorage.getItem('lang') || 'bn');

        const app = createApp({
            setup() {
                return {};
            }
        });
        
        // Global translation helper for Vue templates
        app.config.globalProperties.$t = (key) => {
            const lang = currentVueLang.value;
            if (window.translations && window.translations[lang] && window.translations[lang][key]) {
                return window.translations[lang][key];
            }
            return key; // fallback
        };
    </script>
    
    @stack('scripts')
    
    <script>
        app.mount('#app');

        // Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('themeTogglePublic');
            if (toggleBtn) {
                const icon = toggleBtn.querySelector('i');
                const current = document.documentElement.getAttribute('data-bs-theme');
                if (current === 'dark') {
                    icon.classList.replace('bi-moon-stars', 'bi-sun');
                }

                toggleBtn.addEventListener('click', () => {
                    const theme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', theme);
                    localStorage.setItem('theme', theme);
                    
                    if(theme === 'dark') {
                        icon.classList.replace('bi-moon-stars', 'bi-sun');
                    } else {
                        icon.classList.replace('bi-sun', 'bi-moon-stars');
                    }
                });
            }
        });
        // Language Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const langToggle = document.getElementById('langTogglePublic');
            let currentLang = localStorage.getItem('lang') || 'bn';
            
            // Function to apply translations
            const applyTranslations = (lang) => {
                if(!window.translations || !window.translations[lang]) return;
                
                const dict = window.translations[lang];
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if(dict[key]) {
                        el.innerText = dict[key];
                    }
                });
                
                if(langToggle) {
                    langToggle.innerText = lang === 'en' ? 'BN' : 'EN';
                }
                
                // Expose to Vue
                if(typeof currentVueLang !== 'undefined') {
                    currentVueLang.value = lang;
                }
            };
            
            // Initial application
            setTimeout(() => applyTranslations(currentLang), 100);

            if(langToggle) {
                langToggle.addEventListener('click', () => {
                    currentLang = currentLang === 'en' ? 'bn' : 'en';
                    localStorage.setItem('lang', currentLang);
                    applyTranslations(currentLang);
                });
            }

            // Navbar Scroll Effect
            const navbar = document.getElementById('publicNavbar');
            if(navbar) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 10) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
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
