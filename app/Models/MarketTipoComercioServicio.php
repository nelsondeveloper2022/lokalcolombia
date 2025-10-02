<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketTipoComercioServicio extends Model
{
    use HasFactory;

    protected $table = 'tMarketTiposComercioServicio';
    protected $primaryKey = 'idMarketTipoComercioServicio';
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
        return $this->hasMany(MarketComercioServicio::class, 'idMarketTipoComercioServicio', 'idMarketTipoComercioServicio');
    }
}
