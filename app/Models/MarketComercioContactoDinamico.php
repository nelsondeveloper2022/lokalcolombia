<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComercioContactoDinamico extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosServiciosDatosContacto';
    protected $primaryKey = 'idMarketComerciosServiciosDatosContacto';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'tipo',
        'valor',
        'estado'
    ];

    protected $casts = [
        'estado' => 'integer',
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
    public static function getTiposContacto()
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
            'snapchat' => 'Snapchat'
        ];
    }

    /**
     * Obtener icono por tipo de contacto
     */
    public function getIconoAttribute()
    {
        $iconos = [
            'telefono' => 'fas fa-phone',
            'whatsapp' => 'fab fa-whatsapp',
            'correo' => 'fas fa-envelope',
            'sitioWeb' => 'fas fa-globe',
            'facebook' => 'fab fa-facebook',
            'instagram' => 'fab fa-instagram',
            'tiktok' => 'fab fa-tiktok',
            'twitter' => 'fab fa-twitter',
            'linkedin' => 'fab fa-linkedin',
            'youtube' => 'fab fa-youtube',
            'telegram' => 'fab fa-telegram',
            'pinterest' => 'fab fa-pinterest',
            'snapchat' => 'fab fa-snapchat'
        ];

        return $iconos[$this->tipo] ?? 'fas fa-link';
    }

    /**
     * Validar duplicados para el mismo comercio
     */
    public static function esContactoDuplicado($idComercio, $tipo, $valor, $excludeId = null)
    {
        $query = self::where('idMarketComerciosServicios', $idComercio)
                    ->where('tipo', $tipo)
                    ->where('valor', $valor);
        
        if ($excludeId) {
            $query->where('idMarketComerciosServiciosDatosContacto', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}