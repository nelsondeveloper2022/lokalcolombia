<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-verification {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo de verificación de prueba a un usuario específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("Usuario con ID {$userId} no encontrado.");
            return 1;
        }
        
        $this->info("Enviando correo de verificación a: {$user->email}");
        
        try {
            $user->sendEmailVerificationNotification();
            $this->info("✅ Correo de verificación enviado exitosamente!");
            
            if ($user->hasComercio() && $user->comercioServicio) {
                $this->info("📍 Negocio asociado: {$user->comercioServicio->titulo}");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error al enviar el correo: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
