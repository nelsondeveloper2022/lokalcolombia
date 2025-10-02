<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRegistrationRequest;
use App\Models\User;
use App\Models\MarketComercioServicio;
use App\Models\MarketCategoria;
use App\Models\MarketTipoComercioServicio;
use App\Mail\WelcomeBusinessRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $categorias = MarketCategoria::where('estado', 1)->orderBy('nombre')->get();
        $tiposComercio = MarketTipoComercioServicio::where('estado', 1)->orderBy('nombre')->get();
        
        return view('auth.register', compact('categorias', 'tiposComercio'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(BusinessRegistrationRequest $request): RedirectResponse
    {
        Log::info('Registro iniciado', ['data' => $request->all()]);
        
        try {
            DB::beginTransaction();

            // 1. Crear el comercio/servicio primero
            $comercio = MarketComercioServicio::create([
                'idUsuarioCreacion' => null, // Se actualizará después
                'idMarketCategoria' => $request->categoria,
                'idMarketTipoComercioServicio' => $request->tipo_comercio,
                'titulo' => $request->nombre_comercio,
                'slug' => Str::slug($request->nombre_comercio),
                'descripcionCorta' => $request->descripcion_corta ?? '',
                'responsable' => $request->name,
                'estado' => 1,
                'destacado' => false,
                'publicadoEn' => now(),
                'actualizadoEn' => now(),
            ]);

            // 2. Crear el usuario en la tabla users
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'comerciante',
                'market_commerce_service_id' => $comercio->idMarketComerciosServicios,
            ]);

            // 3. Actualizar el comercio con el ID del usuario creador
            $comercio->update(['idUsuarioCreacion' => $user->id]);

            DB::commit();

            // 4. Eventos y autenticación
            event(new Registered($user));
            Auth::login($user);

            // 5. Enviar email de bienvenida
            try {
                Mail::to($user->email)->send(new WelcomeBusinessRegistration($user, $comercio));
            } catch (\Exception $e) {
                // Log del error, pero no fallar el registro
                Log::error('Error enviando email de bienvenida: ' . $e->getMessage());
            }

            return redirect(route('dashboard'))->with('success', 
                '¡Registro exitoso! Bienvenido a Lokal Colombia. Revisa tu correo para más información.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.']);
        }
    }
}
