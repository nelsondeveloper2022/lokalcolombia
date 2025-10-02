<!-- Notificaciones Flotantes -->
<div id="notification-container" class="notification-container"></div>

<script>
class NotificationSystem {
    constructor() {
        this.container = document.getElementById('notification-container');
        this.notifications = [];
        this.init();
    }

    init() {
        // Escuchar eventos de notificación personalizados
        window.addEventListener('show-notification', (event) => {
            this.show(event.detail.message, event.detail.type || 'info', event.detail.duration || 5000);
        });

        // Mostrar notificaciones existentes del servidor
        this.showServerNotifications();
    }

    show(message, type = 'info', duration = 5000) {
        const notification = this.createNotification(message, type);
        this.container.appendChild(notification);
        this.notifications.push(notification);

        // Animación de entrada
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);

        // Auto-ocultar después del tiempo especificado
        if (duration > 0) {
            setTimeout(() => {
                this.hide(notification);
            }, duration);
        }

        return notification;
    }

    createNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };

        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="${icons[type] || icons.info}"></i>
                </div>
                <div class="notification-message">
                    ${message}
                </div>
                <button class="notification-close" onclick="notificationSystem.hide(this.closest('.notification'))">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="notification-progress"></div>
        `;

        return notification;
    }

    hide(notification) {
        if (!notification) return;

        notification.classList.add('hide');
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            
            const index = this.notifications.indexOf(notification);
            if (index > -1) {
                this.notifications.splice(index, 1);
            }
        }, 300);
    }

    showServerNotifications() {
        // Mostrar notificaciones de sesión de Laravel
        @if(session('success'))
            this.show('{{ session("success") }}', 'success');
        @endif

        @if(session('error'))
            this.show('{{ session("error") }}', 'error');
        @endif

        @if(session('warning'))
            this.show('{{ session("warning") }}', 'warning');
        @endif

        @if(session('info'))
            this.show('{{ session("info") }}', 'info');
        @endif

        @if(session('status') === 'profile-updated')
            this.show('Perfil actualizado correctamente', 'success');
        @endif

        @if(session('status') === 'password-updated')
            this.show('Contraseña actualizada correctamente', 'success');
        @endif

        @if(session('status') === 'verification-link-sent')
            this.show('Se ha enviado un nuevo enlace de verificación a tu correo electrónico', 'info');
        @endif
    }

    // Métodos de conveniencia
    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 7000) {
        return this.show(message, 'error', duration);
    }

    warning(message, duration = 6000) {
        return this.show(message, 'warning', duration);
    }

    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    }
}

// Inicializar el sistema de notificaciones
let notificationSystem;
document.addEventListener('DOMContentLoaded', function() {
    notificationSystem = new NotificationSystem();
    
    // Hacer disponible globalmente
    window.notificationSystem = notificationSystem;
});

// Función helper para disparar notificaciones desde cualquier lugar
function showNotification(message, type = 'info', duration = 5000) {
    if (window.notificationSystem) {
        window.notificationSystem.show(message, type, duration);
    } else {
        // Si el sistema no está listo, usar evento personalizado
        window.dispatchEvent(new CustomEvent('show-notification', {
            detail: { message, type, duration }
        }));
    }
}
</script>

<style>
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
    width: 100%;
    pointer-events: none;
}

.notification {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    margin-bottom: 12px;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: auto;
    overflow: hidden;
    position: relative;
    border-left: 4px solid;
}

.notification.show {
    opacity: 1;
    transform: translateX(0);
}

.notification.hide {
    opacity: 0;
    transform: translateX(100%);
    margin-bottom: 0;
    max-height: 0;
}

.notification-success {
    border-left-color: #10b981;
}

.notification-error {
    border-left-color: #ef4444;
}

.notification-warning {
    border-left-color: #f59e0b;
}

.notification-info {
    border-left-color: #3b82f6;
}

.notification-content {
    display: flex;
    align-items: flex-start;
    padding: 16px;
    gap: 12px;
}

.notification-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-top: 2px;
}

.notification-success .notification-icon {
    color: #10b981;
}

.notification-error .notification-icon {
    color: #ef4444;
}

.notification-warning .notification-icon {
    color: #f59e0b;
}

.notification-info .notification-icon {
    color: #3b82f6;
}

.notification-message {
    flex: 1;
    font-size: 14px;
    line-height: 1.5;
    color: #374151;
    font-weight: 500;
}

.notification-close {
    flex-shrink: 0;
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s;
    font-size: 12px;
}

.notification-close:hover {
    background: #f3f4f6;
    color: #6b7280;
}

.notification-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, 
        var(--notification-color, #3b82f6) 0%, 
        var(--notification-color-light, #60a5fa) 100%
    );
    animation: progress 5s linear forwards;
}

.notification-success .notification-progress {
    --notification-color: #10b981;
    --notification-color-light: #34d399;
}

.notification-error .notification-progress {
    --notification-color: #ef4444;
    --notification-color-light: #f87171;
    animation: progress 7s linear forwards;
}

.notification-warning .notification-progress {
    --notification-color: #f59e0b;
    --notification-color-light: #fbbf24;
    animation: progress 6s linear forwards;
}

@keyframes progress {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

/* Responsive */
@media (max-width: 640px) {
    .notification-container {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }
    
    .notification {
        margin-bottom: 8px;
    }
    
    .notification-content {
        padding: 12px;
    }
}

/* Animaciones adicionales */
.notification:hover .notification-progress {
    animation-play-state: paused;
}

.notification:hover {
    transform: translateX(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}
</style>