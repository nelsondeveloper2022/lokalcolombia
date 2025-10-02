<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketComercioServicio;
use App\Models\MarketCategoria;
use App\Models\User;
use App\Models\MarketTipoComercioServicio;

class AdminController extends Controller
{
    /**
     * Mostrar panel de administración
     */
    public function index()
    {
        $estadisticas = [
            'total_comercios' => MarketComercioServicio::count(),
            'total_categorias' => MarketCategoria::count(),
            'total_usuarios' => User::count(),
            'total_tipos' => MarketTipoComercioServicio::count(),
            'comercios_activos' => MarketComercioServicio::count(), // Simplificado
            'comercios_inactivos' => 0, // Simplificado
        ];

        $comercios_recientes = MarketComercioServicio::with('categoria')
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('estadisticas', 'comercios_recientes'));
    }

    /**
     * Mostrar lista de comercios
     */
    public function comercios(Request $request)
    {
        $query = MarketComercioServicio::with(['categoria', 'tipoComercioServicio']);

        // Filtro por estado
        if ($request->filled('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        $comercios = $query->orderBy('actualizadoEn', 'desc')
            ->orderBy('idMarketComerciosServicios', 'desc')
            ->paginate(15)
            ->appends($request->query());

        // Estadísticas
        $estadisticas = [
            'total' => MarketComercioServicio::count(),
            'pendientes' => MarketComercioServicio::where('estado', 1)->count(),
            'aprobados' => MarketComercioServicio::where('estado', 2)->count(),
            'rechazados' => MarketComercioServicio::where('estado', 3)->count(),
            'eliminados' => MarketComercioServicio::where('estado', 0)->count(),
        ];

        return view('admin.comercios.index', compact('comercios', 'estadisticas'));
    }

    /**
     * Mostrar lista de categorías
     */
    public function categorias()
    {
        $categorias = MarketCategoria::withCount('comerciosServicios')->paginate(15);

        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Mostrar lista de usuarios
     */
    public function usuarios()
    {
        $usuarios = User::with('comercioServicio')->paginate(15);

        return view('admin.usuarios.index', compact('usuarios'));
    }
}
