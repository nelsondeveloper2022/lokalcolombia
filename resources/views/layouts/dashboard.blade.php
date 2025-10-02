<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard - Lokal Colombia')</title>
    <meta name="description" content="@yield('description', 'Panel de control para gestionar tu negocio en Lokal Colombia.')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #f59e0b;
            --primary-dark: #d97706;
            --secondary-color: #1f2937;
            --secondary-light: #374151;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --text-dark: #111827;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --sidebar-width: 280px;
        }

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

        /* Layout Principal */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--secondary-color) 0%, var(--secondary-light) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .sidebar-logo i {
            color: var(--primary-color);
            font-size: 2rem;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-color);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .nav-badge {
            background: var(--primary-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.125rem 0.5rem;
            border-radius: 1rem;
            margin-left: auto;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .main-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            position: relative;
        }

        .user-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-toggle:hover {
            background: var(--border-color);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-menu.active .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .dropdown-link:hover {
            background: var(--bg-light);
        }

        .dropdown-link:first-child {
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .dropdown-link:last-child {
            border-radius: 0 0 0.75rem 0.75rem;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Mobile Styles */
        .mobile-header {
            display: none;
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1001;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .mobile-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .main-header {
                display: none;
            }

            .content-area {
                margin-top: 70px;
                padding: 1rem;
            }
        }

        /* Utility Classes */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
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
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            color: #059669;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 1px solid #fde68a;
            color: #d97706;
        }

        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            color: #dc2626;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="mobile-toggle" id="mobile-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="sidebar-logo">
            <i class="fas fa-store"></i>
            Lokal Colombia
        </div>
        <div class="user-avatar">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-logo">
                    <i class="fas fa-store"></i>
                    Lokal Colombia
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->route()->getName() == 'dashboard' ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard.comercio') }}" class="nav-link {{ request()->route()->getName() == 'dashboard.comercio' ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        Información del Comercio
                        @if(!Auth::user()->hasVerifiedEmail())
                            <span class="nav-badge">!</span>
                        @endif
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Cuenta</div>
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="fas fa-user-cog"></i>
                        Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left;">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Enlaces</div>
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        Ver Sitio Web
                    </a>
                    @if(Auth::user()->comercioServicio)
                        <a href="{{ route('comercio.detalle', Auth::user()->comercioServicio->slug) }}" class="nav-link" target="_blank">
                            <i class="fas fa-eye"></i>
                            Ver mi Comercio
                        </a>
                    @endif
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="main-header">
                <h1 class="header-title">@yield('page-title', 'Dashboard')</h1>
                <div class="header-actions">
                    <div class="user-menu" id="user-menu">
                        <div class="user-toggle" id="user-toggle">
                            <div class="user-avatar">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="user-dropdown">
                            <a href="{{ route('profile.edit') }}" class="dropdown-link">
                                <i class="fas fa-user-cog"></i>
                                Mi Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                                @csrf
                                <button type="submit" class="dropdown-link" style="background: none; border: none; width: 100%; text-align: left;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const mobileToggle = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            mobileToggle?.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });

            sidebarOverlay?.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });

            // User menu dropdown
            const userMenu = document.getElementById('user-menu');
            const userToggle = document.getElementById('user-toggle');

            userToggle?.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenu?.contains(e.target)) {
                    userMenu?.classList.remove('active');
                }
            });
        });
    </script>

    @stack('scripts')

    <!-- Notificaciones Flotantes -->
    @include('components.notifications')
</body>
</html>