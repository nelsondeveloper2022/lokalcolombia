<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MarketComercioServicio;

class TestAccountDeletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:account-deletion {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba la eliminación completa de una cuenta de usuario y su comercio asociado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        // Buscar el usuario
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("Usuario con ID {$userId} no encontrado.");
            return 1;
        }

        $this->info("Usuario encontrado: {$user->name} ({$user->email})");
        
        // Verificar si tiene comercio
        if ($user->hasComercio()) {
            $comercio = $user->comercioServicio;
            $this->info("Comercio asociado: {$comercio->titulo} (ID: {$comercio->idMarketComerciosServicios})");
            
            // Mostrar estadísticas antes de la eliminación
            $this->showComercioStats($comercio);
        } else {
            $this->info("El usuario no tiene comercio asociado.");
        }

        // Confirmación
        if (!$this->confirm('¿Estás seguro de que deseas eliminar esta cuenta y TODA su información relacionada?')) {
            $this->info('Operación cancelada.');
            return 0;
        }

        // Realizar la eliminación
        try {
            $user->deleteAccountCompletely();
            $this->info('✅ Cuenta eliminada exitosamente.');
            
            // Verificar que la eliminación fue completa
            $this->verifyDeletion($userId, $user->market_commerce_service_id ?? null);
            
        } catch (\Exception $e) {
            $this->error("❌ Error al eliminar la cuenta: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Mostrar estadísticas del comercio antes de eliminar
     */
    private function showComercioStats($comercio)
    {
        $stats = [
            'Contactos' => $comercio->contactos()->count(),
            'Imágenes' => $comercio->imagenes()->count(),
            'Comentarios' => $comercio->comentarios()->count(),
            'Favoritos' => $comercio->favoritos()->count(),
            'Comunicados' => $comercio->comunicados()->count(),
            'Información adicional' => $comercio->informacion ? 1 : 0,
            'Datos de contacto' => $comercio->datosContacto ? 1 : 0,
        ];

        $this->info("Información que será eliminada:");
        foreach ($stats as $tipo => $cantidad) {
            $this->line("  - {$tipo}: {$cantidad}");
        }
    }

    /**
     * Verificar que la eliminación fue completa
     */
    private function verifyDeletion($userId, $comercioId)
    {
        $this->info("Verificando eliminación completa...");
        
        // Verificar usuario
        $userExists = User::find($userId);
        if ($userExists) {
            $this->error("❌ El usuario aún existe en la base de datos.");
        } else {
            $this->info("✅ Usuario eliminado correctamente.");
        }
        
        // Verificar comercio si existía
        if ($comercioId) {
            $comercioExists = MarketComercioServicio::find($comercioId);
            if ($comercioExists) {
                $this->error("❌ El comercio aún existe en la base de datos.");
            } else {
                $this->info("✅ Comercio eliminado correctamente.");
            }
        }
        
        $this->info("Verificación completada.");
    }
}
