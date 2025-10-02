<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\MarketComercioServicio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'titulo' => ['required', 'string', 'max:255'],
            'idMarketCategoria' => ['required', 'exists:tMarketCategorias,idMarketCategoria'],
            'idMarketTipoComercioServicio' => ['required', 'exists:tMarketTipoComercioServicio,idMarketTipoComercioServicio'],
            'responsable' => ['nullable', 'string', 'max:255'],
            'descripcionCorta' => ['nullable', 'string', 'max:500'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email_comercio' => ['nullable', 'email', 'max:255'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
        ];
    }



    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'titulo.required' => 'El nombre del comercio es obligatorio.',
            'idMarketCategoria.required' => 'La categoría es obligatoria.',
            'idMarketCategoria.exists' => 'La categoría seleccionada no es válida.',
            'idMarketTipoComercioServicio.required' => 'El tipo de comercio es obligatorio.',
            'idMarketTipoComercioServicio.exists' => 'El tipo de comercio seleccionado no es válido.',
            'email_comercio.email' => 'El email del comercio debe ser válido.',
            'sitio_web.url' => 'El sitio web debe ser una URL válida.',
        ];
    }
}
