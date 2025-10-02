<?php

namespace App\Console\Commands;

use App\Models\MarketComercioServicio;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateDefaultUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-defaults {--dry-run : Solo mostrar lo que se haría sin crear usuarios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear usuarios por defecto para cada comercio que no tenga usuario asociado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Iniciando proceso de creación de usuarios por defecto...');
        
        // Obtener todos los comercios que no tienen usuario asociado
        $comerciosSinUsuario = MarketComercioServicio::whereDoesntHave('usuario')->get();
        
        if ($comerciosSinUsuario->isEmpty()) {
            $this->info('✅ Todos los comercios ya tienen usuarios asociados.');
            return 0;
        }
        
        $this->info("📊 Encontrados {$comerciosSinUsuario->count()} comercios sin usuario asociado.");
        
        if ($dryRun) {
            $this->warn('🔍 MODO DRY-RUN - Solo mostrando lo que se haría:');
            $this->newLine();
            
            foreach ($comerciosSinUsuario as $comercio) {
                $this->line("- {$comercio->titulo} (ID: {$comercio->idMarketComerciosServicios})");
            }
            
            $this->newLine();
            $this->info('Para crear los usuarios realmente, ejecuta el comando sin --dry-run');
            return 0;
        }
        
        $created = 0;
        $errors = 0;
        
        $progressBar = $this->output->createProgressBar($comerciosSinUsuario->count());
        $progressBar->start();
        
        foreach ($comerciosSinUsuario as $comercio) {
            try {
                $email = $this->generateUniqueEmail($comercio);
                $password = $this->generateDefaultPassword();
                
                $user = User::create([
                    'name' => $comercio->responsable ?: $comercio->titulo,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'market_commerce_service_id' => $comercio->idMarketComerciosServicios,
                    'email_verified_at' => null, // Usuario debe verificar su email
                ]);
                
                $created++;
                
                // Log para referencia administrativa
                $this->newLine();
                $this->info("✅ Usuario creado para: {$comercio->titulo}");
                $this->line("   Email: {$email}");
                $this->line("   Password temporal: {$password}");
                
            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->error("❌ Error creando usuario para {$comercio->titulo}: {$e->getMessage()}");
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        $this->info("🎉 Proceso completado:");
        $this->line("   - Usuarios creados: {$created}");
        $this->line("   - Errores: {$errors}");
        
        if ($created > 0) {
            $this->newLine();
            $this->warn('⚠️  IMPORTANTE:');
            $this->warn('   - Los usuarios creados tienen passwords temporales mostradas arriba');
            $this->warn('   - Deben verificar su email antes de poder editar información');
            $this->warn('   - Se recomienda que cambien su password después del primer login');
        }
        
        return 0;
    }
    
    /**
     * Generar un email único para el comercio
     */
    private function generateUniqueEmail(MarketComercioServicio $comercio): string
    {
        $baseEmail = Str::slug($comercio->titulo) . '@puentelokal.com';
        $email = $baseEmail;
        $counter = 1;
        
        // Asegurar que el email sea único
        while (User::where('email', $email)->exists()) {
            $email = Str::slug($comercio->titulo) . $counter . '@puentelokal.com';
            $counter++;
        }
        
        return $email;
    }
    
    /**
     * Generar una contraseña temporal
     */
    private function generateDefaultPassword(): string
    {
        return 'Temp' . rand(1000, 9999) . '!';
    }
}
