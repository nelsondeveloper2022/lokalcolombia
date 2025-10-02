<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComercioServicioContactoMultiple extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosServiciosContactosMultiples';
    protected $primaryKey = 'idContactoMultiple';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'tipo',
        'valor',
        'orden',
        'activo'
    ];

    protected $casts = [
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Tipos de contacto permitidos
     */
    public static function getTiposContacto(): array
    {
        return [
            'telefono' => 'Teléfono',
            'whatsapp' => 'WhatsApp',
            'correo' => 'Correo electrónico',
            'sitioWeb' => 'Sitio web',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'twitter' => 'Twitter (X)',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'telegram' => 'Telegram',
            'pinterest' => 'Pinterest',
            'snapchat' => 'Snapchat',
        ];
    }

    /**
     * Tipos que permiten múltiples valores
     */
    public static function getTiposMultiples(): array
    {
        return ['telefono', 'whatsapp', 'correo'];
    }

    /**
     * Validar si un tipo permite múltiples valores
     */
    public static function permiteMultiples(string $tipo): bool
    {
        return in_array($tipo, self::getTiposMultiples());
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeDelTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para solo contactos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
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

        // Al crear, establecer valores por defecto
        static::creating(function ($contacto) {
            if (is_null($contacto->activo)) {
                $contacto->activo = true;
            }
            
            // Asignar siguiente orden si no se especifica
            if (empty($contacto->orden)) {
                $maxOrden = self::where('idMarketComerciosServicios', $contacto->idMarketComerciosServicios)
                    ->where('tipo', $contacto->tipo)
                    ->max('orden');
                $contacto->orden = ($maxOrden ?? 0) + 1;
            }
        });
    }

    /**
     * Formatear valor según el tipo de contacto
     */
    public function getValorFormateadoAttribute(): string
    {
        return match($this->tipo) {
            'telefono', 'whatsapp' => $this->formatPhoneNumber($this->valor),
            'correo' => strtolower(trim($this->valor)),
            'sitioWeb' => $this->addHttpsIfNeeded($this->valor),
            'facebook' => $this->extractUsername($this->valor, 'facebook.com'),
            'instagram' => ltrim($this->extractUsername($this->valor, 'instagram.com'), '@'),
            'twitter' => ltrim($this->extractUsername($this->valor, ['twitter.com', 'x.com']), '@'),
            'tiktok' => ltrim($this->extractUsername($this->valor, 'tiktok.com'), '@'),
            default => trim($this->valor)
        };
    }

    /**
     * Formatear número de teléfono
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remover espacios y caracteres especiales excepto + y números
        $phone = preg_replace('/[^\+0-9]/', '', $phone);
        
        // Si no tiene código de país, agregar +57 (Colombia)
        if (!str_starts_with($phone, '+')) {
            $phone = '+57' . $phone;
        }
        
        return $phone;
    }

    /**
     * Agregar https:// si es necesario
     */
    private function addHttpsIfNeeded(string $url): string
    {
        if (!preg_match('/^https?:\/\//', $url)) {
            return 'https://' . $url;
        }
        return $url;
    }

    /**
     * Extraer username de URL de red social
     */
    private function extractUsername(string $value, array|string $domains): string
    {
        $domains = is_array($domains) ? $domains : [$domains];
        
        foreach ($domains as $domain) {
            if (str_contains($value, $domain)) {
                return basename(parse_url($value, PHP_URL_PATH));
            }
        }
        
        return $value;
    }
}