@props(['action' => 'FORM_SUBMIT'])
@php
$recaptchaService = app(\App\Services\RecaptchaEnterpriseService::class);
$config = $recaptchaService->getConfig();
@endphp

{{-- Campo oculto para el token --}}
<input type="hidden" name="recaptcha_token" id="recaptcha-token" />

{{-- Script de reCAPTCHA Enterprise --}}
<script>
// Configuración global de reCAPTCHA
window.recaptchaConfig = {
    siteKey: '{{ $config['site_key'] }}',
    action: '{{ $action }}',
    developmentMode: {{ $config['development_mode'] ? 'true' : 'false' }},
    minScore: {{ $config['min_score'] }}
};

console.log('🛡️ reCAPTCHA Enterprise: Iniciando configuración', window.recaptchaConfig);

// Estado de carga del script
window.recaptchaLoaded = false;
window.recaptchaReady = false;

// Cola de funciones pendientes
window.recaptchaPendingCallbacks = [];

// Función para ejecutar cuando reCAPTCHA esté listo
function onRecaptchaReady() {
    console.log('✅ reCAPTCHA Enterprise: Sistema listo');
    window.recaptchaReady = true;
    
    // Ejecutar callbacks pendientes
    while (window.recaptchaPendingCallbacks.length > 0) {
        const callback = window.recaptchaPendingCallbacks.shift();
        if (typeof callback === 'function') {
            callback();
        }
    }
}

// Función para ejecutar reCAPTCHA
function executeRecaptcha(action, callback) {
    console.log('🔄 reCAPTCHA Enterprise: Ejecutando para acción:', action);
    
    // Modo desarrollo
    if (window.recaptchaConfig.developmentMode) {
        console.log('🔧 reCAPTCHA Enterprise: Modo desarrollo - generando token mock');
        const mockToken = 'dev_token_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        callback(mockToken, null);
        return;
    }
    
    // Verificar si reCAPTCHA está disponible
    if (typeof grecaptcha === 'undefined' || !grecaptcha.enterprise) {
        console.error('❌ reCAPTCHA Enterprise: No está disponible');
        callback(null, 'reCAPTCHA no disponible');
        return;
    }
    
    if (!window.recaptchaReady) {
        console.log('⏳ reCAPTCHA Enterprise: Esperando inicialización...');
        window.recaptchaPendingCallbacks.push(() => executeRecaptcha(action, callback));
        return;
    }
    
    try {
        grecaptcha.enterprise.execute(window.recaptchaConfig.siteKey, {action: action})
            .then(function(token) {
                console.log('✅ reCAPTCHA Enterprise: Token generado exitosamente', {
                    action: action,
                    tokenLength: token.length,
                    tokenPreview: token.substring(0, 20) + '...'
                });
                callback(token, null);
            })
            .catch(function(error) {
                console.error('❌ reCAPTCHA Enterprise: Error al generar token', error);
                callback(null, error.message || 'Error al generar token de reCAPTCHA');
            });
    } catch (error) {
        console.error('❌ reCAPTCHA Enterprise: Excepción al ejecutar', error);
        callback(null, error.message || 'Error inesperado en reCAPTCHA');
    }
}

// Función para interceptar envío de formularios
function interceptFormSubmission() {
    console.log('🎯 reCAPTCHA Enterprise: Configurando interceptación de formularios');
    
    // Encontrar todos los formularios que contengan el token input
    const forms = document.querySelectorAll('form:has(input[name="recaptcha_token"])');
    
    forms.forEach(function(form) {
        console.log('📋 reCAPTCHA Enterprise: Configurando formulario', form);
        
        // Remover listeners existentes
        form.removeEventListener('submit', handleFormSubmit);
        
        // Agregar nuevo listener
        form.addEventListener('submit', handleFormSubmit);
    });
}

// Manejador de envío de formulario
function handleFormSubmit(event) {
    event.preventDefault();
    
    const form = event.target;
    const tokenInput = form.querySelector('input[name="recaptcha_token"]');
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    
    console.log('📤 reCAPTCHA Enterprise: Procesando envío de formulario');
    
    // Mostrar indicador de carga
    if (submitButton) {
        submitButton.disabled = true;
        const originalText = submitButton.textContent || submitButton.value;
        submitButton.textContent = 'Verificando...';
        submitButton.dataset.originalText = originalText;
    }
    
    // Ejecutar reCAPTCHA
    executeRecaptcha(window.recaptchaConfig.action, function(token, error) {
        if (token) {
            console.log('✅ reCAPTCHA Enterprise: Token obtenido, enviando formulario');
            tokenInput.value = token;
            
            // Restaurar botón y enviar formulario
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = submitButton.dataset.originalText;
            }
            
            // Enviar formulario
            form.submit();
        } else {
            console.error('❌ reCAPTCHA Enterprise: Error al obtener token', error);
            
            // Restaurar botón
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = submitButton.dataset.originalText;
            }
            
            // Mostrar error al usuario
            alert('Error de seguridad: ' + (error || 'No se pudo verificar la seguridad. Intenta nuevamente.'));
        }
    });
}

// Cargar script de reCAPTCHA de forma asíncrona
function loadRecaptchaScript() {
    if (window.recaptchaLoaded) {
        console.log('♻️ reCAPTCHA Enterprise: Script ya está cargado');
        return;
    }
    
    console.log('⬇️ reCAPTCHA Enterprise: Cargando script de Google');
    window.recaptchaLoaded = true;
    
    const script = document.createElement('script');
    script.src = 'https://www.google.com/recaptcha/enterprise.js?render=' + window.recaptchaConfig.siteKey;
    script.async = true;
    script.defer = true;
    
    script.onload = function() {
        console.log('📦 reCAPTCHA Enterprise: Script cargado correctamente');
        
        // Esperar a que grecaptcha esté disponible
        function waitForGrecaptcha() {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise) {
                console.log('🚀 reCAPTCHA Enterprise: API disponible');
                
                grecaptcha.enterprise.ready(function() {
                    onRecaptchaReady();
                });
            } else {
                console.log('⏳ reCAPTCHA Enterprise: Esperando API...');
                setTimeout(waitForGrecaptcha, 100);
            }
        }
        
        waitForGrecaptcha();
    };
    
    script.onerror = function() {
        console.error('❌ reCAPTCHA Enterprise: Error al cargar script');
        window.recaptchaLoaded = false;
    };
    
    document.head.appendChild(script);
}

// Inicialización cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎬 reCAPTCHA Enterprise: DOM listo, iniciando');
        loadRecaptchaScript();
        interceptFormSubmission();
    });
} else {
    console.log('🎬 reCAPTCHA Enterprise: Iniciando inmediatamente');
    loadRecaptchaScript();
    interceptFormSubmission();
}

// Función global para uso manual
window.executeRecaptcha = executeRecaptcha;
</script>