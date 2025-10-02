@extends('layouts.dashboard')

@section('title', 'Dashboard - Lokal Colombia')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-content">
    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('warning') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-card">
            <div class="welcome-content">
                <h2 class="welcome-title">
                    ¡Bienvenido, {{ $user->name }}!
                </h2>
                <p class="welcome-description">
                    @if($comercio)
                        Gestiona tu negocio "{{ $comercio->titulo }}" desde este panel de control.
                    @else
                        Completa la información de tu negocio para comenzar a recibir más clientes.
                    @endif
                </p>
            </div>
            <div class="welcome-icon">
                <i class="fas fa-rocket"></i>
            </div>
        </div>
    </div>

    <!-- Email Verification Alert -->
    @if(!$user->hasVerifiedEmail())
        <div class="verification-alert">
            <div class="verification-content">
                <div class="verification-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="verification-text">
                    <h3>Verifica tu correo electrónico</h3>
                    <p>Necesitas verificar tu correo para poder editar la información de tu comercio y acceder a todas las funcionalidades.</p>
                    <div class="verification-actions">
                        <form method="POST" action="{{ route('dashboard.resend-verification') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Reenviar correo de verificación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Profile Completeness -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon completeness">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-title">Completitud del Perfil</h3>
                    <p class="stat-value">{{ $completitud }}%</p>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $completitud }}%"></div>
            </div>
            <p class="stat-description">
                @if($completitud < 50)
                    Tu perfil necesita más información para atraer clientes.
                @elseif($completitud < 80)
                    ¡Vas bien! Completa más información para mejorar tu visibilidad.
                @else
                    ¡Excelente! Tu perfil está casi completo.
                @endif
            </p>
        </div>

        <!-- Email Status -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon {{ $user->hasVerifiedEmail() ? 'verified' : 'pending' }}">
                    <i class="fas fa-{{ $user->hasVerifiedEmail() ? 'check-circle' : 'clock' }}"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-title">Estado del Email</h3>
                    <p class="stat-value">{{ $user->hasVerifiedEmail() ? 'Verificado' : 'Pendiente' }}</p>
                </div>
            </div>
            <p class="stat-description">
                @if($user->hasVerifiedEmail())
                    Tu correo electrónico está verificado correctamente.
                @else
                    Verifica tu correo para acceder a todas las funciones.
                @endif
            </p>
        </div>

        <!-- Business Status -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon business {{ $comercio ? strtolower($comercio->estado) : 'pending' }}">
                    <i class="fas fa-{{ $comercio && $comercio->estado === 'aprobado' ? 'check-circle' : ($comercio && $comercio->estado === 'rechazado' ? 'times-circle' : ($comercio && $comercio->estado === 'eliminado' ? 'trash' : 'clock')) }}"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-title">Estado del Negocio</h3>
                    <p class="stat-value">
                        @if($comercio)
                            @switch($comercio->estado)
                                @case('aprobado')
                                    Aprobado
                                    @break
                                @case('rechazado')
                                    Rechazado
                                    @break
                                @case('eliminado')
                                    Eliminado
                                    @break
                                @default
                                    Pendiente
                            @endswitch
                        @else
                            Sin Registrar
                        @endif
                    </p>
                </div>
            </div>
            <p class="stat-description">
                @if($comercio)
                    @switch($comercio->estado)
                        @case('aprobado')
                            Tu negocio está aprobado y visible en la plataforma.
                            @break
                        @case('rechazado')
                            Tu negocio fue rechazado. Revisa la información y corrígela.
                            @break
                        @case('eliminado')
                            Tu negocio está marcado como eliminado.
                            @break
                        @default
                            Tu negocio está en revisión, será visible una vez aprobado.
                    @endswitch
                @else
                    Completa la información de tu negocio para comenzar el proceso de registro.
                @endif
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3 class="section-title">Acciones Rápidas</h3>
        <div class="actions-grid">
            <a href="{{ route('dashboard.comercio') }}" class="action-card {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}">
                <div class="action-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="action-content">
                    <h4 class="action-title">Editar Información</h4>
                    <p class="action-description">Actualiza los datos de tu comercio</p>
                </div>
                @if(!$user->hasVerifiedEmail())
                    <div class="action-badge">
                        <i class="fas fa-lock"></i>
                    </div>
                @endif
            </a>

            @if($comercio)
                <a href="{{ route('comercio.detalle', $comercio->slug) }}" class="action-card" target="_blank">
                    <div class="action-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="action-content">
                        <h4 class="action-title">Ver mi Comercio</h4>
                        <p class="action-description">Revisa cómo se ve tu negocio</p>
                    </div>
                </a>
            @endif

            <a href="{{ route('profile.edit') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="action-content">
                    <h4 class="action-title">Mi Perfil</h4>
                    <p class="action-description">Gestiona tu cuenta de usuario</p>
                </div>
            </a>

            <a href="{{ route('home') }}" class="action-card" target="_blank">
                <div class="action-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="action-content">
                    <h4 class="action-title">Ver Sitio Web</h4>
                    <p class="action-description">Explora la plataforma completa</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Business Info Summary -->
    @if($comercio)
        <div class="business-summary">
            <h3 class="section-title">Resumen de tu Negocio</h3>
            <div class="summary-card">
                <div class="summary-header">
                    <div class="business-logo">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="business-info">
                        <h4 class="business-name">{{ $comercio->titulo }}</h4>
                        <p class="business-category">
                            {{ $comercio->categoria->nombre ?? 'Sin categoría' }} - 
                            {{ $comercio->tipoComercio->nombre ?? 'Sin tipo' }}
                        </p>
                    </div>
                    <div class="business-status">
                        <span class="status-badge {{ $comercio->estado === 'aprobado' ? 'active' : ($comercio->estado === 'rechazado' ? 'rejected' : ($comercio->estado === 'eliminado' ? 'deleted' : 'pending')) }}">
                            <i class="fas fa-{{ $comercio->estado === 'aprobado' ? 'check' : ($comercio->estado === 'rechazado' ? 'times' : ($comercio->estado === 'eliminado' ? 'trash' : 'clock')) }}"></i>
                            @switch($comercio->estado)
                                @case('aprobado')
                                    Aprobado
                                    @break
                                @case('rechazado')
                                    Rechazado
                                    @break
                                @case('eliminado')
                                    Eliminado
                                    @break
                                @default
                                    Pendiente
                            @endswitch
                        </span>
                    </div>
                </div>
                
                @if($comercio->descripcionCorta)
                    <div class="summary-description">
                        <p>{{ $comercio->descripcionCorta }}</p>
                    </div>
                @endif

                <div class="summary-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Registrado: {{ $comercio->publicadoEn ? $comercio->publicadoEn->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    @if($comercio->actualizadoEn)
                        <div class="meta-item">
                            <i class="fas fa-edit"></i>
                            <span>Última actualización: {{ $comercio->actualizadoEn->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.dashboard-content {
    max-width: 1200px;
    margin: 0 auto;
}

/* Welcome Section */
.welcome-section {
    margin-bottom: 2rem;
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 1.5rem;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.welcome-content {
    flex: 1;
    z-index: 2;
}

.welcome-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.welcome-description {
    font-size: 1.125rem;
    opacity: 0.9;
}

.welcome-icon {
    font-size: 4rem;
    opacity: 0.3;
    z-index: 1;
}

/* Verification Alert */
.verification-alert {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 1px solid #f59e0b;
    border-radius: 1.5rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.verification-content {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.verification-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.verification-text h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 0.5rem;
}

.verification-text p {
    color: #92400e;
    margin-bottom: 1rem;
}

.verification-actions {
    display: flex;
    gap: 1rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.stat-icon.completeness {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

.stat-icon.verified {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stat-icon.pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-icon.business {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.stat-icon.business.aprobado {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stat-icon.business.rechazado {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.stat-icon.business.eliminado {
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

.stat-icon.business.pendiente {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-dark);
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: var(--bg-light);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.75rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    border-radius: 4px;
    transition: width 0.5s ease;
}

.stat-description {
    font-size: 0.875rem;
    color: var(--text-light);
}

/* Section Title */
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 1.5rem;
    background: var(--primary-color);
    border-radius: 2px;
}

/* Quick Actions */
.quick-actions {
    margin-bottom: 2rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
}

.action-card:hover:not(.disabled) {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: var(--primary-color);
}

.action-card.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.action-icon {
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

.action-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.action-description {
    font-size: 0.875rem;
    color: var(--text-light);
}

.action-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #dc2626;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

/* Business Summary */
.business-summary {
    margin-bottom: 2rem;
}

.summary-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.business-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.business-info {
    flex: 1;
}

.business-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.business-category {
    color: var(--text-light);
    font-size: 0.875rem;
}

.business-status {
    flex-shrink: 0;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.active {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #059669;
}

.status-badge.pending {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #d97706;
}

.status-badge.rejected {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #dc2626;
}

.status-badge.deleted {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #6b7280;
}

.summary-description {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 0.75rem;
}

.summary-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-light);
}

.meta-item i {
    color: var(--primary-color);
}

/* Animations */
@keyframes pulse {
    0%, 100% { transform: scale(0.8); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 0.8; }
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .verification-content {
        flex-direction: column;
        text-align: center;
    }
    
    .summary-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .summary-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
}
</style>
@endsection