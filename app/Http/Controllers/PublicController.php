<?php

namespace App\Http\Controllers;

use App\Models\MarketComercioServicio;
use App\Models\MarketCategoria;
use App\Models\MarketBanner;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Página de inicio
     */
    public function index()
    {
        // Obtener comercios destacados (últimos 10)
        $comerciosDestacados = MarketComercioServicio::with(['categoria', 'informacion', 'datosContacto', 'imagenes'])
            ->where('estado', 'aprobado')
            ->latest('idMarketComerciosServicios')
            ->take(10)
            ->get();

        // Obtener banners activos
        $banners = MarketBanner::whereIn('estado', ['activo', 'publicado'])
            ->orderBy('orden', 'asc')
            ->orderBy('idMarketBanner', 'desc')
            ->take(5)
            ->get();

        return view('index', compact('comerciosDestacados', 'banners'));
    }

    /**
     * Página de comercios y servicios
     */
    public function comercios(Request $request)
    {
        $query = MarketComercioServicio::with(['categoria', 'informacion', 'datosContacto', 'imagenes'])
            ->where('estado', 'aprobado')
            ->orderBy('idMarketComerciosServicios', 'desc');

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('idMarketCategoria', $request->categoria);
        }

        // Filtro por búsqueda de texto
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcionCorta', 'like', "%{$buscar}%")
                  ->orWhere('responsable', 'like', "%{$buscar}%");
            });
        }

        // Filtro por ubicación
        if ($request->filled('ubicacion')) {
            $ubicacion = $request->ubicacion;
            $query->where(function($q) use ($ubicacion) {
                $q->where('direccion', 'like', "%{$ubicacion}%")
                  ->orWhereHas('datosContacto', function($subQ) use ($ubicacion) {
                      $subQ->where('direccion', 'like', "%{$ubicacion}%");
                  });
            });
        }

        $comercios = $query->paginate(12);
        $categorias = MarketCategoria::where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        // Si es una petición AJAX para scroll infinito, retornar solo el HTML de las tarjetas
        if ($request->ajax()) {
            $html = '';
            foreach ($comercios as $comercio) {
                $html .= view('partials.comercio-card', compact('comercio'))->render();
            }
            
            return response()->json([
                'html' => $html,
                'hasMore' => $comercios->hasMorePages(),
                'nextPage' => $comercios->currentPage() + 1
            ]);
        }

        return view('comercios', compact('comercios', 'categorias'));
    }

    /**
     * Detalle de un comercio específico
     */
    public function comercioDetalle($slug)
    {
        $comercio = MarketComercioServicio::with([
            'categoria', 
            'tipoComercioServicio',
            'informacion', 
            'datosContacto', 
            'imagenes', 
            'contactos',
            'comentarios.usuario'
        ])
        ->where('slug', $slug)
        ->where('estado', 2) // Estado aprobado
        ->firstOrFail();

        return view('comercio-detalle', compact('comercio'));
    }

    /**
     * Página Quiénes Somos
     */
    public function quienesSomos()
    {
        // Obtener estadísticas para la página
        $totalComercios = MarketComercioServicio::where('estado', 'aprobado')->count();
        $totalCategorias = MarketCategoria::where('estado', 'activo')->count();
        $comerciosDestacados = MarketComercioServicio::where('estado', 'aprobado')
            ->where('destacado', true)
            ->count();

        $stats = [
            'comercios' => $totalComercios,
            'categorias' => $totalCategorias,
            'destacados' => $comerciosDestacados,
            'ano_inicio' => 2025
        ];

        return view('quienes-somos', compact('stats'));
    }

    /**
     * Página de Contacto
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
     * Procesar formulario de contacto
     */
    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10'
        ]);

        // Aquí puedes procesar el envío del formulario
        // Por ejemplo, enviar un email o guardarlo en base de datos

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente. Te contactaremos pronto.');
    }
}