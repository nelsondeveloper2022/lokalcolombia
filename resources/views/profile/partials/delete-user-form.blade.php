<!-- Delete Section -->
<div class="delete-account-section">
    <div class="delete-warning">
        <div class="warning-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="warning-content">
            <h4>Zona de Peligro</h4>
            <p>Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, asegúrate de que realmente deseas hacer esto.</p>
        </div>
    </div>
    
    <button type="button" 
            class="btn btn-danger btn-delete-account"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-account-deletion')">
        <i class="fas fa-trash"></i>
        Eliminar Cuenta Permanentemente
    </button>
</div>

<!-- Modal de confirmación mejorado -->
<div x-data="{ show: @js($errors->userDeletion->isNotEmpty()) }"
     x-show="show"
     x-on:open-modal.window="if ($event.detail === 'confirm-account-deletion') show = true"
     x-on:close.window="show = false"
     x-on:keydown.escape.window="show = false"
     class="deletion-modal-overlay"
     style="display: none;"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="deletion-modal-container"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90">
        <form method="post" action="{{ route('account.destroy') }}" class="deletion-modal-content">
            @csrf
            @method('delete')

            <div class="deletion-modal-header">
                <div class="deletion-modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="deletion-modal-title">¡Atención! Eliminación Permanente</h2>
                <button type="button" x-on:click="show = false" class="deletion-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="deletion-modal-body">
                <div class="deletion-warning-box">
                    <p class="deletion-warning-text">
                        <strong>Si eliminas tu cuenta, perderás absolutamente toda tu información.</strong> 
                        Esto incluye tu usuario, tu comercio y todos sus derivados.
                    </p>
                    <p class="deletion-warning-text">
                        Si en el futuro deseas volver a publicar tu comercio, deberás registrarte nuevamente desde cero.
                    </p>
                </div>

                <div class="deletion-items-list">
                    <h4>Se eliminará permanentemente:</h4>
                    <ul>
                        <li><i class="fas fa-user"></i> Tu cuenta de usuario</li>
                        <li><i class="fas fa-store"></i> Tu comercio y toda su información</li>
                        <li><i class="fas fa-images"></i> Todas las imágenes y archivos</li>
                        <li><i class="fas fa-comments"></i> Comentarios y reseñas</li>
                        <li><i class="fas fa-heart"></i> Favoritos y contactos</li>
                        <li><i class="fas fa-envelope"></i> Comunicados y mensajes</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="deletion_password" class="form-label">
                        <strong>Confirma tu contraseña para proceder:</strong>
                    </label>
                    <input id="deletion_password" 
                           name="password" 
                           type="password" 
                           class="form-input deletion-input" 
                           placeholder="Ingresa tu contraseña actual"
                           required />
                    @error('password', 'userDeletion')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="deletion-modal-footer">
                <button type="button" x-on:click="show = false" class="btn btn-secondary btn-large">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </button>
                <button type="submit" class="btn btn-danger btn-large btn-destructive">
                    <i class="fas fa-trash"></i>
                    Eliminar Definitivamente
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Estilos para la sección de eliminación */
.delete-account-section {
    margin-top: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 2px solid #fecaca;
    border-radius: 1rem;
}

.delete-warning {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.warning-icon {
    width: 50px;
    height: 50px;
    background: #ef4444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.warning-content h4 {
    color: #dc2626;
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.warning-content p {
    color: #991b1b;
    margin: 0;
    line-height: 1.5;
}

.btn-delete-account {
    width: 100%;
    padding: 1rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
}

/* Estilos para el modal de eliminación */
.deletion-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
}

.deletion-modal-container {
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.deletion-modal-content {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
}

.deletion-modal-header {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    padding: 2rem;
    text-align: center;
    position: relative;
    border-bottom: 1px solid #fecaca;
}

.deletion-modal-icon {
    width: 80px;
    height: 80px;
    background: #ef4444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    margin: 0 auto 1rem auto;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.deletion-modal-title {
    color: #dc2626;
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0;
}

.deletion-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.deletion-modal-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #374151;
}

.deletion-modal-body {
    padding: 2rem;
}

.deletion-warning-box {
    background: #fff7ed;
    border: 2px solid #fed7aa;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.deletion-warning-text {
    color: #9a3412;
    margin: 0 0 1rem 0;
    line-height: 1.6;
}

.deletion-warning-text:last-child {
    margin-bottom: 0;
}

.deletion-items-list {
    margin-bottom: 2rem;
}

.deletion-items-list h4 {
    color: #374151;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.deletion-items-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.deletion-items-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    color: #6b7280;
}

.deletion-items-list li i {
    color: #ef4444;
    width: 20px;
}

.deletion-input {
    border: 2px solid #fecaca !important;
}

.deletion-input:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.deletion-modal-footer {
    background: #f9fafb;
    padding: 2rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    font-weight: 600;
    min-width: 180px;
}

.btn-destructive {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from { box-shadow: 0 0 20px rgba(239, 68, 68, 0.4); }
    to { box-shadow: 0 0 30px rgba(239, 68, 68, 0.6); }
}

.btn-destructive:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 640px) {
    .deletion-modal-overlay {
        padding: 0.5rem;
    }
    
    .deletion-modal-header {
        padding: 1.5rem;
    }
    
    .deletion-modal-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
    
    .deletion-modal-title {
        font-size: 1.25rem;
    }
    
    .deletion-modal-body {
        padding: 1.5rem;
    }
    
    .deletion-modal-footer {
        flex-direction: column;
        padding: 1.5rem;
    }
    
    .btn-large {
        min-width: auto;
        width: 100%;
    }
    
    .delete-warning {
        flex-direction: column;
        text-align: center;
    }
}
</style>
