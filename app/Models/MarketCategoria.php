<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketCategoria extends Model
{
    use HasFactory;

    protected $table = 'tMarketCategorias';
    protected $primaryKey = 'idMarketCategoria';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'slug',
        'icono',
        'estado'
    ];

    /**
     * Relación con comercios/servicios
     */
    public function comerciosServicios()
    {
        return $this->hasMany(MarketComercioServicio::class, 'idMarketCategoria', 'idMarketCategoria');
    }
}
