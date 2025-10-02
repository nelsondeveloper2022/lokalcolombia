<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Enums\EstadoComercio;

class MarketComercioServicio extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosServicios';
    protected $primaryKey = 'idMarketComerciosServicios';
    public $timestamps = true;

    protected $fillable = [
        'idUsuarioCreacion',
        'idMarketCategoria',
        'idMarketTipoComercioServicio',
        'rutaPortada',
        'titulo',
        'responsable',
        'slug',
        'descripcionCorta',
        'direccion',
        'contenidoHtml',
        'metaTitulo',
        'metaDescripcion',
        'estado',
        'contactoDirecto',
        'destacado',
        'publicadoEn',
        'actualizadoEn'
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'publicadoEn' => 'datetime',
        'actualizadoEn' => 'datetime',
    ];

    /**
     * Relación con categoría
     */
    public function categoria()
    {
        return $this->belongsTo(MarketCategoria::class, 'idMarketCategoria', 'idMarketCategoria');
    }

    /**
     * Relación con tipo de comercio/servicio
     */
    public function tipoComercioServicio()
    {
        return $this->belongsTo(MarketTipoComercioServicio::class, 'idMarketTipoComercioServicio', 'idMarketTipoComercioServicio');
    }

    /**
     * Relación con información adicional
     */
    public function informacion()
    {
        return $this->hasOne(MarketComerciosServiciosInformacion::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con datos de contacto
     */
    public function datosContacto()
    {
        return $this->hasOne(MarketComerciosServiciosDatosContacto::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con contactos múltiples
     */
    public function contactosMultiples()
    {
        return $this->hasMany(MarketComercioServicioContactoMultiple::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Obtener contactos múltiples de un tipo específico
     */
    public function contactosDelTipo(string $tipo)
    {
        return $this->contactosMultiples()->delTipo($tipo)->activos()->ordenadosPorOrden();
    }

    /**
     * Relación con contactos (mensajes de visitantes)
     */
    public function contactos()
    {
        return $this->hasMany(MarketComercioServicioContacto::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con contactos dinámicos (datos de contacto del comercio)
     */
    public function contactosDinamicos()
    {
        return $this->hasMany(MarketComercioContactoDinamico::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con imágenes
     */
    public function imagenes()
    {
        return $this->hasMany(MarketComercioServicioImagen::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios')
            ->ordenadosPorOrden();
    }

    /**
     * Relación con comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(MarketComercioServicioComentario::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con favoritos
     */
    public function favoritos()
    {
        return $this->hasMany(MarketFavorito::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Relación con comunicados a través de información
     */
    public function comunicados()
    {
        return $this->hasManyThrough(
            MarketComercioComunicado::class,
            MarketComerciosServiciosInformacion::class,
            'idMarketComerciosServicios', // Foreign key en información
            'idMarketComerciosServiciosInformacion', // Foreign key en comunicados
            'idMarketComerciosServicios', // Local key en comercio
            'idMarketComerciosServiciosInformacion' // Local key en información
        );
    }

    /**
     * Accessor para obtener la descripción (título en la BD)
     */
    public function getDescripcionAttribute()
    {
        return $this->descripcionCorta;
    }

    /**
     * Accessor para obtener el nombre (título en la BD)
     */
    public function getNombreAttribute()
    {
        return $this->titulo;
    }

    /**
     * Relación con el usuario propietario
     */
    public function usuario()
    {
        return $this->hasOne(User::class, 'market_commerce_service_id', 'idMarketComerciosServicios');
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

    public function scopeEliminados($query)
    {
        return $query->where('estado', 0); // eliminado
    }

    public function scopeActivos($query)
    {
        return $query->whereIn('estado', [1, 2]); // pendiente y aprobado
    }

    /**
     * Validar si el slug es único
     */
    public static function isSlugUnique($slug, $excludeId = null): bool
    {
        $query = self::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('idMarketComerciosServicios', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    /**
     * Generar un slug único
     */
    public static function generateUniqueSlug($titulo, $excludeId = null): string
    {
        $baseSlug = Str::slug($titulo);
        $slug = $baseSlug;
        $counter = 1;
        
        while (!self::isSlugUnique($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Verificar si el comercio está activo (aprobado o pendiente)
     */
    public function isActive(): bool
    {
        return in_array($this->estado, [1, 2]); // pendiente o aprobado
    }

    /**
     * Verificar si el comercio está aprobado
     */
    public function isApproved(): bool
    {
        return $this->estado == 2; // aprobado
    }

    /**
     * Verificar si el comercio está pendiente
     */
    public function isPending(): bool
    {
        return $this->estado == 1; // pendiente
    }

    /**
     * Verificar si el comercio está rechazado
     */
    public function isRejected(): bool
    {
        return $this->estado == 3; // rechazado
    }

    /**
     * Verificar si el comercio está eliminado
     */
    public function isDeleted(): bool
    {
        return $this->estado == 0; // eliminado
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

    /**
     * Obtener el color del estado para UI
     */
    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            0 => 'secondary',
            1 => 'warning',
            2 => 'success',
            3 => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear, establecer valores por defecto
        static::creating(function ($comercio) {
            if (is_null($comercio->estado)) {
                $comercio->estado = 1; // pendiente
            }
            
            if (empty($comercio->slug) && !empty($comercio->titulo)) {
                $comercio->slug = self::generateUniqueSlug($comercio->titulo);
            }
            
            $comercio->publicadoEn = now();
            $comercio->actualizadoEn = now();
        });

        // Al actualizar, actualizar timestamp
        static::updating(function ($comercio) {
            $comercio->actualizadoEn = now();
        });
    }
}
