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
    font-weight: 500;
}

.btn-delete-account {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.btn-delete-account:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
}

.btn-delete-account::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-delete-account:hover::before {
    left: 100%;
}

/* Responsive */
@media (max-width: 640px) {
    .delete-account-section {
        padding: 1.5rem;
    }
    
    .delete-warning {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .warning-content h4 {
        font-size: 1.125rem;
    }
    
    .btn-delete-account {
        padding: 0.875rem 1.5rem;
        font-size: 0.95rem;
    }
}
</style>