<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AccountDeletionController extends Controller
{
    /**
     * Mostrar el formulario de confirmación de eliminación de cuenta
     */
    public function show()
    {
        return view('profile.delete-account');
    }

    /**
     * Eliminar la cuenta del usuario actual
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'La contraseña es obligatoria para confirmar la eliminación.',
            'password.current_password' => 'La contraseña ingresada es incorrecta.',
        ]);

        $user = $request->user();
        $userName = $user->name;

        try {
            // Cerrar la sesión del usuario antes de eliminar la cuenta
            Auth::logout();

            // Invalidar la sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Eliminar completamente la cuenta y toda su información relacionada
            $user->deleteAccountCompletely();

            // Redirigir al home con mensaje de confirmación
            return redirect('/')->with('success', "La cuenta de {$userName} ha sido eliminada permanentemente junto con toda su información asociada.");

        } catch (\Exception $e) {
            // Si hay algún error, mostrar mensaje y redirigir de vuelta
            return back()->with('error', 'Ocurrió un error al eliminar la cuenta. Por favor, inténtalo de nuevo.');
        }
    }
}