<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComercioComunicado extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosComunicados';
    protected $primaryKey = 'idComunicado';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServiciosInformacion',
        'tipoComunicado',
        'estadoComunicado',
        'mensajeEnviado',
        'respuestaRecibida',
        'numeroWhatsapp',
        'sessionIdBot',
        'intentosEnvio',
        'fechaEnvio',
        'fechaEntrega',
        'fechaLectura',
        'fechaRespuesta',
        'fechaProximoContacto',
        'notas',
        'esAutomatico'
    ];

    protected $casts = [
        'fechaEnvio' => 'datetime',
        'fechaEntrega' => 'datetime',
        'fechaLectura' => 'datetime',
        'fechaRespuesta' => 'datetime',
        'fechaProximoContacto' => 'datetime',
        'esAutomatico' => 'boolean',
        'intentosEnvio' => 'integer',
    ];

    /**
     * Relación con información del comercio
     */
    public function informacionComercio()
    {
        return $this->belongsTo(MarketComerciosServiciosInformacion::class, 'idMarketComerciosServiciosInformacion', 'idMarketComerciosServiciosInformacion');
    }

    /**
     * Relación con comercio a través de información
     */
    public function comercioServicio()
    {
        return $this->hasOneThrough(
            MarketComercioServicio::class,
            MarketComerciosServiciosInformacion::class,
            'idMarketComerciosServiciosInformacion',
            'idMarketComerciosServicios',
            'idMarketComerciosServiciosInformacion',
            'idMarketComerciosServicios'
        );
    }
}
