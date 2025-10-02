<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketFavorito extends Model
{
    use HasFactory;

    protected $table = 'tMarketFavoritos';
    protected $primaryKey = 'idMarketFavorito';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'ip',
        'cookieToken'
    ];

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }
}
