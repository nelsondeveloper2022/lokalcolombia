# 🛡️ Implementación de Google reCAPTCHA Enterprise v3

Sistema de protección invisible con reCAPTCHA Enterprise para formularios de autenticación en Laravel.
Implementación completamente invisible para el usuario que se ejecuta automáticamente al enviar formularios.

## 📋 **Características Implementadas**

### ✅ **Componente JavaScript**
- Carga asíncrona del script de Google
- Manejo robusto de errores
- Interceptación automática de formularios
- Generación de token antes del envío
- Indicadores visuales durante la verificación
- Logs detallados en consola para depuración
- Soporte para múltiples acciones (LOGIN, REGISTER, etc.)

### ✅ **Servicio de validación**
- Modo desarrollo que funciona sin API key
- Validación de score mínimo configurable
- Verificación de acción esperada
- Manejo de errores de red
- Logs detallados para depuración

### ✅ **Integración**
- Compatible con Laravel Breeze
- Compatible con formularios existentes
- Sin cambios visuales para el usuario
- Validación automática en backend

## 🔧 **Configuración**

### **Variables de Entorno (.env)**
```env
# Google reCAPTCHA Enterprise
RECAPTCHA_SITE_KEY=6Lc35dYrAAAAAHVfikuRDx9GotSluXDYxNNHnyrN
RECAPTCHA_SECRET_KEY=your_secret_key_here
RECAPTCHA_PROJECT_ID=your_project_id_here
RECAPTCHA_LOCATION=global
RECAPTCHA_MIN_SCORE=0.5
```

### **Configuración en app.php**
```php
'recaptcha' => [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    'project_id' => env('RECAPTCHA_PROJECT_ID'),
    'location' => env('RECAPTCHA_LOCATION', 'global'),
    'min_score' => env('RECAPTCHA_MIN_SCORE', 0.5),
],
```

## 🔄 **Comportamiento del Sistema**

### **🔧 Modo Desarrollo**
- **Se activa cuando**: `APP_ENV=local` o credenciales vacías
- **Comportamiento**: Siempre válido con token válido
- **Ventajas**: Desarrollo sin interrupciones
- **Logs**: Detallados para depuración

### **🌐 Modo Producción**
- **Se activa cuando**: Credenciales completas configuradas
- **Comportamiento**: Verificación real con Google API
- **Validaciones**: Score mínimo, acción esperada
- **Monitoreo**: Logs completos y métricas

## 📁 **Estructura de Archivos**

```
app/
├── Services/
│   └── RecaptchaEnterpriseService.php     # Servicio principal
├── Http/
│   └── Requests/
│       ├── Auth/
│       │   └── LoginRequest.php           # Validación login
│       └── BusinessRegistrationRequest.php # Validación registro
└── Console/
    └── Commands/
        └── TestRecaptchaEnterpriseCommand.php # Comando de prueba

resources/views/
└── components/
    └── recaptcha-enterprise.blade.php     # Componente frontend

config/
└── app.php                               # Configuración reCAPTCHA
```

## 🎯 **Uso en Formularios**

### **Incluir en Blade**
```blade
<!-- En login.blade.php -->
<x-recaptcha-enterprise action="LOGIN" />

<!-- En register.blade.php -->
<x-recaptcha-enterprise action="REGISTER" />
```

### **Campo Oculto Automático**
```html
<input type="hidden" name="recaptcha_token" id="recaptcha-token" />
```

## 🧪 **Testing y Validación**

### **Comando de Prueba**
```bash
php artisan recaptcha:test-enterprise
```

### **Test con Token**
```bash
php artisan recaptcha:test-enterprise --token=YOUR_TOKEN_HERE
```

### **Logs de Depuración**
```javascript
// En consola del navegador
🛡️ reCAPTCHA Enterprise: Iniciando configuración
✅ reCAPTCHA Enterprise: Sistema listo
🔄 reCAPTCHA Enterprise: Ejecutando para acción: LOGIN
✅ reCAPTCHA Enterprise: Token generado exitosamente
📤 reCAPTCHA Enterprise: Procesando envío de formulario
```

## 🔍 **Funcionamiento Interno**

### **Flujo de Usuario**
1. **Usuario interactúa** → Script se carga automáticamente
2. **Usuario hace clic en enviar** → Se intercepta el evento
3. **Se ejecuta reCAPTCHA** → Genera token invisible
4. **Se envía formulario** → Con token incluido
5. **Backend valida** → Token contra API de Google
6. **Proceso continúa** → Si la validación es exitosa

### **Detección de Formularios**
```javascript
// Busca formularios con el campo token
const forms = document.querySelectorAll('form:has(input[name="recaptcha_token"])');
```

### **Validación Backend**
```php
// En Request classes
'recaptcha_token' => ['required', 'string', $recaptchaService->validationRule('ACTION')],
```

## 🛠️ **Integración Manual**

### **En JavaScript**
```javascript
// Ejecutar reCAPTCHA manualmente
executeRecaptcha('CUSTOM_ACTION', function(token, error) {
    if (token) {
        console.log('Token:', token);
        // Usar token...
    } else {
        console.error('Error:', error);
    }
});
```

### **En PHP**
```php
use App\Services\RecaptchaEnterpriseService;

$recaptchaService = app(RecaptchaEnterpriseService::class);
$result = $recaptchaService->verify($token, 'CUSTOM_ACTION', request()->ip());

if ($result['success']) {
    // Continuar proceso...
} else {
    // Manejar error...
}
```

## 🎛️ **Personalización**

### **Ajustar Score Mínimo**
```env
RECAPTCHA_MIN_SCORE=0.7  # Más estricto
RECAPTCHA_MIN_SCORE=0.3  # Más permisivo  
```

### **Nuevas Acciones**
```blade
<x-recaptcha-enterprise action="CONTACT_FORM" />
```

```php
'recaptcha_token' => ['required', 'string', $recaptchaService->validationRule('CONTACT_FORM')],
```

## ✅ **Estado de Implementación**

- ✅ **Configuración completa**
- ✅ **Servicio de verificación implementado**
- ✅ **Validación en requests implementada**
- ✅ **Frontend integrado en formularios**
- ✅ **Manejo de errores robusto**
- ✅ **Comando de pruebas disponible**
- ✅ **Modo desarrollo funcional**
- ✅ **Documentación completa**

## 🎯 **Próximos Pasos**

### **Para Desarrollo**
- ✅ **Sistema listo** - funciona en modo desarrollo
- ✅ **Testing disponible** - comando de prueba implementado

### **Para Producción**
1. **Configurar API Key real** en variables de entorno
2. **Configurar PROJECT_ID** de Google Cloud
3. **Verificar dominio** en configuración de reCAPTCHA
4. **Monitorear scores** y ajustar umbral si necesario
5. **Revisar logs** regularmente para detectar patrones

---

### **🛡️ Sistema completamente protegido con Google reCAPTCHA Enterprise v3!**