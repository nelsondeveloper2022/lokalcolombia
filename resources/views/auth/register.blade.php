@extends('layouts.public')

@section('title', 'Registro de Negocio - Lokal Colombia')
@section('description', 'Registra tu negocio en Lokal Colombia y conecta con tu comunidad. Plataforma gratuita para comercios y servicios locales.')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<section class="register-section">
    <!-- Hero Header -->
    <div class="register-hero">
        <div class="hero-background"></div>
        <div class="hero-overlay"></div>
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge" data-aos="fade-down">
                    <i class="fas fa-rocket mr-2"></i>
                    ¡Registro Gratuito!
                </div>
                <h1 class="hero-title text-white" data-aos="fade-up" data-aos-delay="200">
                    Registra tu Negocio en <span class="text-accent">Lokal Colombia</span>
                </h1>
                <p class="hero-description text-white" data-aos="fade-up" data-aos-delay="400">
                    Únete a nuestra comunidad de comercios locales y haz crecer tu negocio. 
                    Es completamente gratuito y solo te tomará unos minutos.
                </p>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="benefits-section">
        <div class="container">
            <div class="benefits-grid">
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="benefit-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="benefit-title">Mayor Visibilidad</h3>
                    <p class="benefit-description">Tu negocio será visible para toda la comunidad local</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="benefit-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 class="benefit-title">Contacto Directo</h3>
                    <p class="benefit-description">Los clientes podrán contactarte fácilmente</p>
                </div>
                <div class="benefit-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="benefit-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="benefit-title">Apoyo Local</h3>
                    <p class="benefit-description">Fortalece la economía de tu comunidad</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="form-section">
        <div class="container">
            <div class="form-container" data-aos="fade-up" data-aos-delay="200">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="form-title">Crea tu Cuenta</h2>
                    <p class="form-subtitle">Completa los siguientes datos para registrar tu negocio</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="success-banner">
                        <div class="success-content">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- General Error Message -->
                @if($errors->has('error'))
                    <div class="error-banner">
                        <div class="error-content">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $errors->first('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any() && !$errors->has('error'))
                    <div class="validation-errors-banner">
                        <div class="validation-errors-header">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4>Por favor corrige los siguientes errores:</h4>
                        </div>
                        <ul class="validation-errors-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="register-form" data-recaptcha="REGISTER">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="form-section-wrapper">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="section-info">
                                <h3 class="section-title">Información Personal</h3>
                                <p class="section-description">Datos básicos de tu cuenta</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user form-label-icon"></i>
                                    Nombre Completo *
                                </label>
                                <div class="input-wrapper">
                                    <input id="name" 
                                           type="text" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus
                                           placeholder="Ingresa tu nombre completo"
                                           class="form-input">
                                    <div class="input-focus-ring"></div>
                                </div>
                                @error('name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

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
                        </div>

                        <div class="form-grid grid-cols-2">
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
                                           placeholder="Mínimo 8 caracteres"
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

                            <!-- Password Confirmation -->
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock form-label-icon"></i>
                                    Confirmar Contraseña *
                                </label>
                                <div class="input-wrapper">
                                    <input id="password_confirmation" 
                                           type="password" 
                                           name="password_confirmation" 
                                           required
                                           placeholder="Repite tu contraseña"
                                           class="form-input">
                                    <div class="input-focus-ring"></div>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Business Information Section -->
                    <div class="form-section-wrapper">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="section-info">
                                <h3 class="section-title">Información del Negocio</h3>
                                <p class="section-description">Detalles de tu comercio o servicio</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <!-- Business Name -->
                            <div class="form-group">
                                <label for="nombre_comercio" class="form-label">
                                    <i class="fas fa-shop form-label-icon"></i>
                                    Nombre del Comercio/Servicio *
                                </label>
                                <div class="input-wrapper">
                                    <input id="nombre_comercio" 
                                           type="text" 
                                           name="nombre_comercio" 
                                           value="{{ old('nombre_comercio') }}" 
                                           required
                                           placeholder="Ej: Restaurante El Buen Sabor"
                                           class="form-input">
                                    <div class="input-focus-ring"></div>
                                </div>
                                @error('nombre_comercio')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid grid-cols-2">
                            <!-- Category -->
                            <div class="form-group">
                                <label for="categoria" class="form-label">
                                    <i class="fas fa-tags form-label-icon"></i>
                                    Categoría *
                                </label>
                                <div class="search-select-wrapper">
                                    <select id="categoria" 
                                            name="categoria" 
                                            required
                                            class="search-select"
                                            data-placeholder="Buscar categoría...">
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->idMarketCategoria }}" 
                                                    {{ old('categoria') == $categoria->idMarketCategoria ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('categoria')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Business Type -->
                            <div class="form-group">
                                <label for="tipo_comercio" class="form-label">
                                    <i class="fas fa-list form-label-icon"></i>
                                    Tipo de Comercio/Servicio *
                                </label>
                                <div class="search-select-wrapper">
                                    <select id="tipo_comercio" 
                                            name="tipo_comercio" 
                                            required
                                            class="search-select"
                                            data-placeholder="Buscar tipo de comercio...">
                                        <option value="">Selecciona un tipo</option>
                                        @foreach($tiposComercio as $tipo)
                                            <option value="{{ $tipo->idMarketTipoComercioServicio }}" 
                                                    {{ old('tipo_comercio') == $tipo->idMarketTipoComercioServicio ? 'selected' : '' }}>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('tipo_comercio')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="descripcion_corta" class="form-label">
                                    <i class="fas fa-align-left form-label-icon"></i>
                                    Descripción Breve
                                    <span class="optional-badge">Opcional</span>
                                </label>
                                <div class="textarea-wrapper">
                                    <textarea id="descripcion_corta" 
                                              name="descripcion_corta" 
                                              rows="4"
                                              placeholder="Describe brevemente tu negocio o servicio... (máx. 200 caracteres)"
                                              class="form-textarea"
                                              maxlength="200">{{ old('descripcion_corta') }}</textarea>
                                    <div class="textarea-counter">
                                        <span id="char-count">0</span>/200
                                    </div>
                                </div>
                                @error('descripcion_corta')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Summary -->
                    <div class="form-summary" id="form-summary" style="display: none;">
                        <div class="summary-header">
                            <div class="summary-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h3 class="summary-title">Resumen de tu registro</h3>
                            <p class="summary-description">Verifica que la información sea correcta</p>
                        </div>
                        <div class="summary-content">
                            <div class="summary-section">
                                <h4>Información Personal</h4>
                                <div class="summary-item">
                                    <span class="summary-label">Nombre:</span>
                                    <span class="summary-value" id="summary-name">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Email:</span>
                                    <span class="summary-value" id="summary-email">-</span>
                                </div>
                            </div>
                            <div class="summary-section">
                                <h4>Información del Negocio</h4>
                                <div class="summary-item">
                                    <span class="summary-label">Nombre del Negocio:</span>
                                    <span class="summary-value" id="summary-business">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Categoría:</span>
                                    <span class="summary-value" id="summary-category">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Tipo:</span>
                                    <span class="summary-value" id="summary-type">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Descripción:</span>
                                    <span class="summary-value" id="summary-description">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="summary-actions">
                            <button type="button" class="btn-edit" onclick="editForm()">
                                <i class="fas fa-edit"></i>
                                Editar información
                            </button>
                            <button type="button" class="btn-confirm" onclick="confirmSubmit()">
                                <i class="fas fa-check"></i>
                                Confirmar y registrar
                            </button>
                        </div>
                    </div>

                    <!-- Benefits Info -->
                    <div class="benefits-info">
                        <div class="benefits-card">
                            <div class="benefits-header">
                                <div class="benefits-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <h3 class="benefits-title">¡Es completamente gratis!</h3>
                            </div>
                            <p class="benefits-description">Al registrarte tendrás acceso a:</p>
                            <ul class="benefits-list">
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Panel de control personalizado</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Gestión completa de tu perfil comercial</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Contacto directo con clientes</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Estadísticas de visualización</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="login-link">
                            <p>¿Ya tienes cuenta?</p>
                            <a href="{{ route('login') }}" class="login-btn">
                                <i class="fas fa-sign-in-alt"></i>
                                Inicia sesión aquí
                            </a>
                        </div>

                        <button type="submit" class="submit-btn" id="submit-button">
                            <div class="btn-content">
                                <i class="fas fa-rocket"></i>
                                <span>Registrar mi Negocio</span>
                            </div>
                            <div class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Procesando registro...</span>
                            </div>
                        </button>
                        
                        <div class="form-progress" id="form-progress" style="display: none;">
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <p class="progress-text">Creando tu cuenta...</p>
                        </div>

                        <!-- reCAPTCHA Enterprise -->
                        <x-recaptcha-enterprise action="REGISTER" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
/* Register Section Styles */
.register-section {
    min-height: 100vh;
    background: var(--bg-light);
}

/* Hero Header */
.register-hero {
    position: relative;
    min-height: 50vh;
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
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
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
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    color: var(--text-white);
}

.text-accent {
    color: #fbbf24;
    text-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
}

.hero-description {
    font-size: 1.25rem;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.95;
    line-height: 1.6;
    color: var(--text-white);
}

/* Benefits Section */
.benefits-section {
    padding: 4rem 0;
    background: white;
    position: relative;
}

.benefits-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark), var(--primary-color));
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.benefit-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 1.5rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.benefit-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
    transition: left 0.5s ease;
}

.benefit-card:hover::before {
    left: 100%;
}

.benefit-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.benefit-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
    position: relative;
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
}

.benefit-icon::after {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    border: 2px solid var(--primary-color);
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s ease;
}

.benefit-card:hover .benefit-icon::after {
    opacity: 0.3;
    transform: scale(1);
}

.benefit-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.benefit-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* Form Section */
.form-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, var(--bg-light) 0%, #e5e7eb 100%);
    position: relative;
}

.form-container {
    max-width: 900px;
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
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark), #fbbf24, var(--primary-color));
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
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
    box-shadow: 0 15px 35px rgba(245, 158, 11, 0.3);
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

/* Error Banner */
.error-banner {
    margin: 2rem;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 1px solid #fecaca;
    border-radius: 1rem;
    padding: 1rem;
}

.error-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #dc2626;
    font-weight: 500;
}

.error-content i {
    font-size: 1.25rem;
}

/* Form Styles */
.register-form {
    padding: 2rem;
}

.form-section-wrapper {
    margin-bottom: 3rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--bg-light);
}

.section-icon {
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

.section-info {
    flex: 1;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.section-description {
    color: var(--text-light);
    font-size: 0.875rem;
}

.form-grid {
    display: grid;
    gap: 1.5rem;
}

.form-grid.grid-cols-2 {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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

.optional-badge {
    background: var(--bg-light);
    color: var(--text-light);
    padding: 0.125rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    margin-left: 0.5rem;
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

/* Select Styles */
.select-wrapper {
    position: relative;
}

.form-select {
    width: 100%;
    padding: 1rem 1.25rem;
    padding-right: 3rem;
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
    appearance: none;
    cursor: pointer;
}

.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-light);
    pointer-events: none;
    transition: transform 0.3s ease;
}

.form-select:focus + .select-arrow {
    transform: translateY(-50%) rotate(180deg);
    color: var(--primary-color);
}

/* Textarea Styles */
.textarea-wrapper {
    position: relative;
}

.form-textarea {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

.form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.textarea-counter {
    position: absolute;
    bottom: 0.75rem;
    right: 1rem;
    font-size: 0.75rem;
    color: var(--text-light);
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
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

/* Search Select Styles */
.search-select-wrapper {
    position: relative;
}

.search-select {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
}

.search-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

/* Select2 Custom Styles */
.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single {
    height: 60px !important;
    border: 2px solid var(--border-color) !important;
    border-radius: 1rem !important;
    padding: 0 1.25rem !important;
    display: flex !important;
    align-items: center !important;
    background: white !important;
    transition: all 0.3s ease !important;
}

.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important;
    outline: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--text-dark) !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    padding: 0 !important;
    margin: 0 !important;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: var(--text-light) !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 58px !important;
    right: 1rem !important;
    color: var(--text-light) !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: var(--text-light) transparent transparent transparent !important;
    border-style: solid !important;
    border-width: 6px 6px 0 6px !important;
    height: 0 !important;
    left: 50% !important;
    margin-left: -6px !important;
    margin-top: -3px !important;
    position: absolute !important;
    top: 50% !important;
    width: 0 !important;
}

.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent var(--primary-color) transparent !important;
    border-width: 0 6px 6px 6px !important;
}

.select2-dropdown {
    border: 2px solid var(--primary-color) !important;
    border-radius: 1rem !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    margin-top: 4px !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid var(--border-color) !important;
    border-radius: 0.75rem !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.875rem !important;
    margin: 0.75rem !important;
    width: calc(100% - 1.5rem) !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color: var(--primary-color) !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1) !important;
}

.select2-container--default .select2-results__option {
    padding: 0.75rem 1rem !important;
    font-size: 0.875rem !important;
    transition: all 0.2s ease !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--primary-color) !important;
    color: white !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: rgba(245, 158, 11, 0.1) !important;
    color: var(--primary-color) !important;
    font-weight: 600 !important;
}

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

@keyframes slideOutUp {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

/* Toast Notifications */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    padding: 1rem 1.5rem;
    transform: translateX(400px);
    transition: all 0.3s ease;
    z-index: 10000;
    max-width: 400px;
    border-left: 4px solid #3b82f6;
}

.toast.toast-success {
    border-left-color: #059669;
}

.toast.toast-error {
    border-left-color: #dc2626;
}

.toast.show {
    transform: translateX(0);
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--text-dark);
    font-weight: 500;
}

.toast-content i {
    font-size: 1.25rem;
}

.toast.toast-success .toast-content i {
    color: #059669;
}

.toast.toast-error .toast-content i {
    color: #dc2626;
}

/* Form Error States */
.form-group.has-error .form-input,
.form-group.has-error .form-select,
.form-group.has-error .form-textarea {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
}

.form-group.has-error .select2-container--default .select2-selection--single {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
}

/* Password Strength Indicator */
.password-strength {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.strength-weak {
    color: #dc2626;
}

.strength-medium {
    color: #f59e0b;
}

.strength-strong {
    color: #059669;
}

/* Loading States */
.submit-btn.loading {
    pointer-events: none;
    opacity: 0.8;
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
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
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

/* Enhanced Form States */
.form-group.success .form-input,
.form-group.success .form-select,
.form-group.success .form-textarea {
    border-color: #059669 !important;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1) !important;
}

.form-group.success .select2-container--default .select2-selection--single {
    border-color: #059669 !important;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1) !important;
}

.success-indicator {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #059669;
    font-size: 1rem;
    z-index: 10;
}

.form-group.success .input-wrapper::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #059669;
    font-size: 1rem;
    z-index: 10;
}

/* Form Summary */
.form-summary {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 1px solid #7dd3fc;
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    animation: slideInUp 0.5s ease-out;
}

.summary-header {
    text-align: center;
    margin-bottom: 2rem;
}

.summary-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
    box-shadow: 0 10px 25px rgba(14, 165, 233, 0.3);
}

.summary-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.summary-description {
    color: var(--text-light);
    font-size: 0.875rem;
}

.summary-content {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.summary-section h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--bg-light);
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-label {
    font-weight: 600;
    color: var(--text-dark);
    min-width: 140px;
}

.summary-value {
    color: var(--text-light);
    text-align: right;
    flex: 1;
    word-break: break-word;
}

.summary-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-edit,
.btn-confirm {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 1rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-edit {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 2px solid var(--border-color);
}

.btn-edit:hover {
    background: var(--border-color);
    transform: translateY(-2px);
}

.btn-confirm {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
}

.btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Improved Select2 Responsiveness */
@media (max-width: 768px) {
    .select2-dropdown {
        border-radius: 0.75rem !important;
    }
    
    .select2-container--default .select2-selection--single {
        height: 50px !important;
        padding: 0 1rem !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 0.75rem !important;
    }
}

/* Benefits Info */
.benefits-info {
    margin-bottom: 2rem;
}

.benefits-card {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1px solid #fde68a;
    border-radius: 1.5rem;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.benefits-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 0.8; }
}

.benefits-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.benefits-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.benefits-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
}

.benefits-description {
    color: var(--text-light);
    margin-bottom: 1rem;
    font-weight: 500;
}

.benefits-list {
    list-style: none;
    space-y: 0.75rem;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.benefits-list i {
    color: #059669;
    font-size: 1rem;
    flex-shrink: 0;
}

.benefits-list span {
    color: var(--text-dark);
    font-weight: 500;
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

.login-link {
    text-align: center;
}

.login-link p {
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.login-btn {
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

.login-btn:hover {
    background: rgba(245, 158, 11, 0.1);
    transform: translateY(-2px);
}

.submit-btn {
    position: relative;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
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
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
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
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
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

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.125rem;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
    }
    
    .form-grid.grid-cols-2 {
        grid-template-columns: 1fr;
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
    
    .register-form {
        padding: 1.5rem;
    }
    
    .submit-btn {
        min-width: 100%;
        padding: 1rem 2rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .form-title {
        font-size: 1.75rem;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .section-info {
        text-align: center;
    }
}

/* Animation Classes */
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

[data-aos-delay="600"] {
    animation-delay: 0.6s;
}
</style>

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Hide toast after 5 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 5000);
}

// Form validation
function validateForm() {
    const form = document.querySelector('.register-form');
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        const wrapper = input.closest('.form-group');
        const errorElement = wrapper.querySelector('.error-message');
        
        if (!input.value.trim()) {
            isValid = false;
            wrapper.classList.add('has-error');
            
            if (!errorElement) {
                const error = document.createElement('div');
                error.className = 'error-message';
                error.innerHTML = `
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Este campo es obligatorio</span>
                `;
                wrapper.appendChild(error);
            }
        } else {
            wrapper.classList.remove('has-error');
            if (errorElement) {
                errorElement.remove();
            }
        }
    });
    
    // Validate password confirmation
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    if (password.value && passwordConfirmation.value && password.value !== passwordConfirmation.value) {
        isValid = false;
        const wrapper = passwordConfirmation.closest('.form-group');
        wrapper.classList.add('has-error');
        
        const errorElement = wrapper.querySelector('.error-message');
        if (!errorElement) {
            const error = document.createElement('div');
            error.className = 'error-message';
            error.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span>Las contraseñas no coinciden</span>
            `;
            wrapper.appendChild(error);
        } else {
            errorElement.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span>Las contraseñas no coinciden</span>
            `;
        }
    }
    
    return isValid;
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for search selects
    $('.search-select').select2({
        placeholder: function() {
            return $(this).data('placeholder');
        },
        allowClear: false,
        width: '100%',
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            },
            searching: function() {
                return "Buscando...";
            }
        }
    });
    
    // Character counter for textarea
    const textarea = document.getElementById('descripcion_corta');
    const counter = document.getElementById('char-count');
    
    if (textarea && counter) {
        // Initial count
        counter.textContent = textarea.value.length;
        
        // Update counter on input
        textarea.addEventListener('input', function() {
            counter.textContent = this.value.length;
            
            // Change color if approaching limit
            if (this.value.length > 180) {
                counter.style.color = '#dc2626';
            } else if (this.value.length > 150) {
                counter.style.color = '#f59e0b';
            } else {
                counter.style.color = 'var(--text-light)';
            }
        });
    }
    
    // Form submission with validation and progress
    const form = document.querySelector('.register-form');
    const submitBtn = document.querySelector('.submit-btn');
    const progressContainer = document.getElementById('form-progress');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                showToast('Por favor corrige los errores en el formulario', 'error');
                return;
            }
            
            // Show form summary instead of submitting immediately
            showFormSummary();
        });
        
        // Enhanced real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                const wrapper = this.closest('.form-group');
                if (this.value.trim()) {
                    wrapper.classList.remove('has-error');
                    const errorElement = wrapper.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.remove();
                    }
                    
                    // Add success state for completed fields
                    if (this.hasAttribute('required')) {
                        wrapper.classList.add('success');
                    }
                } else {
                    wrapper.classList.remove('success');
                }
            });
        });
        
        // Email validation
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const wrapper = this.closest('.form-group');
                const email = this.value.trim();
                
                if (email && !isValidEmail(email)) {
                    wrapper.classList.add('has-error');
                    wrapper.classList.remove('success');
                    
                    let errorElement = wrapper.querySelector('.error-message');
                    if (!errorElement) {
                        errorElement = document.createElement('div');
                        errorElement.className = 'error-message';
                        wrapper.appendChild(errorElement);
                    }
                    
                    errorElement.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Por favor ingresa un email válido</span>
                    `;
                } else if (email && isValidEmail(email)) {
                    wrapper.classList.remove('has-error');
                    wrapper.classList.add('success');
                    const errorElement = wrapper.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.remove();
                    }
                }
            });
        }
    }
    
    // Field validation function
    function validateField(field) {
        const wrapper = field.closest('.form-group');
        const errorElement = wrapper.querySelector('.error-message');
        
        // Remove previous states
        wrapper.classList.remove('has-error', 'success');
        if (errorElement) {
            errorElement.remove();
        }
        
        if (field.hasAttribute('required') && !field.value.trim()) {
            wrapper.classList.add('has-error');
            
            const error = document.createElement('div');
            error.className = 'error-message';
            error.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span>Este campo es obligatorio</span>
            `;
            wrapper.appendChild(error);
        } else if (field.value.trim()) {
            // Special validation for email
            if (field.type === 'email' && !isValidEmail(field.value)) {
                wrapper.classList.add('has-error');
                
                const error = document.createElement('div');
                error.className = 'error-message';
                error.innerHTML = `
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Por favor ingresa un email válido</span>
                `;
                wrapper.appendChild(error);
            } else {
                wrapper.classList.add('success');
            }
        }
    }
    
    // Email validation helper
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Update form summary
    function updateFormSummary() {
        const name = document.getElementById('name')?.value || '-';
        const email = document.getElementById('email')?.value || '-';
        const businessName = document.getElementById('nombre_comercio')?.value || '-';
        const category = document.getElementById('categoria');
        const categoryText = category?.selectedOptions[0]?.text || '-';
        const type = document.getElementById('tipo_comercio');
        const typeText = type?.selectedOptions[0]?.text || '-';
        const description = document.getElementById('descripcion_corta')?.value || 'Sin descripción';
        
        document.getElementById('summary-name').textContent = name;
        document.getElementById('summary-email').textContent = email;
        document.getElementById('summary-business').textContent = businessName;
        document.getElementById('summary-category').textContent = categoryText;
        document.getElementById('summary-type').textContent = typeText;
        document.getElementById('summary-description').textContent = description;
    }
    
    // Show form summary before submit
    function showFormSummary() {
        updateFormSummary();
        document.getElementById('form-summary').style.display = 'block';
        document.getElementById('submit-button').style.display = 'none';
        
        // Scroll to summary
        document.getElementById('form-summary').scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
    
    // Hide form summary and return to edit
    function editForm() {
        document.getElementById('form-summary').style.display = 'none';
        document.getElementById('submit-button').style.display = 'block';
    }
    
    // Confirm and submit form
    function confirmSubmit() {
        const form = document.querySelector('.register-form');
        const submitBtn = document.querySelector('.submit-btn');
        const progressContainer = document.getElementById('form-progress');
        const progressFill = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-text');
        
        // Hide summary and show loading
        document.getElementById('form-summary').style.display = 'none';
        document.getElementById('submit-button').style.display = 'block';
        
        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        
        // Show progress
        progressContainer.style.display = 'block';
        
        // Animate progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;
            
            progressFill.style.width = progress + '%';
            
            if (progress < 30) {
                progressText.textContent = 'Validando información...';
            } else if (progress < 60) {
                progressText.textContent = 'Creando tu cuenta...';
            } else {
                progressText.textContent = 'Configurando tu perfil...';
            }
        }, 200);
        
        // Submit form
        setTimeout(() => {
            clearInterval(progressInterval);
            progressFill.style.width = '100%';
            progressText.textContent = 'Completando registro...';
            
            setTimeout(() => {
                form.submit();
            }, 300);
        }, 1500);
    }
    
    // Make functions global
    window.editForm = editForm;
    window.confirmSubmit = confirmSubmit;
    
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const wrapper = this.closest('.form-group');
            let strengthIndicator = wrapper.querySelector('.password-strength');
            
            if (!strengthIndicator) {
                strengthIndicator = document.createElement('div');
                strengthIndicator.className = 'password-strength';
                wrapper.appendChild(strengthIndicator);
            }
            
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    feedback = '<span class="strength-weak">Débil</span>';
                    break;
                case 2:
                case 3:
                    feedback = '<span class="strength-medium">Medio</span>';
                    break;
                case 4:
                case 5:
                    feedback = '<span class="strength-strong">Fuerte</span>';
                    break;
            }
            
            strengthIndicator.innerHTML = password.length > 0 ? `Seguridad: ${feedback}` : '';
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
    
    // Auto-hide messages after some time
    setTimeout(() => {
        const successBanner = document.querySelector('.success-banner');
        const errorBanner = document.querySelector('.error-banner');
        const validationBanner = document.querySelector('.validation-errors-banner');
        
        if (successBanner) {
            successBanner.style.animation = 'slideOutUp 0.5s ease-out forwards';
            setTimeout(() => successBanner.remove(), 500);
        }
        
        if (errorBanner) {
            errorBanner.style.animation = 'slideOutUp 0.5s ease-out forwards';
            setTimeout(() => errorBanner.remove(), 500);
        }
        
        if (validationBanner) {
            validationBanner.style.animation = 'slideOutUp 0.5s ease-out forwards';
            setTimeout(() => validationBanner.remove(), 500);
        }
    }, 8000);
});
</script>
@endpush
@endsection
