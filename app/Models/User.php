<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\MarketComercioComunicado;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'market_commerce_service_id',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con comercio/servicio
     */
    public function comercioServicio()
    {
        return $this->belongsTo(MarketComercioServicio::class, 'market_commerce_service_id', 'idMarketComerciosServicios');
    }
    
    /**
     * Verificar si el usuario tiene un comercio asociado
     */
    public function hasComercio(): bool
    {
        return !is_null($this->market_commerce_service_id);
    }
    
    /**
     * Obtener información del comercio asociado
     */
    public function getComercioInfo()
    {
        if (!$this->hasComercio()) {
            return null;
        }
        
        return $this->comercioServicio;
    }
    
    /**
     * Validar si un comercio ya tiene usuario asociado
     */
    public static function comercioHasUser($comercioId): bool
    {
        return self::where('market_commerce_service_id', $comercioId)->exists();
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole(string $role): bool
    {
        return $this->rol === $role;
    }
    
    /**
     * Verificar si el email del usuario ha sido verificado
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
    
    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }

    /**
     * Eliminar completamente la cuenta del usuario y toda su información relacionada
     */
    public function deleteAccountCompletely()
    {
        DB::transaction(function () {
            // Si el usuario tiene un comercio asociado, eliminar toda su información
            if ($this->hasComercio()) {
                $comercio = $this->comercioServicio;
                
                if ($comercio) {
                    // Eliminar relaciones directas del comercio
                    $comercio->contactos()->delete();
                    $comercio->imagenes()->delete();
                    $comercio->comentarios()->delete();
                    $comercio->favoritos()->delete();
                    
                    // Eliminar información adicional y sus comunicados
                    if ($comercio->informacion) {
                        // Eliminar comunicados relacionados a través de información
                        MarketComercioComunicado::where('idMarketComerciosServiciosInformacion', 
                            $comercio->informacion->idMarketComerciosServiciosInformacion)->delete();
                        $comercio->informacion->delete();
                    }
                    
                    if ($comercio->datosContacto) {
                        $comercio->datosContacto->delete();
                    }
                    
                    // Eliminar el comercio principal
                    $comercio->delete();
                }
            }
            
            // Finalmente, eliminar el usuario
            $this->delete();
        });
        
        return true;
    }
}
