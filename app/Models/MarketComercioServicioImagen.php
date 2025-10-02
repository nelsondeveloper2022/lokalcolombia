<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MarketComercioServicioImagen extends Model
{
    use HasFactory;

    protected $table = 'tMarketComercioServicioImagenes';
    protected $primaryKey = 'idMarketComercioServicioImagen';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'rutaImagen',
        'orden'
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Accessor para URL de imagen
     */
    public function getUrlAttribute()
    {
        return $this->rutaImagen;
    }

    /**
     * Accessor para URL completa de imagen
     */
    public function getUrlCompletaAttribute()
    {
        return asset('storage/' . $this->rutaImagen);
    }

    /**
     * Scope para ordenar por orden
     */
    public function scopeOrdenadosPorOrden($query)
    {
        return $query->orderBy('orden');
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear, asignar siguiente orden si no se especifica
        static::creating(function ($imagen) {
            if (empty($imagen->orden)) {
                $maxOrden = self::where('idMarketComerciosServicios', $imagen->idMarketComerciosServicios)
                    ->max('orden');
                $imagen->orden = ($maxOrden ?? 0) + 1;
            }
        });

        // Al eliminar, eliminar archivo físico
        static::deleting(function ($imagen) {
            if ($imagen->rutaImagen && Storage::disk('public')->exists($imagen->rutaImagen)) {
                Storage::disk('public')->delete($imagen->rutaImagen);
            }
        });
    }

    /**
     * Reordenar imágenes después de eliminaciones
     */
    public static function reorderForCommerce(int $comercioId): void
    {
        $imagenes = self::where('idMarketComerciosServicios', $comercioId)
            ->orderBy('orden')
            ->get();
        
        $orden = 1;
        foreach ($imagenes as $imagen) {
            $imagen->update(['orden' => $orden]);
            $orden++;
        }
    }
}
