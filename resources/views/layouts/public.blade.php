<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Lokal Colombia - Directorio Digital')</title>
    <meta name="description" content="@yield('description', 'Descubre comercios y servicios locales en Colombia. Directorio digital gratuito para conectar con tu comunidad.')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-img {
            height: 40px;
            margin-right: 0.5rem;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* User Menu Dropdown */
        .user-menu {
            position: relative;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            background: rgba(245, 158, 11, 0.1);
            color: var(--primary-color);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: background-color 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--primary-color);
        }

        .dropdown-form {
            margin: 0;
        }

        .logout-btn {
            width: 100%;
            font-family: inherit;
            font-size: inherit;
        }

        /* Mobile user menu */
        .mobile-user-section {
            border-top: 1px solid var(--border-color);
            margin-top: 1rem;
            padding-top: 1rem;
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .mobile-logout-form {
            margin: 0;
        }

        .mobile-logout-form .logout-btn {
            background: none;
            border: none;
            font-family: inherit;
            font-size: inherit;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Mobile menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-light);
            cursor: pointer;
        }

        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-white);
            border-top: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-nav-links {
            list-style: none;
            padding: 1rem;
        }

        .mobile-nav-links li {
            margin-bottom: 1rem;
        }

        .mobile-nav-links .nav-link {
            display: block;
            padding: 0.5rem 0;
        }

        /* Main content */
        main {
            margin-top: 70px;
        }

        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .footer-section p,
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid var(--secondary-light);
            padding-top: 2rem;
            text-align: center;
            color: #9ca3af;
        }

        /* Dark theme adjustments */
        .bg-light {
            background-color: var(--bg-white) !important;
        }
        
        .section-title {
            color: var(--text-dark);
        }
        
        .section-description {
            color: var(--text-light);
        }
        
        .card,
        .feature-card,
        .comercio-card {
            background: var(--bg-dark);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--secondary-color) 100%);
        }
        
        .hero-title {
            color: var(--text-dark);
        }
        
        .hero-description {
            color: var(--text-light);
        }
        
        .hero-badge {
            background: var(--primary-color);
            color: var(--bg-light);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .nav-container {
                padding: 0 1rem;
            }

            .logo {
                font-size: 1.25rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        /* Utility classes */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .text-center { text-align: center; }
        .text-primary { color: var(--primary-color); }
        .bg-light { background-color: var(--bg-light); }
        .py-16 { padding: 4rem 0; }
        .py-8 { padding: 2rem 0; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-4 { margin-bottom: 1rem; }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('storage/imagenes-lokal-colombia/logo.webp') }}" alt="Lokal Colombia" class="logo-img">
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
                <li><a href="{{ route('comercios') }}" class="nav-link {{ request()->routeIs('comercios') ? 'active' : '' }}">Comercios y Servicios</a></li>
                <li><a href="{{ route('quienes-somos') }}" class="nav-link {{ request()->routeIs('quienes-somos') ? 'active' : '' }}">Quiénes Somos</a></li>
                <li><a href="{{ route('contacto') }}" class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a></li>
                
                @auth
                    <li class="user-menu">
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('register') }}" class="btn btn-outline">Registro</a></li>
                    <li><a href="{{ route('login') }}" class="btn btn-primary">Login</a></li>
                @endauth
            </ul>

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>

            <div class="mobile-menu" id="mobileMenu">
                <ul class="mobile-nav-links">
                    <li><a href="{{ route('home') }}" class="nav-link">Inicio</a></li>
                    <li><a href="{{ route('comercios') }}" class="nav-link">Comercios y Servicios</a></li>
                    <li><a href="{{ route('quienes-somos') }}" class="nav-link">Quiénes Somos</a></li>
                    <li><a href="{{ route('contacto') }}" class="nav-link">Contacto</a></li>
                    
                    @auth
                        <li class="mobile-user-section">
                            <div class="mobile-user-info">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                                @csrf
                                <button type="submit" class="nav-link logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('register') }}" class="nav-link">Registro</a></li>
                        <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
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
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ contact_info('company.name') }}</h3>
                    <p>{{ contact_info('company.description') }}</p>
                    <div class="social-links">
                        <a href="{{ contact_info('social.facebook') }}" target="_blank" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ contact_info('social.instagram') }}" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="{{ whatsapp_url('', 'general_inquiry') }}" target="_blank" class="social-link"><i class="fab fa-whatsapp"></i></a>
                        <a href="{{ contact_info('social.twitter') }}" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('comercios') }}">Comercios y Servicios</a></li>
                        <li><a href="{{ route('quienes-somos') }}">Quiénes Somos</a></li>
                        <li><a href="{{ route('contacto') }}">Contacto</a></li>
                        <li><a href="{{ route('register') }}">Registrar mi negocio</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p><i class="fas fa-envelope"></i> <a href="{{ contact_email_url() }}">{{ contact_info('email') }}</a></p>
                    <p><i class="fas fa-phone"></i> <a href="tel:{{ contact_info('phone') }}">{{ contact_info('phone') }}</a></p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ contact_info('address') }}</p>
                </div>

                <div class="footer-section">
                    <h3>Nuestra Misión</h3>
                    <p>{{ contact_info('company.mission') }}</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ contact_info('company.name') }}. Todos los derechos reservados. | Desarrollado con ❤️ para nuestra comunidad</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="{{ whatsapp_url('', 'register_business') }}" 
       target="_blank" class="whatsapp-float" title="Registrar mi comercio por WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }
    </style>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            const icon = mobileMenuBtn.querySelector('i');
            if (mobileMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('active');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>

    @stack('scripts')

    <!-- Notificaciones Flotantes -->
    @include('components.notifications')
</body>
</html>