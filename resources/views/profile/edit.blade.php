@extends('layouts.dashboard')

@section('title', 'Mi Perfil - Lokal Colombia')
@section('page-title', 'Mi Perfil')

@section('content')
<div class="dashboard-content">


    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-header-content">
            <div class="profile-avatar">
                <div class="avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                <p class="profile-email">{{ auth()->user()->email }}</p>
                <div class="profile-status">
                    @if(auth()->user()->hasVerifiedEmail())
                        <span class="status-badge verified">
                            <i class="fas fa-check-circle"></i>
                            Email verificado
                        </span>
                    @else
                        <span class="status-badge unverified">
                            <i class="fas fa-exclamation-circle"></i>
                            Email pendiente de verificación
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Forms Grid -->
    <div class="profile-forms-grid">
        <!-- Update Profile Information -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="form-card-title">
                    <h3>Información Personal</h3>
                    <p>Actualiza tu información de perfil y dirección de correo electrónico.</p>
                </div>
            </div>
            <div class="form-card-content">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="form-card-title">
                    <h3>Actualizar Contraseña</h3>
                    <p>Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerse segura.</p>
                </div>
            </div>
            <div class="form-card-content">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="form-card danger">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="form-card-title">
                    <h3>Eliminar Cuenta</h3>
                    <p>Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.</p>
                </div>
            </div>
            <div class="form-card-content">
                @include('profile.partials.delete-user-button')
            </div>
        </div>
    </div>
</div>

<style>
    /* Variables específicas para el perfil - no sobrescribir las globales */
    .profile-forms-grid {
        --profile-primary: #f97316;
        --profile-primary-dark: #ea580c;
        --profile-success: #10b981;
        --profile-text-dark: #1f2937;
        --profile-text-light: #6b7280;
        --profile-border: #e5e7eb;
        --profile-bg-light: #f9fafb;
    }

    /* Profile Header */
    .profile-header {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--profile-border);
    }

    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .profile-avatar {
        flex-shrink: 0;
    }

    .avatar-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--profile-primary), var(--profile-primary-dark));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        color: white;
        text-transform: uppercase;
        box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--profile-text-dark);
        margin: 0 0 0.25rem 0;
    }

    .profile-email {
        font-size: 1rem;
        color: var(--profile-text-light);
        margin: 0 0 1rem 0;
    }

    .profile-status {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-badge.verified {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #059669;
        border: 1px solid #10b981;
    }

    .status-badge.unverified {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #d97706;
        border: 1px solid #f59e0b;
    }

    .profile-forms-grid {
        display: grid;
        gap: 2rem;
        margin-top: 0;
    }

    .form-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .form-card.danger {
        border: 1px solid #fee2e2;
    }

    .form-card.danger:hover {
        border-color: #fecaca;
    }

    .form-card-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-card.danger .form-card-header {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border-bottom-color: #fecaca;
    }

    .form-card-icon {
        width: 3rem;
        height: 3rem;
        background: var(--profile-primary);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .form-card.danger .form-card-icon {
        background: #ef4444;
    }

    .form-card-title h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--profile-text-dark);
        margin: 0 0 0.25rem 0;
    }

    .form-card-title p {
        font-size: 0.875rem;
        color: var(--profile-text-light);
        margin: 0;
        line-height: 1.4;
    }

    .form-card-content {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--profile-text-dark);
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--profile-border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--profile-primary);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }

    .form-error {
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: #dc2626;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-error::before {
        content: '⚠';
        font-size: 0.875rem;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .success-message {
        color: var(--profile-success);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .success-message::before {
        content: '✓';
        font-weight: bold;
    }

    /* Verification Notice */
    .verification-notice {
        margin-top: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #f59e0b;
        border-radius: 0.75rem;
    }

    .verification-text {
        font-size: 0.875rem;
        color: #92400e;
        margin-bottom: 0.5rem;
    }

    .verification-link {
        background: none;
        border: none;
        color: var(--profile-primary);
        text-decoration: underline;
        cursor: pointer;
        font-size: 0.875rem;
        padding: 0;
    }

    .verification-link:hover {
        color: var(--profile-primary-dark);
    }

    .verification-success {
        font-size: 0.875rem;
        color: var(--profile-success);
        font-weight: 600;
        margin-top: 0.5rem;
    }

    /* Delete Section */
    .delete-section {
        text-align: center;
        padding: 2rem;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-container {
        width: 90%;
        max-width: 500px;
        margin: 0 auto;
    }

    .modal-content {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--profile-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--profile-text-dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: var(--profile-text-light);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: var(--profile-bg-light);
        color: var(--profile-text-dark);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-text {
        color: var(--profile-text-light);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--profile-border);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Responsive adjustments */
    @media (min-width: 768px) {
        .profile-forms-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 1024px) {
        .profile-forms-grid {
            grid-template-columns: 1fr 1fr;
        }

        .form-card.danger {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 768px) {
        .modal-container {
            width: 95%;
        }
        
        .modal-footer {
            flex-direction: column;
        }

        .profile-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .avatar-circle {
            width: 70px;
            height: 70px;
            font-size: 1.75rem;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .profile-status {
            justify-content: center;
        }
    }
</style>

@push('scripts')
@endpush

<!-- Modal de eliminación fuera de todos los contenedores -->
@include('profile.partials.delete-user-modal')

@endsection
