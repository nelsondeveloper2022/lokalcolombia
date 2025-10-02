<!-- Modal de confirmación de eliminación - Posicionado fuera de contenedores -->
<div x-data="{ 
        show: @js($errors->userDeletion->isNotEmpty()),
        init() {
            // Solo mostrar si hay errores de validación
            if (!@js($errors->userDeletion->isNotEmpty())) {
                this.show = false;
            }
        },
        toggleModal(state) {
            this.show = state;
            if (state) {
                // Desactivar scroll del body y html
                document.body.classList.add('modal-open');
                document.documentElement.classList.add('modal-open');
            } else {
                // Reactivar scroll del body y html
                document.body.classList.remove('modal-open');
                document.documentElement.classList.remove('modal-open');
            }
        }
     }"
     x-show="show"
     x-on:open-modal.window="if ($event.detail === 'confirm-account-deletion') toggleModal(true)"
     x-on:close.window="toggleModal(false)"
     x-on:keydown.escape.window="toggleModal(false)"
     x-on:click="toggleModal(false)"
     class="deletion-modal-overlay"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="deletion-modal-container"
         x-on:click.stop=""
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
                <button type="button" x-on:click="toggleModal(false)" class="deletion-modal-close">
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
                <button type="button" x-on:click="toggleModal(false)" class="btn btn-secondary btn-large">
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
/* Modal Styles - Posicionamiento absoluto fuera de contenedores */
.deletion-modal-overlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background-color: rgba(0, 0, 0, 0.75) !important;
    align-items: center !important;
    justify-content: center !important;
    z-index: 99999 !important;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    padding: 1rem;
    margin: 0 !important;
    overflow-y: auto !important;
}

/* Prevenir scroll del body cuando el modal está abierto */
body.modal-open {
    overflow: hidden !important;
    position: fixed !important;
    width: 100% !important;
}

html.modal-open {
    overflow: hidden !important;
}

.deletion-modal-overlay[style*="block"] {
    display: flex !important;
}

.deletion-modal-container {
    max-width: 600px;
    width: 100%;
    max-height: 95vh;
    margin: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
}

.deletion-modal-content {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    overflow-y: auto;
    position: relative;
    margin: 0 auto;
    width: 100%;
    max-width: 600px;
    max-height: 95vh;
    display: flex;
    flex-direction: column;
}

.deletion-modal-header {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    padding: 2rem;
    position: relative;
    text-align: center;
}

.deletion-modal-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.5rem;
}

.deletion-modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.deletion-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.deletion-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.deletion-modal-body {
    padding: 2rem;
    flex: 1;
    overflow-y: auto;
}

.deletion-warning-box {
    background: #fef2f2;
    border: 2px solid #fecaca;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.deletion-warning-text {
    color: #7f1d1d;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.deletion-warning-text:last-child {
    margin-bottom: 0;
}

.deletion-items-list {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.deletion-items-list h4 {
    color: #374151;
    font-weight: 600;
    margin: 0 0 1rem 0;
    font-size: 1rem;
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
    font-weight: 500;
}

.deletion-items-list li i {
    color: #dc2626;
    width: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #d1d5db;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-input:focus {
    outline: none;
    border-color: #dc2626;
    background: white;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
}

.deletion-input {
    background: #fef2f2;
    border-color: #fecaca;
}

.deletion-input:focus {
    background: white;
    border-color: #dc2626;
}

.form-error {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.deletion-modal-footer {
    background: #f9fafb;
    padding: 2rem;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    border-top: 1px solid #e5e7eb;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.75rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 160px;
    justify-content: center;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 2px solid #d1d5db;
}

.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-destructive {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    position: relative;
    overflow: hidden;
}

.btn-destructive:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
}

.btn-destructive::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-destructive:hover::before {
    left: 100%;
}

/* Responsive */
@media (max-width: 640px) {
    .deletion-modal-overlay {
        padding: 0.5rem;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .deletion-modal-container {
        width: 95%;
        margin: 0 auto;
    }
    
    .deletion-modal-content {
        width: 100%;
        margin: 0;
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
}
</style>