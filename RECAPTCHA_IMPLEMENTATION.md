# 🔐 Implementación de Google reCAPTCHA Enterprise

## 📋 **Resumen de Implementación**

Se ha implementado Google reCAPTCHA Enterprise v3 en los formularios de **registro**, **login** y **recuperación de comercios** siguiendo la documentación oficial de Google.

## 🛠️ **Componentes Implementados**

### **1. Configuración**
- **Archivo**: `config/recaptcha.php`
- **Variables de entorno**: `.env.recaptcha.example`
- **Configuración centralizada** para site key, API key, project ID y scores

### **2. Servicio de reCAPTCHA**
- **Archivo**: `app/Services/RecaptchaService.php`
- **Funcionalidades**:
  - Verificación de tokens con Google Cloud API
  - Validación de scores y acciones
  - Manejo de errores y logging
  - Generación de script tags

### **3. Middleware de Validación**
- **Archivo**: `app/Http/Middleware/RecaptchaMiddleware.php`
- **Aplicación automática** en rutas POST
- **Validación por acción** (LOGIN, REGISTER, RECOVERY)
- **Respuestas JSON y redirect** según tipo de request

### **4. Componente Blade**
- **Archivo**: `resources/views/components/recaptcha.blade.php`
- **JavaScript integrado** para manejo automático
- **Función `executeRecaptcha()`** para uso manual
- **Auto-configuración** de formularios con `data-recaptcha`

### **5. Comando de Pruebas**
- **Archivo**: `app/Console/Commands/TestRecaptchaCommand.php`
- **Comando**: `php artisan recaptcha:test`
- **Verificación de configuración** y pruebas de tokens

## 🔧 **Configuración Requerida**

### **🏠 Ambiente Local (Desarrollo)**
**No requiere configuración** - reCAPTCHA se deshabilita automáticamente en ambiente local.

### **Variables de Entorno (.env) para Producción**
```env
# Google reCAPTCHA Enterprise
RECAPTCHA_SITE_KEY=6Lc35dYrAAAAAHVfikuRDx9GotSluXDYxNNHnyrN
RECAPTCHA_SECRET_KEY=your_secret_key_here
RECAPTCHA_API_KEY=your_google_cloud_api_key_here
RECAPTCHA_PROJECT_ID=beaming-force-472600
RECAPTCHA_MIN_SCORE=0.5
RECAPTCHA_ENABLED=true
```

### **🔍 Detección Automática de Ambiente**
- **Local**: reCAPTCHA deshabilitado automáticamente
- **Producción**: reCAPTCHA habilitado automáticamente  
- **Dominios locales detectados**: localhost, 127.0.0.1, *.local, *.test

### **Obtener API Key de Google Cloud**
1. Ir a [Google Cloud Console](https://console.cloud.google.com/)
2. Seleccionar el proyecto `beaming-force-472600`
3. Navegar a **APIs & Services** > **Credentials**
4. Crear una nueva **API Key**
5. Restringir la API key a **reCAPTCHA Enterprise API**

## 🚀 **Formularios Protegidos**

### **1. Formulario de Login**
```html
<form method="POST" action="{{ route('login') }}" data-recaptcha="LOGIN">
    @csrf
    <!-- campos del formulario -->
    <x-recaptcha action="LOGIN" />
</form>
```

### **2. Formulario de Registro**
```html
<form method="POST" action="{{ route('register') }}" data-recaptcha="REGISTER">
    @csrf
    <!-- campos del formulario -->
    <x-recaptcha action="REGISTER" />
</form>
```

### **3. Formulario de Recuperación**
```html
<form id="recovery-search-form" data-recaptcha="RECOVERY">
    @csrf
    <!-- campos del formulario -->
</form>
```

## 🛡️ **Rutas Protegidas**

```php
// Login con reCAPTCHA
Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('recaptcha:LOGIN');

// Registro con reCAPTCHA
Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('recaptcha:REGISTER');

// Búsqueda de comercios con reCAPTCHA
Route::post('/auth/search-comercio', [ComercioRecoveryController::class, 'searchComercio'])
    ->middleware('recaptcha:RECOVERY');
```

## ⚙️ **Funcionamiento Técnico**

### **Frontend (JavaScript)**
1. **Carga automática** del script de Google reCAPTCHA
2. **Ejecución automática** al enviar formularios con `data-recaptcha`
3. **Token generado** y agregado como campo oculto
4. **Envío del formulario** con token incluido

### **Backend (PHP)**
1. **Middleware intercepta** requests POST
2. **Extrae el token** del request
3. **Llama a Google Cloud API** para verificación
4. **Valida score y acción**
5. **Continúa o rechaza** según resultado

### **API de Google Cloud**
```json
{
  "event": {
    "token": "TOKEN_FROM_FRONTEND",
    "expectedAction": "LOGIN|REGISTER|RECOVERY",
    "siteKey": "6Lc35dYrAAAAAHVfikuRDx9GotSluXDYxNNHnyrN",
    "userIpAddress": "user_ip"
  }
}
```

## 📊 **Scores y Acciones**

### **Interpretación de Scores**
- **0.9 - 1.0**: Muy probablemente humano
- **0.7 - 0.8**: Probablemente humano
- **0.5 - 0.6**: Dudoso (configurado como mínimo)
- **0.0 - 0.4**: Muy probablemente bot

### **Acciones Configuradas**
- `LOGIN`: Para formulario de inicio de sesión
- `REGISTER`: Para formulario de registro
- `RECOVERY`: Para búsqueda de comercios

## 🧪 **Testing y Validación**

### **Comando de Prueba**
```bash
php artisan recaptcha:test
```

**Salida esperada en ambiente local:**
```
✅ Configuración de reCAPTCHA
Ambiente: local
Habilitado: No
🔓 reCAPTCHA está deshabilitado automáticamente en ambiente local.
   Esto es normal para desarrollo. En producción se habilitará automáticamente.
```

### **Validación por Ambiente**

#### **🏠 Desarrollo Local**
- ✅ Formularios funcionan sin reCAPTCHA
- ✅ No se requieren tokens
- ✅ Middleware permite acceso directo

#### **🌐 Producción**
- ✅ Widget aparece en formularios
- ✅ Validación de tokens activa
- ✅ Scores monitoreados en Google Cloud Console

## 🔍 **Validación Manual**

### **En JavaScript**
```javascript
// Ejecutar reCAPTCHA manualmente
executeRecaptcha('LOGIN', function(token, error) {
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
use App\Services\RecaptchaService;

$recaptchaService = app(RecaptchaService::class);
$result = $recaptchaService->verify($token, 'LOGIN', $userIp);

if ($result['success']) {
    // Token válido
} else {
    // Token inválido
}
```

## 🚨 **Manejo de Errores**

### **Frontend**
- **Alert automático** si falla la verificación
- **Prevención de envío** si no hay token
- **Reintento automático** en caso de error

### **Backend**
- **Logs detallados** de errores de API
- **Respuestas apropiadas** JSON/redirect
- **Fallback seguro** si API no responde

## 📱 **Experiencia de Usuario**

### **Invisible para Usuarios Legítimos**
- No requiere interacción del usuario
- Verificación automática en background
- Proceso transparente

### **Protección Efectiva**
- Previene ataques de bots
- Detección de tráfico malicioso
- Análisis de comportamiento avanzado

## 🔄 **Mantenimiento**

### **Monitoreo**
- Dashboard de Google reCAPTCHA Enterprise
- Métricas de scores y detecciones
- Análisis de tráfico

### **Ajustes**
- Modificar `RECAPTCHA_MIN_SCORE` según necesidades
- Ajustar acciones para nuevos formularios
- Actualizar configuración según estadísticas

## ✅ **Estado de Implementación**

- ✅ **Configuración completa**
- ✅ **Servicio de verificación implementado**
- ✅ **Middleware aplicado a rutas críticas**
- ✅ **Frontend integrado en formularios**
- ✅ **Manejo de errores robusto**
- ✅ **Comando de pruebas disponible**
- ✅ **Detección automática de ambiente**
- ✅ **Optimización para desarrollo local**
- ✅ **Documentación completa**

## 🎯 **Próximos Pasos**

### **🏠 Para Desarrollo Local**
- ✅ **Sistema listo** - reCAPTCHA automáticamente deshabilitado
- ✅ **Formularios funcionando** sin restricciones de seguridad
- ✅ **Desarrollo fluido** sin interrupciones

### **🌐 Para Producción**
1. **Configurar API Key real** en variables de entorno
2. **Verificar APP_ENV=production** en servidor
3. **Monitorear scores** y ajustar umbral si necesario
4. **Revisar logs** regularmente para detectar patrones
5. **Expandir protección** a otros formularios si requerido

---

### **🛡️ Sistema completamente protegido con Google reCAPTCHA Enterprise!**