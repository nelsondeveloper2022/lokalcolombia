<?php

namespace App\Rules;

use App\Models\MarketComercioServicio;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueComercioRule implements ValidationRule
{
    protected $categoria;
    protected $tipoComercio;

    public function __construct($categoria, $tipoComercio)
    {
        $this->categoria = $categoria;
        $this->tipoComercio = $tipoComercio;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->categoria && $this->tipoComercio) {
            $existingComercio = MarketComercioServicio::where('titulo', $value)
                ->where('idMarketCategoria', $this->categoria)
                ->where('idMarketTipoComercioServicio', $this->tipoComercio)
                ->first();

            if ($existingComercio && $existingComercio->usuario) {
                $fail('Ya existe un comercio registrado con este nombre, categoría y tipo que tiene un usuario asociado. Si es tu negocio, utiliza la opción "Recuperar acceso a mi comercio".');
            }
        }
    }
}
