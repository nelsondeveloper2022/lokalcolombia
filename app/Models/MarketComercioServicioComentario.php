<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComercioServicioComentario extends Model
{
    use HasFactory;

    protected $table = 'tMarketComercioServicioComentarios';
    protected $primaryKey = 'idMarketComercioServicioComentario';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'nombre',
        'comentario',
        'calificacion',
        'estado',
        'ip'
    ];

    protected $casts = [
        'calificacion' => 'integer',
    ];

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Accessors para compatibilidad
     */
    public function getNombreClienteAttribute()
    {
        return $this->nombre;
    }

    public function getActivoAttribute()
    {
        return $this->estado === 'publico';
    }

    public function getAprobadoAttribute()
    {
        return $this->estado === 'publico' ? 1 : 0;
    }

    public function getFechaComentarioAttribute()
    {
        return $this->created_at;
    }
}
