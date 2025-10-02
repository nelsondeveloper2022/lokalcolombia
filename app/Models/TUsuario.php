<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TUsuario extends Model
{
    use HasFactory;

    protected $table = 'tUsuario';
    protected $primaryKey = 'idUsuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'estado',
        'rol'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relación con comercios/servicios
     */
    public function comerciosServicios()
    {
        return $this->hasMany(MarketComercioServicio::class, 'idUsuarioCreacion', 'idUsuario');
    }
}