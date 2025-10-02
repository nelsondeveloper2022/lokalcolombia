<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\MarketComercioServicio;
use App\Models\MarketCategoria;
use App\Models\MarketTipoComercioServicio;
use App\Models\MarketComerciosServiciosInformacion;
use App\Models\MarketComerciosServiciosDatosContacto;
use App\Models\MarketComercioServicioImagen;
use App\Models\MarketComercioContactoDinamico;
use App\Mail\WelcomeBusinessRegistration;
use App\Services\ComercioService;

class DashboardController extends Controller
{
    protected $comercioService;

    public function __construct(ComercioService $comercioService)
    {
        $this->comercioService = $comercioService;
    }

    /**
     * Mostrar el dashboard principal.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtener el comercio asociado al usuario
        $comercio = null;
        if ($user->market_commerce_service_id) {
            $comercio = MarketComercioServicio::with([
                'categoria', 
                'tipoComercioServicio',
                'datosContacto',
                'informacion',
                'imagenes'
            ])->find($user->market_commerce_service_id);
        }
        
        // Calcular porcentaje de completitud del perfil
        $completitud = $this->comercioService->calculateProfileCompleteness($user, $comercio);
        
        // Estadísticas generales (solo para administradores)
        $estadisticas = [];
        if ($user->hasRole('admin')) {
            $estadisticas = [
                'total_comercios' => MarketComercioServicio::where('estado', 1)->count(),
                'total_categorias' => MarketCategoria::where('estado', 1)->count(),
                'comercios_verificados' => MarketComercioServicio::where('estado', 1)->where('verificado', true)->count(),
            ];
        }

        return view('dashboard.index', compact('user', 'comercio', 'completitud', 'estadisticas'));
    }
    
    /**
     * Mostrar la página de información del comercio.
     */
    public function comercio()
    {
        $user = Auth::user();
        
        // Verificar que el email esté confirmado (desactivado temporalmente para desarrollo)
        // if (!$user->hasVerifiedEmail()) {
        //     return redirect()->route('dashboard')->with('warning', 
        //         'Debes verificar tu correo electrónico antes de editar la información de tu comercio.');
        // }
        
        // Obtener el comercio asociado al usuario
        $comercio = null;
        if ($user->market_commerce_service_id) {
            $comercio = MarketComercioServicio::with([
                'categoria', 
                'tipoComercioServicio',
                'datosContacto',
                'informacion',
                'imagenes'
            ])->find($user->market_commerce_service_id);
        }
        
        // Calcular porcentaje de completitud del perfil
        $completitud = $this->comercioService->calculateProfileCompleteness($user, $comercio);
        
        // Obtener análisis detallado de completitud
        $completitudAnalisis = $this->comercioService->getProfileCompletenessAnalysis($user, $comercio);
        
        // Obtener categorías y tipos para los selects
        $categorias = MarketCategoria::where('estado', 1)->orderBy('nombre')->get();
        $tiposComercio = MarketTipoComercioServicio::where('estado', 1)->orderBy('nombre')->get();
        
        // Obtener opciones de estado
        $estadosOptions = ComercioService::getEstadosOptions();
        
        return view('dashboard.comercio', compact('user', 'comercio', 'categorias', 'tiposComercio', 'completitud', 'completitudAnalisis', 'estadosOptions'));
    }
    
    /**
     * Actualizar la información del comercio.
     */
    public function updateComercio(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Obtener el comercio actual para validación de slug único
        $comercio = MarketComercioServicio::find($user->market_commerce_service_id);
        
        // Validar los datos básicos del comercio (todos opcionales para permitir guardado gradual)
        $validated = $request->validate([
            // Datos básicos del comercio
            'titulo' => 'nullable|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('tMarketComerciosServicios', 'slug')->ignore($comercio ? $comercio->idMarketComerciosServicios : null, 'idMarketComerciosServicios')
            ],
            'responsable' => 'nullable|string|max:255',
            'descripcionCorta' => 'nullable|string|max:500',
            'contenidoHtml' => 'nullable|string|max:5000',
            'direccion' => 'nullable|string|max:500',
            'idMarketCategoria' => 'nullable|exists:tMarketCategorias,idMarketCategoria',
            'idMarketTipoComercioServicio' => 'nullable|exists:tMarketTiposComercioServicio,idMarketTipoComercioServicio',
            'metaTitulo' => 'nullable|string|max:255',
            'metaDescripcion' => 'nullable|string|max:500',
            'estado' => 'nullable|integer|in:0,1,2,3',
            
            // Información interna para contacto con Lokal Colombia
            'info_nombre' => 'nullable|string|max:255',
            'info_whatsapp' => 'nullable|string|max:20|regex:/^\+?[0-9\s\-\(\)]+$/',
            'info_email' => 'nullable|email|max:255',
            'info_comentarios' => 'nullable|string|max:1000',
            'info_estado' => 'nullable|integer|in:0,1,2,3',
            
            // Datos de contacto públicos
            'contactos_tipo' => 'nullable|array',
            'contactos_tipo.*' => 'nullable|string|in:telefono,whatsapp,correo,sitioWeb,facebook,instagram,tiktok,twitter,linkedin,youtube,telegram,pinterest,snapchat',
            'contactos_valor' => 'nullable|array',
            'contactos_valor.*' => 'nullable|string|max:255',
            
            // Imágenes
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagenes_galeria' => 'nullable|array',
            'imagenes_galeria.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'imagenes_eliminar' => 'nullable|array',
            'imagenes_eliminar.*' => 'integer|exists:tMarketComercioServicioImagenes,idMarketComercioServicioImagen',
            'imagenes_orden' => 'nullable|array',
            'imagenes_orden.*' => 'integer|min:1',
        ], [
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'slug.unique' => 'Este slug ya está en uso. Elija uno diferente.',
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones.',
            'responsable.max' => 'El nombre del responsable no puede tener más de 255 caracteres.',
            'descripcionCorta.max' => 'La descripción corta no puede tener más de 500 caracteres.',
            'contenidoHtml.max' => 'El contenido HTML no puede tener más de 5000 caracteres.',
            'direccion.max' => 'La dirección no puede tener más de 500 caracteres.',
            'idMarketCategoria.exists' => 'La categoría seleccionada no es válida.',
            'idMarketTipoComercioServicio.exists' => 'El tipo de comercio seleccionado no es válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'info_whatsapp.regex' => 'El formato del WhatsApp no es válido.',
            'info_email.email' => 'El formato del email no es válido.',
            'contactos_tipo.*.in' => 'Tipo de contacto no válido.',
            'contactos_valor.*' => 'El valor del contacto no es válido.',
            'imagen_portada.image' => 'El archivo de portada debe ser una imagen.',
            'imagen_portada.mimes' => 'La imagen de portada debe ser de tipo: jpeg, png, jpg, gif, webp.',
            'imagen_portada.max' => 'La imagen de portada no puede ser mayor a 2MB.',
            'imagenes_galeria.*.image' => 'Los archivos de galería deben ser imágenes.',
            'imagenes_galeria.*.mimes' => 'Las imágenes de galería deben ser de tipo: jpeg, png, jpg, gif, webp.',
            'imagenes_galeria.*.max' => 'Las imágenes de galería no pueden ser mayores a 2MB.',
        ]);
        
        try {
            if (!$comercio) {
                return redirect()->route('dashboard.comercio')->with('error', 
                    'No se encontró la información del comercio.');
            }
            
            // Preparar datos para el service
            $comercioData = $validated;
            
            // Procesar contactos dinámicos
            if ($request->has('contactos_tipo') && $request->has('contactos_valor')) {
                $tipos = $request->contactos_tipo;
                $valores = $request->contactos_valor;
                $contactos = [];
                
                for ($i = 0; $i < count($tipos); $i++) {
                    if (!empty($tipos[$i]) && !empty($valores[$i])) {
                        $contactos[] = [
                            'tipo' => $tipos[$i],
                            'valor' => $valores[$i]
                        ];
                    }
                }
                
                if (!empty($contactos)) {
                    $comercioData['contactos'] = $contactos;
                }
            }
            
            // Manejar archivos de imagen
            if ($request->hasFile('imagen_portada')) {
                $comercioData['imagenes']['portada'] = $request->file('imagen_portada');
            }
            
            if ($request->hasFile('imagenes_galeria')) {
                $comercioData['imagenes']['galeria'] = $request->file('imagenes_galeria');
            }
            
            if ($request->has('imagenes_eliminar')) {
                $comercioData['imagenes']['eliminar'] = $request->imagenes_eliminar;
            }
            
            if ($request->has('imagenes_orden')) {
                $comercioData['imagenes']['orden'] = $request->imagenes_orden;
            }
            
            // Actualizar comercio usando el service
            $comercioActualizado = $this->comercioService->updateComercio($comercio, $comercioData);
            
            // Verificar completitud y aprobar automáticamente si es >= 80%
            $completitud = $this->comercioService->calculateProfileCompleteness($user, $comercioActualizado);
            $mensaje = 'Información del comercio actualizada correctamente.';
            
            if ($completitud >= 80 && $comercioActualizado->estado == 'pendiente') {
                $comercioActualizado->update(['estado' => 'aprobado']); // Cambiar a aprobado
                $mensaje .= ' ¡Tu comercio ha sido aprobado automáticamente por tener más del 80% de completitud!';
            }
            
            return redirect()->route('dashboard.comercio')->with('success', $mensaje);
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard.comercio')->with('error', 
                'Ocurrió un error al actualizar la información. Inténtalo de nuevo.');
        }
    }
    
    /**
     * Reenviar email de verificación.
     */
    public function resendVerification(): RedirectResponse
    {
        $user = Auth::user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Tu correo ya está verificado.');
        }
        
        try {
            $user->sendEmailVerificationNotification();
            
            return redirect()->route('dashboard')->with('success', 
                'Se ha enviado un nuevo correo de verificación a tu dirección de email.');
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 
                'No se pudo enviar el correo de verificación. Inténtalo más tarde.');
        }
    }
    

    
    /**
     * Crear un nuevo comercio para el usuario
     */
    public function createComercio(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Verificar que el usuario no tenga ya un comercio
        if ($user->market_commerce_service_id) {
            return redirect()->route('dashboard.comercio')->with('error', 
                'Ya tienes un comercio registrado.');
        }
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'idMarketCategoria' => 'required|exists:tMarketCategorias,idMarketCategoria',
            'idMarketTipoComercioServicio' => 'required|exists:tMarketTiposComercioServicio,idMarketTipoComercioServicio',
            'responsable' => 'nullable|string|max:255',
            'descripcionCorta' => 'nullable|string|max:500',
            'direccion' => 'nullable|string|max:500',
        ], [
            'titulo.required' => 'El título del comercio es obligatorio.',
            'idMarketCategoria.required' => 'Debe seleccionar una categoría.',
            'idMarketCategoria.exists' => 'La categoría seleccionada no es válida.',
            'idMarketTipoComercioServicio.required' => 'Debe seleccionar un tipo de comercio.',
            'idMarketTipoComercioServicio.exists' => 'El tipo de comercio seleccionado no es válido.',
        ]);
        
        try {
            // Agregar información básica del usuario
            $validated['info_nombre'] = $user->name;
            $validated['info_email'] = $user->email;
            
            // Crear comercio usando el service
            $comercio = $this->comercioService->createComercio($validated, $user->id);
            
            // Asociar el comercio al usuario
            $user->update(['market_commerce_service_id' => $comercio->idMarketComerciosServicios]);
            
            return redirect()->route('dashboard.comercio')->with('success', 
                'Comercio creado exitosamente. Ahora puedes completar la información.');
                
        } catch (\Exception $e) {
            Log::error('Error al crear comercio: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'data' => $validated
            ]);
            return redirect()->route('dashboard.comercio')->with('error', 
                'Error al crear el comercio. Inténtalo de nuevo.');
        }
    }
}
