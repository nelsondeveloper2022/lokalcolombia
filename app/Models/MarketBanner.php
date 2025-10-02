<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketBanner extends Model
{
    use HasFactory;

    protected $table = 'tMarketBanners';
    protected $primaryKey = 'idMarketBanner';
    public $timestamps = true;

    protected $fillable = [
        'titulo',
        'rutaImagen',
        'htmlEmbed',
        'tipoBanner',
        'idContenedor',
        'dispositivo',
        'orden',
        'urlRedireccion',
        'estado',
        'fechaInicio',
        'fechaFin'
    ];

    protected $casts = [
        'fechaInicio' => 'date',
        'fechaFin' => 'date',
    ];

    /**
     * Accessor para compatibilidad - activo
     */
    public function getActivoAttribute()
    {
        return $this->estado === 'activo' || $this->estado === 'publicado';
    }

    /**
     * Accessor para compatibilidad - imagen
     */
    public function getImagenAttribute()
    {
        return $this->rutaImagen;
    }

    /**
     * Accessor para compatibilidad - url
     */
    public function getUrlAttribute()
    {
        return $this->urlRedireccion;
    }
}
