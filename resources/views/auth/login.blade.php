@extends('layouts.public')

@section('title', 'Iniciar Sesión - Lokal Colombia')
@section('description', 'Inicia sesión en tu cuenta de Lokal Colombia y gestiona tu negocio desde nuestro panel de control.')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<section class="login-section">
    <!-- Hero Header -->
    <div class="login-hero">
        <div class="hero-background"></div>
        <div class="hero-overlay"></div>
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge" data-aos="fade-down">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    ¡Bienvenido de nuevo!
                </div>
                <h1 class="hero-title text-white" data-aos="fade-up" data-aos-delay="200">
                    <span class="text-white">Accede a tu</span> <span class="text-accent">Panel de Control</span>
                </h1>
                <p class="hero-description text-white" data-aos="fade-up" data-aos-delay="400">
                    Gestiona tu negocio, actualiza tu información y conecta con más clientes desde tu dashboard personalizado.
                </p>
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="form-section">
        <div class="container">
            <div class="form-container" data-aos="fade-up" data-aos-delay="200">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2 class="form-title">Iniciar Sesión</h2>
                    <p class="form-subtitle">Ingresa tus credenciales para acceder a tu cuenta</p>
                </div>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="success-banner">
                        <div class="success-content">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <!-- General Error Message -->
                @if($errors->any())
                    <div class="validation-errors-banner">
                        <div class="validation-errors-header">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4>Error al iniciar sesión:</h4>
                        </div>
                        <ul class="validation-errors-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form" data-recaptcha="LOGIN">
                    @csrf

                    <!-- Login Fields -->
                    <div class="form-section-wrapper">
                        <div class="form-grid">
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope form-label-icon"></i>
                                    Correo Electrónico *
                                </label>
                                <div class="input-wrapper">
                                    <input id="email" 
                                           type="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required
                                           autofocus
                                           autocomplete="username"
                                           placeholder="tu@email.com"
                                           class="form-input">
                                    <div class="input-focus-ring"></div>
                                </div>
                                @error('email')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock form-label-icon"></i>
                                    Contraseña *
                                </label>
                                <div class="input-wrapper">
                                    <input id="password" 
                                           type="password" 
                                           name="password" 
                                           required
                                           autocomplete="current-password"
                                           placeholder="Tu contraseña"
                                           class="form-input">
                                    <div class="input-focus-ring"></div>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <label class="remember-checkbox">
                                <input type="checkbox" name="remember" id="remember_me">
                                <span class="checkmark"></span>
                                <span class="checkbox-text">Recordarme</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">
                                    <i class="fas fa-key"></i>
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="register-link">
                            <p>¿No tienes cuenta?</p>
                            <a href="{{ route('register') }}" class="register-btn">
                                <i class="fas fa-user-plus"></i>
                                Registra tu negocio gratis
                            </a>
                        </div>

                        {{-- <div class="recovery-link">
                            <p>¿Ya tienes un negocio registrado pero no recuerdas tus datos?</p>
                            <button type="button" class="recovery-btn" id="show-recovery-form">
                                <i class="fas fa-search"></i>
                                Recuperar acceso a mi comercio
                            </button>
                        </div> --}}

                        <button type="submit" class="submit-btn" id="login-button">
                            <div class="btn-content">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Iniciar Sesión</span>
                            </div>
                            <div class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Verificando...</span>
                            </div>
                        </button>
                        
                        <div class="form-progress" id="login-progress" style="display: none;">
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <p class="progress-text">Verificando credenciales...</p>
                        </div>

                        <!-- reCAPTCHA Enterprise -->
                        <x-recaptcha-enterprise action="LOGIN" />
                    </div>
                </form>
            </div>
            
            <!-- Recovery Form -->
            <div class="form-container recovery-form" id="recovery-form" style="display: none;">
                <div class="form-header">
                    <h2 class="form-title">
                        <i class="fas fa-search"></i>
                        Recuperar Acceso
                    </h2>
                    <p class="form-subtitle">
                        Ingresa el nombre de tu comercio para recuperar el acceso
                    </p>
                </div>

                <form id="recovery-search-form" data-recaptcha="RECOVERY">
                    @csrf
                    <div class="form-content">
                        <div class="form-group">
                            <label for="comercio_nombre" class="form-label">
                                <i class="fas fa-store form-label-icon"></i>
                                Nombre del Comercio *
                            </label>
                            <div class="input-wrapper">
                                <input id="comercio_nombre" 
                                       type="text" 
                                       name="comercio_nombre" 
                                       required
                                       placeholder="Ingresa el nombre de tu negocio"
                                       class="form-input">
                                <div class="input-focus-ring"></div>
                            </div>
                        </div>

                        <div class="recovery-actions">
                            <button type="button" class="recovery-back-btn" id="back-to-login">
                                <i class="fas fa-arrow-left"></i>
                                Volver al login
                            </button>
                            
                            <button type="submit" class="submit-btn" id="search-comercio-btn">
                                <div class="btn-content">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar mi comercio</span>
                                </div>
                                <div class="btn-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Buscando...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Recovery Results -->
                <div class="recovery-results" id="recovery-results" style="display: none;">
                    <div class="results-header">
                        <h3>
                            <i class="fas fa-check-circle"></i>
                            ¡Comercio encontrado!
                        </h3>
                        <p>Confirma que este es tu negocio:</p>
                    </div>
                    
                    <div class="comercio-card" id="comercio-info">
                        <!-- Información del comercio se llenará dinámicamente -->
                    </div>
                    
                    <div class="recovery-final-actions">
                        <button type="button" class="recovery-back-btn" id="search-again">
                            <i class="fas fa-redo"></i>
                            Buscar otro comercio
                        </button>
                        
                        <button type="button" class="whatsapp-btn" id="contact-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            Contactar por WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Login Section Styles */
.login-section {
    min-height: 100vh;
    background: var(--bg-light);
}

/* Hero Header */
.login-hero {
    position: relative;
    min-height: 40vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--text-dark) 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.1;
}

.text-accent {
    color: #fbbf24;
    text-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
}

.hero-description {
    font-size: 1.125rem;
    max-width: 500px;
    margin: 0 auto;
    opacity: 0.95;
    line-height: 1.6;
}

/* Form Section */
.form-section {
    padding: 4rem 0;
    background: linear-gradient(135deg, var(--bg-light) 0%, #e5e7eb 100%);
    position: relative;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
    background: white;
    border-radius: 2rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--secondary-color), var(--text-dark), var(--primary-color));
}

.form-header {
    text-align: center;
    padding: 3rem 2rem 2rem;
    background: linear-gradient(135deg, #fafafa 0%, white 100%);
    position: relative;
}

.form-header-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--secondary-color), var(--text-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
    box-shadow: 0 15px 35px rgba(31, 41, 55, 0.3);
}

.form-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-subtitle {
    color: var(--text-light);
    font-size: 1.125rem;
}

/* Success Banner */
.success-banner {
    margin: 2rem;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #bbf7d0;
    border-radius: 1rem;
    padding: 1rem;
    animation: slideInDown 0.5s ease-out;
}

.success-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #059669;
    font-weight: 600;
}

.success-content i {
    font-size: 1.25rem;
}

/* Validation Errors Banner */
.validation-errors-banner {
    margin: 2rem;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 1px solid #fecaca;
    border-radius: 1rem;
    padding: 1.5rem;
}

.validation-errors-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    color: #dc2626;
}

.validation-errors-header i {
    font-size: 1.25rem;
}

.validation-errors-header h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.validation-errors-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.validation-errors-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    color: #dc2626;
    font-size: 0.875rem;
    font-weight: 500;
}

.validation-errors-list li::before {
    content: '•';
    color: #dc2626;
    font-weight: bold;
    font-size: 1rem;
}

/* Form Styles */
.login-form {
    padding: 2rem;
}

.form-section-wrapper {
    margin-bottom: 2rem;
}

.form-grid {
    display: grid;
    gap: 1.5rem;
}

.form-group {
    position: relative;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

.form-label-icon {
    color: var(--primary-color);
}

.input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.input-focus-ring {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 1rem;
    border: 2px solid transparent;
    background: linear-gradient(var(--primary-color), var(--primary-dark)) border-box;
    -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: subtract;
    mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
    mask-composite: subtract;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.form-input:focus + .input-focus-ring {
    opacity: 1;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    font-size: 1rem;
    transition: color 0.3s ease;
    z-index: 2;
}

.password-toggle:hover {
    color: var(--primary-color);
}

/* Error Messages */
.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    color: #dc2626;
    font-size: 0.875rem;
    font-weight: 500;
}

.error-message i {
    font-size: 0.875rem;
}

/* Form Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.remember-checkbox {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-dark);
}

.remember-checkbox input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
}

.remember-checkbox input[type="checkbox"]:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.remember-checkbox input[type="checkbox"]:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 12px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.forgot-password {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.forgot-password:hover {
    color: var(--primary-dark);
    transform: translateY(-1px);
}

/* Form Actions */
.form-actions {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    align-items: center;
    padding-top: 2rem;
    border-top: 2px solid var(--bg-light);
}

.register-link {
    text-align: center;
}

.register-link p {
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.register-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
}

.register-btn:hover {
    background: rgba(245, 158, 11, 0.1);
    transform: translateY(-2px);
}

/* Recovery Link */
.recovery-link {
    text-align: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.recovery-link p {
    color: var(--text-light);
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

.recovery-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: transparent;
    border: 2px solid var(--secondary-color);
    color: var(--secondary-color);
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.recovery-btn:hover {
    background: var(--secondary-color);
    color: white;
    transform: translateY(-2px);
}

/* Recovery Form */
.recovery-form {
    display: none;
}

.recovery-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.5rem;
}

.recovery-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-light);
    border-radius: 0.75rem;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.recovery-back-btn:hover {
    background: var(--bg-light);
    color: var(--text-dark);
}

/* Recovery Results */
.recovery-results {
    margin-top: 2rem;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 1rem;
    border: 1px solid var(--border-color);
}

.results-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.results-header h3 {
    color: #059669;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.results-header p {
    color: var(--text-light);
    font-size: 0.875rem;
}

.comercio-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.comercio-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.comercio-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.comercio-details h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.comercio-details p {
    color: var(--text-light);
    font-size: 0.875rem;
}

.comercio-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.meta-item i {
    color: var(--primary-color);
    width: 16px;
}

.recovery-final-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.whatsapp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #25d366, #128c7e);
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.whatsapp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
}

.submit-btn {
    position: relative;
    background: linear-gradient(135deg, var(--secondary-color), var(--text-dark));
    color: white;
    border: none;
    padding: 1.25rem 3rem;
    border-radius: 1.5rem;
    font-size: 1.125rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s ease;
    overflow: hidden;
    min-width: 280px;
    box-shadow: 0 10px 25px rgba(31, 41, 55, 0.3);
}

.submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.submit-btn:hover::before {
    left: 100%;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(31, 41, 55, 0.4);
}

.submit-btn:active {
    transform: translateY(-1px);
}

.btn-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: opacity 0.3s ease;
}

.btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.submit-btn.loading .btn-content {
    opacity: 0;
}

.submit-btn.loading .btn-loading {
    opacity: 1;
}

/* Form Progress */
.form-progress {
    margin-top: 1rem;
    text-align: center;
}

.progress-bar {
    width: 100%;
    height: 4px;
    background: var(--bg-light);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--secondary-color), var(--text-dark));
    width: 0%;
    transition: width 0.3s ease;
    border-radius: 2px;
}

.progress-text {
    color: var(--text-light);
    font-size: 0.875rem;
    margin: 0;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .form-container {
        margin: 1rem;
        border-radius: 1.5rem;
    }
    
    .form-header {
        padding: 2rem 1.5rem 1.5rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
    
    .login-form {
        padding: 1.5rem;
    }
    
    .submit-btn {
        min-width: 100%;
        padding: 1rem 2rem;
    }
    
    .form-options {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .form-title {
        font-size: 1.75rem;
    }
}

/* Animation Classes */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

[data-aos="fade-up"] {
    animation: fadeInUp 0.8s ease-out;
}

[data-aos="fade-down"] {
    animation: fadeInDown 0.8s ease-out;
}

[data-aos-delay="200"] {
    animation-delay: 0.2s;
}

[data-aos-delay="400"] {
    animation-delay: 0.4s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Password toggle functionality
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with progress
    const form = document.querySelector('.login-form');
    const submitBtn = document.querySelector('.submit-btn');
    const progressContainer = document.getElementById('login-progress');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Show progress
            progressContainer.style.display = 'block';
            
            // Animate progress
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress > 85) progress = 85;
                
                progressFill.style.width = progress + '%';
                
                if (progress < 40) {
                    progressText.textContent = 'Verificando credenciales...';
                } else {
                    progressText.textContent = 'Iniciando sesión...';
                }
            }, 150);
            
            // Complete progress after short delay
            setTimeout(() => {
                clearInterval(progressInterval);
                progressFill.style.width = '100%';
                progressText.textContent = 'Accediendo al dashboard...';
            }, 1000);
        });
    }
    
    // Add smooth animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('[data-aos]').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s ease-out';
        observer.observe(el);
    });
    
    // Recovery functionality
    const showRecoveryBtn = document.getElementById('show-recovery-form');
    const backToLoginBtn = document.getElementById('back-to-login');
    const loginForm = document.querySelector('.form-container:not(.recovery-form)');
    const recoveryForm = document.getElementById('recovery-form');
    const recoverySearchForm = document.getElementById('recovery-search-form');
    const recoveryResults = document.getElementById('recovery-results');
    const searchAgainBtn = document.getElementById('search-again');
    const contactWhatsappBtn = document.getElementById('contact-whatsapp');
    
    let currentComercio = null;
    
    // Show recovery form
    showRecoveryBtn?.addEventListener('click', function() {
        loginForm.style.display = 'none';
        recoveryForm.style.display = 'block';
        recoveryResults.style.display = 'none';
    });
    
    // Back to login
    backToLoginBtn?.addEventListener('click', function() {
        recoveryForm.style.display = 'none';
        loginForm.style.display = 'block';
        recoveryResults.style.display = 'none';
    });
    
    // Search comercio
    recoverySearchForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const comercioNombre = document.getElementById('comercio_nombre').value.trim();
        const searchBtn = document.getElementById('search-comercio-btn');
        
        if (!comercioNombre) {
            alert('Por favor ingresa el nombre de tu comercio');
            return;
        }
        
        // Show loading state
        searchBtn.classList.add('loading');
        
        // Ejecutar reCAPTCHA antes de enviar
        executeRecaptcha('RECOVERY', (token, error) => {
            if (error || !token) {
                searchBtn.classList.remove('loading');
                alert('Error de verificación de seguridad. Por favor, intenta nuevamente.');
                return;
            }
            
            // Search for comercio with reCAPTCHA token
            fetch('/auth/search-comercio', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    nombre: comercioNombre,
                    recaptcha_token: token
                })
            })
            .then(response => response.json())
            .then(data => {
                searchBtn.classList.remove('loading');
                
                if (data.success && data.comercio) {
                    currentComercio = data.comercio;
                    window.whatsappSupport = data.whatsapp_support;
                    showComercioInfo(data.comercio);
                    recoveryResults.style.display = 'block';
                } else {
                    alert(data.message || 'No se encontró ningún comercio con ese nombre. Verifica el nombre e intenta nuevamente.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                searchBtn.classList.remove('loading');
                alert('Ocurrió un error al buscar el comercio. Intenta nuevamente.');
            });
        });
    });
    
    // Search again
    searchAgainBtn?.addEventListener('click', function() {
        recoveryResults.style.display = 'none';
        document.getElementById('comercio_nombre').value = '';
        document.getElementById('comercio_nombre').focus();
    });
    
    // Contact WhatsApp
    contactWhatsappBtn?.addEventListener('click', function() {
        if (currentComercio && window.whatsappSupport) {
            const message = encodeURIComponent(
                `Hola, necesito recuperar el acceso a mi comercio "${currentComercio.titulo}" registrado en Puente Lokal. ` +
                `Mi comercio tiene el ID: ${currentComercio.id}. ¿Pueden ayudarme con la recuperación de mis credenciales?`
            );
            const whatsappNumber = window.whatsappSupport.replace('+', '');
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }
    });
    
    // Function to show comercio info
    function showComercioInfo(comercio) {
        const comercioInfoDiv = document.getElementById('comercio-info');
        comercioInfoDiv.innerHTML = `
            <div class="comercio-info">
                <div class="comercio-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="comercio-details">
                    <h4>${comercio.titulo}</h4>
                    <p>${comercio.categoria || 'Sin categoría'} - ${comercio.tipo || 'Sin tipo'}</p>
                </div>
            </div>
            <div class="comercio-meta">
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>${comercio.direccion || 'Sin dirección'}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar-plus"></i>
                    <span>${comercio.fecha_registro || 'Fecha no disponible'}</span>
                </div>
                ${comercio.telefono ? `
                    <div class="meta-item">
                        <i class="fas fa-phone"></i>
                        <span>${comercio.telefono}</span>
                    </div>
                ` : ''}
                ${comercio.email ? `
                    <div class="meta-item">
                        <i class="fas fa-envelope"></i>
                        <span>${comercio.email}</span>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    // Auto-hide messages after some time
    setTimeout(() => {
        const successBanner = document.querySelector('.success-banner');
        const errorBanner = document.querySelector('.validation-errors-banner');
        
        if (successBanner) {
            successBanner.style.animation = 'slideOutUp 0.5s ease-out forwards';
            setTimeout(() => successBanner.remove(), 500);
        }
        
        if (errorBanner) {
            errorBanner.style.animation = 'slideOutUp 0.5s ease-out forwards';
            setTimeout(() => errorBanner.remove(), 500);
        }
    }, 6000);
});
</script>
@endpush
@endsection
