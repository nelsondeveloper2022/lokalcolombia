<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketComercioServicioContacto extends Model
{
    use HasFactory;

    protected $table = 'tMarketComercioServicioContactos';
    protected $primaryKey = 'idMarketComercioServicioContacto';
    public $timestamps = true;

    protected $fillable = [
        'idMarketComerciosServicios',
        'tipoContacto',
        'nombreVisitor',
        'emailVisitor',
        'telefonoVisitor',
        'mensaje',
        'ip',
        'enviadoAlComercio'
    ];

    protected $casts = [
        'enviadoAlComercio' => 'boolean',
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
    public function getNombreAttribute()
    {
        return $this->nombreVisitor;
    }

    public function getEmailAttribute()
    {
        return $this->emailVisitor;
    }

    public function getTelefonoAttribute()
    {
        return $this->telefonoVisitor;
    }
}
