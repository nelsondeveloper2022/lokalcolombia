<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\RecaptchaEnterpriseService;

class BusinessRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Datos del usuario
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            
            // Datos del comercio/servicio
            'categoria' => ['required', 'exists:tMarketCategorias,idMarketCategoria'],
            'tipo_comercio' => ['required', 'exists:tMarketTiposComercioServicio,idMarketTipoComercioServicio'],
            'nombre_comercio' => ['required', 'string', 'max:255'],
            'descripcion_corta' => ['nullable', 'string', 'max:500'],
            
            // Validación de reCAPTCHA
            'recaptcha_token' => ['required', 'string', function ($attribute, $value, $fail) {
                $recaptchaService = app(\App\Services\RecaptchaEnterpriseService::class);
                $userIp = request()->ip();
                $result = $recaptchaService->verify($value, 'REGISTER', $userIp);
                
                if (!$result['success']) {
                    $error = $result['error'] ?? 'Verificación de reCAPTCHA fallida';
                    $fail("Error de seguridad: {$error}");
                }
            }],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password_confirmation.required' => 'Debes confirmar tu contraseña.',
            'categoria.required' => 'Debes seleccionar una categoría.',
            'categoria.exists' => 'La categoría seleccionada no es válida.',
            'tipo_comercio.required' => 'Debes seleccionar un tipo de comercio/servicio.',
            'tipo_comercio.exists' => 'El tipo de comercio/servicio seleccionado no es válido.',
            'nombre_comercio.required' => 'El nombre del comercio es obligatorio.',
            'nombre_comercio.max' => 'El nombre del comercio no puede exceder 255 caracteres.',
            'descripcion_corta.max' => 'La descripción no puede exceder 500 caracteres.',
            'recaptcha_token.required' => 'La verificación de seguridad es requerida.',
            'recaptcha_token.string' => 'El token de seguridad no es válido.',
        ];
    }
}
