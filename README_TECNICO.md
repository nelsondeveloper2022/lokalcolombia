# Puente.Lokal Colombia - Documentación Técnica

## 📋 Descripción del Proyecto

**Puente.Lokal Colombia** es una plataforma web desarrollada en Laravel que conecta comercios locales de Puente Nacional, Santander con clientes de la región y visitantes. La plataforma permite la gestión completa de comercios, servicios, contactos y contenido de forma totalmente gratuita, funcionando como un directorio empresarial con funcionalidades avanzadas de búsqueda, filtrado y contacto directo.

## 🛠️ Stack Tecnológico

### Backend
- **Laravel 12.x** - Framework PHP principal
- **PHP 8.2+** - Lenguaje de programación
- **MySQL/MariaDB** - Base de datos principal
- **SQLite** - Base de datos para desarrollo local

### Frontend
- **Blade Templates** - Motor de plantillas de Laravel
- **Tailwind CSS 3.x** - Framework CSS
- **Alpine.js 3.x** - JavaScript reactivo
- **Vite 7.x** - Bundler de assets

### Herramientas de Desarrollo
- **Laravel Breeze** - Autenticación
- **Laravel Tinker** - REPL para Laravel
- **Laravel Pint** - Code Style Fixer
- **PHPUnit** - Testing framework
- **Faker** - Generación de datos de prueba

### Integraciones
- **Google reCAPTCHA Enterprise** - Protección contra bots
- **WhatsApp Business API** - Comunicación con comercios
- **Cloudflare/AWS** - CDN y almacenamiento de imágenes

## 🏗️ Arquitectura del Proyecto

### Estructura de Carpetas

```
app/
├── Console/Commands/        # Comandos Artisan personalizados
├── Enums/                  # Enumeraciones (estados, tipos)
├── Http/
│   ├── Controllers/        # Controladores principales
│   ├── Middleware/         # Middleware personalizado
│   └── Requests/           # Form Request Validation
├── Mail/                   # Clases de email
├── Models/                 # Modelos Eloquent
├── Notifications/          # Notificaciones
├── Providers/              # Service Providers
├── Rules/                  # Reglas de validación personalizadas
├── Services/               # Lógica de negocio
└── View/Components/        # Componentes Blade

database/
├── factories/              # Model factories
├── migrations/             # Migraciones de BD
└── seeders/               # Seeders

resources/
├── css/                   # Archivos CSS/Tailwind
├── js/                    # JavaScript/Alpine.js
└── views/                 # Plantillas Blade

routes/
├── auth.php               # Rutas de autenticación
├── console.php            # Rutas de consola
└── web.php                # Rutas web principales
```

### Base de Datos - Tablas Principales

#### Comercios y Servicios
- `tMarketComerciosServicios` - Información principal de comercios
- `tMarketComerciosServiciosInformacion` - Información adicional
- `tMarketComerciosServiciosDatosContacto` - Datos de contacto
- `tMarketComercioServicioImagenes` - Imágenes del comercio
- `tMarketComerciosServiciosContactosMultiples` - Contactos múltiples

#### Clasificación
- `tMarketCategorias` - Categorías de comercios
- `tMarketTiposComercioServicio` - Tipos de comercio/servicio

#### Usuarios y Autenticación
- `users` - Usuarios del sistema (Laravel Breeze)
- `tUsuario` - Tabla de usuarios legacy

#### Sistema
- `tMarketFavoritos` - Favoritos de usuarios
- `tMarketComercioServicioComentarios` - Comentarios y calificaciones
- `tMarketComerciosComunicados` - Comunicaciones automáticas

## 🚀 Instalación Local

### Requisitos Previos
- PHP 8.2 o superior
- Composer 2.x
- Node.js 18+ y npm
- MySQL 8.0+ o MariaDB 10.x
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url> puentelokalcolobia
cd puentelokalcolobia
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias JavaScript**
```bash
npm install
```

4. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puentelokal_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate
php artisan db:seed --class=PuenteLokalSeeder
```

7. **Generar datos de ejemplo (opcional)**
```bash
php artisan create:sample-data
```

8. **Compilar assets**
```bash
npm run dev
# o para producción
npm run build
```

9. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

### Configuración Adicional

#### Storage Link
```bash
php artisan storage:link
```

#### Permisos (Linux/Mac)
```bash
chmod -R 755 storage bootstrap/cache
```

## 🌐 Despliegue en Producción

### Servidor Web
- **Nginx** o **Apache** con PHP-FPM
- **SSL Certificate** (Let's Encrypt recomendado)
- **PHP 8.2+** con extensiones: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

### Variables de Entorno de Producción
```env
APP_NAME="Puente.Lokal Colombia"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://puente.lokalcolombia.com

DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=noreply@puente.lokalcolombia.com
MAIL_PASSWORD=your_mail_password
MAIL_FROM_ADDRESS=noreply@puente.lokalcolombia.com

# Google reCAPTCHA Enterprise
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
RECAPTCHA_API_KEY=your_google_cloud_api_key
RECAPTCHA_PROJECT_ID=your_project_id
RECAPTCHA_ENABLED=true

# Almacenamiento
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_aws_key
AWS_SECRET_ACCESS_KEY=your_aws_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=puentelokal-storage
```

### Comandos de Despliegue
```bash
# Optimización de producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Migrar base de datos
php artisan migrate --force

# Limpiar cachés si es necesario
php artisan cache:clear
php artisan config:clear
```

### Backup Automático
```bash
# Configurar cron job para backups diarios
0 2 * * * cd /path/to/project && php artisan backup:run
```

## 🔐 Autenticación y Seguridad

### Sistema de Autenticación
- **Laravel Breeze** - Sistema de autenticación completo
- **Verificación de email** obligatoria para comerciantes
- **Roles de usuario**: `admin`, `comerciante`
- **Middleware de autenticación** personalizado

### Roles y Permisos
```php
// Middleware para admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rutas de administración
});

// Usuarios comerciantes
$user->rol === 'comerciante'
$user->market_commerce_service_id // ID del comercio asociado
```

### Protección CSRF
- Tokens CSRF en todos los formularios
- Validación automática en requests POST

### reCAPTCHA Enterprise
- Protección en formularios de registro, login y recuperación
- Detección automática de ambiente (deshabilitado en local)
- Scores configurables por acción

## 📊 Módulos Principales

### 1. Gestión de Comercios
**Modelos**: `MarketComercioServicio`, `MarketComerciosServiciosInformacion`

**Funcionalidades**:
- CRUD completo de comercios
- Estados: pendiente, aprobado, rechazado, eliminado
- Generación automática de slugs únicos
- Gestión de múltiples imágenes con orden
- Datos de contacto múltiples (teléfonos, emails, redes sociales)

**Service Layer**: `ComercioService`
```php
// Crear comercio
$comercio = $comercioService->createComercio($data, $userId);

// Actualizar comercio
$comercio = $comercioService->updateComercio($comercio, $data);
```

### 2. Sistema de Categorías y Tipos
**Modelos**: `MarketCategoria`, `MarketTipoComercioServicio`

- Clasificación jerárquica de comercios
- Iconos y slugs para SEO
- Estados activo/inactivo

### 3. Gestión de Imágenes
**Modelo**: `MarketComercioServicioImagen`

- Subida múltiple de imágenes
- Orden automático y reordenamiento
- Eliminación en cascada (archivo físico + registro)
- Validación de tipos y tamaños

### 4. Sistema de Contactos
**Modelo**: `MarketComerciosServiciosDatosContacto`

- Contactos múltiples con separador "|"
- Formateo automático de números telefónicos
- Validación de URLs y redes sociales
- Integración con WhatsApp Business

### 5. Comentarios y Calificaciones
**Modelo**: `MarketComercioServicioComentario`

- Sistema de puntuación 1-5 estrellas
- Moderación de comentarios
- Filtros anti-spam por IP

## 🔌 API Endpoints

### Públicos
```php
GET /                          # Página principal
GET /comercios                 # Listado de comercios
GET /comercio/{slug}          # Detalle de comercio
POST /contacto                # Envío de formulario de contacto
```

### Autenticados
```php
GET /dashboard                    # Dashboard usuario
GET /dashboard/comercio          # Gestión de comercio
PUT /dashboard/comercio          # Actualizar comercio
POST /dashboard/resend-verification # Reenviar verificación
```

### Administración
```php
GET /admin                    # Dashboard admin
GET /admin/comercios         # Gestión de comercios
GET /admin/categorias        # Gestión de categorías  
GET /admin/usuarios          # Gestión de usuarios
```

### API de Búsqueda
```php
POST /auth/search-comercio   # Búsqueda para recuperación de acceso
```

## ⚙️ Variables de Entorno y Configuración

### Variables Esenciales
```env
# Aplicación
APP_NAME="Puente.Lokal Colombia"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://puente.lokalcolombia.com

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puentelokal_db
DB_USERNAME=root
DB_PASSWORD=

# Email
MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=noreply@puente.lokalcolombia.com
MAIL_FROM_NAME="Puente.Lokal Colombia"

# reCAPTCHA
RECAPTCHA_ENABLED=true
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
RECAPTCHA_PROJECT_ID=
```

### Configuraciones Especiales
- **Locale**: `es` para español
- **Timezone**: `America/Bogota`
- **Upload limits**: 2MB por imagen
- **Session lifetime**: 120 minutos

## 🛠️ Mantenimiento y Buenas Prácticas

### Logs y Monitoreo
```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Limpiar logs antiguos
php artisan log:clear

# Monitorear errores
php artisan queue:monitor
```

### Actualizaciones
```bash
# Actualizar dependencias
composer update
npm update

# Ejecutar migraciones nuevas
php artisan migrate

# Limpiar cachés
php artisan optimize:clear
```

### Performance
```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Optimizar autoloader
composer dump-autoload --optimize
```

### Escalabilidad
- **Redis** para sessions y cache
- **Queues** para tareas pesadas (emails, imágenes)
- **CDN** para assets estáticos
- **Load Balancer** para múltiples servidores

### Backup Estrategia
```bash
# Backup de base de datos
mysqldump -u user -p database > backup_$(date +%Y%m%d).sql

# Backup de archivos
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public
```

## 🧪 Testing y Validaciones

### Testing Recomendado
```bash
# Tests unitarios
php artisan test --testsuite=Unit

# Tests de feature
php artisan test --testsuite=Feature

# Coverage
php artisan test --coverage
```

### Validaciones Críticas
1. **Registro de comercio**: Validar todos los campos obligatorios
2. **Subida de imágenes**: Verificar tipos y tamaños
3. **Estados de comercio**: Validar transiciones de estado
4. **Datos de contacto**: Validar formatos de teléfono y email
5. **Slugs únicos**: Verificar unicidad en creación/edición

### Casos de Prueba Prioritarios
- [ ] Registro de nuevo comercio con todos los datos
- [ ] Login con usuario verificado/no verificado
- [ ] Búsqueda y filtrado de comercios
- [ ] Subida múltiple de imágenes
- [ ] Edición de datos de contacto
- [ ] Cambio de estados por admin
- [ ] Recuperación de acceso por nombre de comercio
- [ ] Protección reCAPTCHA en formularios

### Comandos de Desarrollo
```bash
# Crear datos de ejemplo
php artisan create:sample-data

# Crear usuarios por defecto para comercios
php artisan users:create-defaults

# Probar configuración reCAPTCHA
php artisan recaptcha:test

# Limpiar datos de prueba
php artisan migrate:fresh --seed
```

---

## 📞 Soporte Técnico

Para dudas técnicas o problemas de implementación, contactar al equipo de desarrollo a través de los canales establecidos en el proyecto.

**Proyecto**: Puente.Lokal Colombia - Plataforma gratuita para comercios de Puente Nacional
**Documentación actualizada**: Septiembre 2025
**Versión Laravel**: 12.x
**Versión PHP**: 8.2+