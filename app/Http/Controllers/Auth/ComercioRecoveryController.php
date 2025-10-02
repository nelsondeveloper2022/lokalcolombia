<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MarketComercioServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComercioRecoveryController extends Controller
{
    /**
     * Buscar comercio por nombre para recuperación
     */
    public function searchComercio(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|min:3'
            ]);

            $nombreBusqueda = $request->input('nombre');
            
            // Buscar comercio por título (nombre)
            $comercio = MarketComercioServicio::where('titulo', 'LIKE', "%{$nombreBusqueda}%")
                ->with(['categoria', 'tipoComercioServicio', 'datosContacto'])
                ->first();

            if (!$comercio) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ningún comercio con ese nombre.'
                ]);
            }

            // Formatear información del comercio
            $comercioData = [
                'id' => $comercio->idMarketComerciosServicios,
                'titulo' => $comercio->titulo,
                'categoria' => $comercio->categoria ? $comercio->categoria->nombre : null,
                'tipo' => $comercio->tipoComercioServicio ? $comercio->tipoComercioServicio->nombre : null,
                'direccion' => $comercio->direccion,
                'fecha_registro' => $comercio->publicadoEn ? $comercio->publicadoEn->format('d/m/Y') : null,
                'telefono' => $comercio->datosContacto ? $comercio->datosContacto->telefono : null,
                'email' => $comercio->datosContacto ? $comercio->datosContacto->email : null,
            ];

            return response()->json([
                'success' => true,
                'comercio' => $comercioData,
                'whatsapp_support' => config('contact.whatsapp_support', '+573001234567')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de comercio: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error interno. Intenta nuevamente.'
            ], 500);
        }
    }
}
