<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComerciosServiciosDatosContacto extends Model
{
    use HasFactory;

    protected $table = 'tMarketComerciosServiciosDatosContacto';
    protected $primaryKey = 'idMarketComerciosServiciosDatosContacto';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'direccion',
        'telefono',
        'whatsapp',
        'correo',
        'sitioWeb',
        'facebook',
        'instagram',
        'tiktok',
        'twitter',
        'linkedin',
        'youtube',
        'telegram',
        'pinterest',
        'snapchat'
    ];

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'idMarketComerciosServicios', 'idMarketComerciosServicios');
    }

    /**
     * Accessor para email (campo correo en BD)
     */
    public function getEmailAttribute()
    {
        return $this->correo;
    }

    /**
     * Manejar múltiples valores usando separadores
     * Para campos que pueden tener múltiples valores como teléfonos, WhatsApp, etc.
     */
    
    /**
     * Obtener todos los teléfonos como array
     */
    public function getTelefonosArrayAttribute(): array
    {
        if (empty($this->telefono)) {
            return [];
        }
        return array_filter(explode('|', $this->telefono));
    }

    /**
     * Obtener todos los WhatsApp como array
     */
    public function getWhatsappsArrayAttribute(): array
    {
        if (empty($this->whatsapp)) {
            return [];
        }
        return array_filter(explode('|', $this->whatsapp));
    }

    /**
     * Obtener todos los correos como array
     */
    public function getCorreosArrayAttribute(): array
    {
        if (empty($this->correo)) {
            return [];
        }
        return array_filter(explode('|', $this->correo));
    }

    /**
     * Establecer múltiples teléfonos
     */
    public function setTelefonosArray(array $telefonos): void
    {
        $this->telefono = implode('|', array_filter($telefonos));
    }

    /**
     * Establecer múltiples WhatsApp
     */
    public function setWhatsappsArray(array $whatsapps): void
    {
        $this->whatsapp = implode('|', array_filter($whatsapps));
    }

    /**
     * Establecer múltiples correos
     */
    public function setCorreosArray(array $correos): void
    {
        $this->correo = implode('|', array_filter($correos));
    }

    /**
     * Formatear número de teléfono
     */
    public static function formatPhoneNumber($phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        
        // Remover espacios y caracteres especiales excepto + y números
        $phone = preg_replace('/[^\+0-9]/', '', $phone);
        
        // Si no tiene código de país, agregar +57 (Colombia)
        if (!str_starts_with($phone, '+')) {
            $phone = '+57' . $phone;
        }
        
        return $phone;
    }

    /**
     * Formatear valor de contacto según su tipo
     */
    public static function formatContactValue($tipo, $valor): string
    {
        switch ($tipo) {
            case 'telefono':
            case 'whatsapp':
                return self::formatPhoneNumber($valor) ?? $valor;
                
            case 'correo':
                return strtolower(trim($valor));
                
            case 'sitioWeb':
                // Agregar https:// si no tiene protocolo
                if (!preg_match('/^https?:\/\//', $valor)) {
                    $valor = 'https://' . $valor;
                }
                return $valor;
                
            case 'facebook':
                // Convertir URL completa a username si es necesario
                if (str_contains($valor, 'facebook.com/')) {
                    $valor = basename(parse_url($valor, PHP_URL_PATH));
                }
                return $valor;
                
            case 'instagram':
                // Limpiar @ inicial y convertir URL a username
                if (str_contains($valor, 'instagram.com/')) {
                    $valor = basename(parse_url($valor, PHP_URL_PATH));
                }
                return ltrim($valor, '@');
                
            case 'twitter':
                // Limpiar @ inicial y convertir URL a username
                if (str_contains($valor, 'twitter.com/') || str_contains($valor, 'x.com/')) {
                    $valor = basename(parse_url($valor, PHP_URL_PATH));
                }
                return ltrim($valor, '@');
                
            case 'tiktok':
                // Convertir URL a username
                if (str_contains($valor, 'tiktok.com/')) {
                    $valor = basename(parse_url($valor, PHP_URL_PATH));
                }
                return ltrim($valor, '@');
                
            default:
                return trim($valor);
        }
    }
}
