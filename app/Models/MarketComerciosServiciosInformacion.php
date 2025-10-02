<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EstadoComercio;

class MarketComerciosServiciosInformacion extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosServiciosInformacion';
    protected $primaryKey = 'idMarketComerciosServiciosInformacion';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'nombre',
        'whatsapp',
        'email',
        'comentarios',
        'estado'
    ];

    // Sin casts especiales para estado, se mantiene como integer

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con comunicados
     */
    public function comunicados()
    {
        return $this->hasMany(MarketComercioComunicado::class, 'idMarketComerciosServiciosInformacion', 'idMarketComerciosServiciosInformacion');
    }

    /**
     * Accessor para compatibilidad con código anterior
     */
    public function getDireccionAttribute()
    {
        return $this->comercioServicio->direccion ?? null;
    }

    /**
     * Accessor para horarios (usando comentarios como campo general)
     */
    public function getHorariosAttribute()
    {
        // Puedes extraer horarios de comentarios si siguen un patrón específico
        return null;
    }

    /**
     * Accessor para servicios que ofrece
     */
    public function getServiciosOfereceAttribute()
    {
        return $this->comentarios;
    }

    /**
     * Accessor para descripción detallada
     */
    public function getDescripcionDetalladaAttribute()
    {
        return $this->comentarios;
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear, establecer estado por defecto
        static::creating(function ($informacion) {
            if (is_null($informacion->estado)) {
                $informacion->estado = 1; // pendiente
            }
        });
    }

    /**
     * Scopes para filtrar por estado (usando valores numéricos existentes)
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 1); // pendiente
    }

    public function scopeAprobados($query)
    {
        return $query->where('estado', 2); // aprobado
    }

    public function scopeRechazados($query)
    {
        return $query->where('estado', 3); // rechazado
    }

    public function scopeActivos($query)
    {
        return $query->whereIn('estado', [1, 2]); // pendiente y aprobado
    }

    /**
     * Obtener el estado como texto legible
     */
    public function getEstadoTextoAttribute(): string
    {
        return match($this->estado) {
            0 => 'Eliminado',
            1 => 'Pendiente',
            2 => 'Aprobado',
            3 => 'Rechazado',
            default => 'Desconocido'
        };
    }
}
