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
    
    <script>
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
    </script>
    
    <style>
        :root {
            --bs-primary: #333333; /* Charcoal Dark Gray */
            --bs-primary-rgb: 51, 51, 51;
            --accent-color: #ff6b00; /* Bright Orange */
            --accent-color-hover: #e66000;
            --theme-color-dark: #1a1a1a;
        }

        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f4f5f7; /* Sleek cool gray instead of plain white */
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px); /* Subtle dot pattern */
            background-size: 24px 24px;
            color: #333333;
            padding-top: 76px;
        }

        /* Dark Mode Specific Overrides */
        [data-bs-theme="dark"] {
            --bs-primary: #e0e0e0;
            --bs-primary-rgb: 224, 224, 224;
        }
        [data-bs-theme="dark"] body {
            background-color: #121212;
            background-image: radial-gradient(#333333 1px, transparent 1px);
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

        .btn-primary {
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(255, 107, 0, 0.2);
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 700;
        }
        .btn-primary:hover {
            background-color: var(--accent-color-hover) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(255, 107, 0, 0.3);
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }
        .text-accent {
            color: var(--accent-color) !important;
        }
        .bg-primary {
            background-color: var(--bs-primary) !important;
        }
        .bg-accent {
            background-color: var(--accent-color) !important;
        }
        
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            padding: 15px 0;
        }
        [data-bs-theme="dark"] .navbar {
            background-color: #1a1a1a !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.5);
        }
        
        .navbar-brand { font-size: 1.5rem; font-weight: 800; }
        .nav-link { font-size: 0.95rem; font-weight: 500; color: #4b5563 !important; }
        .nav-link:hover { color: var(--bs-primary) !important; }
        [data-bs-theme="dark"] .nav-link { color: #9ca3af !important; }
        [data-bs-theme="dark"] .nav-link:hover { color: #e5e7eb !important; }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        /* Footer styling */
        .site-footer {
            background-color: #ffffff;
            padding: 60px 0 0 0;
        }
        [data-bs-theme="dark"] .site-footer {
            background-color: #1e1e1e;
        }
        .footer-bottom {
            background-color: var(--theme-color-dark);
            color: white;
            padding: 40px 0 20px 0;
            margin-top: 40px;
        }
        .footer-link {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-link:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top" id="publicNavbar">
            <div class="container">
                <a class="navbar-brand text-primary" href="/">Gari Bondhu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}" data-i18n="nav_home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('search') }}" data-i18n="nav_fleet">Cars</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}" data-i18n="nav_services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locations') }}" data-i18n="nav_locations">Locations</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('deals') }}" data-i18n="nav_deals">Deals</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}" data-i18n="nav_contact">About Us</a></li>
                    </ul>

                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-3">
                            <a class="nav-link" href="#"><i class="bi bi-question-circle"></i> Help Center</a>
                        </li>
                        
                        <li class="nav-item me-2 d-flex align-items-center">
                            <button id="langTogglePublic" class="btn btn-sm btn-outline-secondary fw-bold" title="Toggle Language">BN</button>
                        </li>
                        <li class="nav-item me-2">
                            <button id="themeTogglePublic" class="btn btn-link text-dark nav-link p-0" title="Toggle Theme">
                                <i class="bi bi-moon-stars fs-5"></i>
                            </button>
                        </li>

                        @auth('web')
                            <li class="nav-item border-start ps-3 me-2">
                                <a class="nav-link" href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('customer.logout') }}" method="POST" class="d-inline no-confirm">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm" data-i18n="nav_logout">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item border-start ps-3 me-3">
                                <a class="nav-link fw-bold" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary px-4" href="{{ route('search') }}">Book Now</a>
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
        <footer class="site-footer mt-5">
            <div class="container text-center mb-5">
                <h3 class="fw-bold mb-4">How It Works</h3>
                <p class="text-muted mb-5">Renting a car with Gari Bondhu is simple and hassle-free.</p>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px; font-size: 2rem;">
                            📍
                        </div>
                        <h6 class="fw-bold">01<br><br>Choose Location</h6>
                        <p class="text-muted small mt-2">Select your pick-up and drop-off location.</p>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px; font-size: 2rem;">
                            🚗
                        </div>
                        <h6 class="fw-bold">02<br><br>Select Car</h6>
                        <p class="text-muted small mt-2">Browse and select your perfect car.</p>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px; font-size: 2rem;">
                            💳
                        </div>
                        <h6 class="fw-bold">03<br><br>Book & Pay</h6>
                        <p class="text-muted small mt-2">Confirm your booking and make payment.</p>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px; font-size: 2rem;">
                            🔑
                        </div>
                        <h6 class="fw-bold">04<br><br>Enjoy the Ride</h6>
                        <p class="text-muted small mt-2">Pick up your car and enjoy your journey.</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="container">
                    <div class="row g-4 mb-4">
                         <div class="col-md-12">
                             <div class="d-flex justify-content-between align-items-center flex-wrap px-4 py-4 rounded" style="background-color: var(--bs-primary);">
                                 <div>
                                     <h4 class="text-white mb-1">Subscribe to Our Newsletter</h4>
                                     <p class="text-white-50 mb-0">Get the latest deals and offers.</p>
                                 </div>
                                 <form class="d-flex gap-2">
                                     <input type="email" class="form-control" placeholder="Enter your email" style="width: 250px;">
                                     <button class="btn btn-dark" type="button">Subscribe</button>
                                 </form>
                             </div>
                         </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-3">
                            <h4 class="mb-4">Gari Bondhu</h4>
                            <p class="text-muted small">Your trusted partner for car rentals. Quality cars, affordable prices, great service.</p>
                            <div class="d-flex gap-3">
                                <a href="#" class="footer-link"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="footer-link"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="footer-link"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="footer-link"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h6 class="mb-4 text-white">Quick Links</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                                <li class="mb-2"><a href="{{ route('search') }}" class="footer-link">Cars</a></li>
                                <li class="mb-2"><a href="{{ route('services') }}" class="footer-link">Services</a></li>
                                <li class="nav-item"><a href="{{ route('locations') }}" class="footer-link">Locations</a></li>
                                <li class="mb-2"><a href="{{ route('deals') }}" class="footer-link">Deals</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h6 class="mb-4 text-white">Company</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="footer-link">About Us</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Careers</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Blog</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Press</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h6 class="mb-4 text-white">Support</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#" class="footer-link">Help Center</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Terms & Conditions</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Refund Policy</a></li>
                                <li class="mb-2"><a href="#" class="footer-link">Sitemap</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="mb-4 text-white">Contact Us</h6>
                            <ul class="list-unstyled text-muted small">
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i> +880 1234 567890</li>
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i> support@garibondhu.com</li>
                                <li class="mb-2 d-flex"><i class="bi bi-geo-alt me-2 mt-1"></i> 123 Road, Dhaka, Bangladesh</li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mt-4 mb-3 border-secondary">
                    <div class="text-center text-muted small">
                        &copy; {{ date('Y') }} Gari Bondhu. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Vue 3 CDN -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const { createApp, ref, onMounted } = Vue;
        const currentVueLang = ref(localStorage.getItem('lang') || 'en');

        const app = createApp({ setup() { return {}; } });
        
        app.config.globalProperties.$t = (key) => {
            const lang = currentVueLang.value;
            if (window.translations && window.translations[lang] && window.translations[lang][key]) {
                return window.translations[lang][key];
            }
            return key;
        };
    </script>
    
    @stack('scripts')
    
    <script>
        app.mount('#app');

        document.addEventListener('DOMContentLoaded', () => {
            // Language Toggle
            const langBtn = document.getElementById('langTogglePublic');
            const currentLang = localStorage.getItem('lang') || 'en';
            
            if (langBtn) {
                langBtn.textContent = currentLang === 'en' ? 'BN' : 'EN';
                langBtn.addEventListener('click', () => {
                    const newLang = localStorage.getItem('lang') === 'bn' ? 'en' : 'bn';
                    localStorage.setItem('lang', newLang);
                    window.location.reload();
                });
            }

            // Update UI Texts
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (window.translations && window.translations[currentLang] && window.translations[currentLang][key]) {
                    el.textContent = window.translations[currentLang][key];
                }
            });

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
                        toggleBtn.classList.replace('text-dark', 'text-light');
                    } else {
                        icon.classList.replace('bi-sun', 'bi-moon-stars');
                        toggleBtn.classList.replace('text-light', 'text-dark');
                    }
                });
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
