<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RecaptchaEnterpriseService;
use Illuminate\Support\Facades\Log;

class TestRecaptchaEnterpriseCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'recaptcha:test-enterprise {--token= : Token de prueba}';

    /**
     * The console command description.
     */
    protected $description = 'Prueba la configuración de reCAPTCHA Enterprise';

    /**
     * Execute the console command.
     */
    public function handle(RecaptchaEnterpriseService $recaptchaService): int
    {
        $this->info('🛡️ Testing reCAPTCHA Enterprise Configuration');
        $this->newLine();

        // Mostrar configuración
        $config = $recaptchaService->getConfig();
        $this->info('📋 Configuración:');
        $this->line('   Site Key: ' . ($config['site_key'] ? substr($config['site_key'], 0, 20) . '...' : 'No configurado'));
        $this->line('   Modo desarrollo: ' . ($config['development_mode'] ? 'Sí' : 'No'));
        $this->line('   Score mínimo: ' . $config['min_score']);
        $this->newLine();

        // Verificar variables de entorno
        $this->info('🔧 Variables de entorno:');
        $siteKey = config('app.recaptcha.site_key');
        $secretKey = config('app.recaptcha.secret_key');
        $projectId = config('app.recaptcha.project_id');

        $this->line('   RECAPTCHA_SITE_KEY: ' . ($siteKey ? '✅ Configurado' : '❌ No configurado'));
        $this->line('   RECAPTCHA_SECRET_KEY: ' . ($secretKey ? '✅ Configurado' : '❌ No configurado'));
        $this->line('   RECAPTCHA_PROJECT_ID: ' . ($projectId ? '✅ Configurado' : '❌ No configurado'));
        $this->newLine();

        // Determinar modo
        if ($config['development_mode']) {
            $this->warn('🔧 Modo desarrollo activo');
            $this->line('   - Las verificaciones siempre devuelven éxito con token válido');
            $this->line('   - No se realizan llamadas a la API de Google');
            $this->line('   - Ideal para desarrollo y testing');
            $this->newLine();

            // Test con token mock
            $this->info('🧪 Probando validación en modo desarrollo:');
            $testToken = 'test_token_' . time();
            $result = $recaptchaService->verify($testToken, 'TEST', '127.0.0.1');
            
            $this->line('   Token: ' . $testToken);
            $this->line('   Resultado: ' . ($result['success'] ? '✅ Válido' : '❌ Inválido'));
            $this->line('   Score: ' . $result['score']);
            
        } else {
            $this->info('🌐 Modo producción activo');
            $this->line('   - Se realizan verificaciones reales con Google API');
            $this->line('   - Requiere configuración completa');
            $this->newLine();

            if (!$secretKey || !$projectId) {
                $this->error('❌ Configuración incompleta para modo producción');
                $this->line('   Configura RECAPTCHA_SECRET_KEY y RECAPTCHA_PROJECT_ID');
                return 1;
            }

            // Test con token proporcionado
            $token = $this->option('token');
            if ($token) {
                $this->info('🧪 Probando token proporcionado:');
                $result = $recaptchaService->verify($token, 'TEST', '127.0.0.1');
                
                $this->line('   Token: ' . substr($token, 0, 20) . '...');
                $this->line('   Resultado: ' . ($result['success'] ? '✅ Válido' : '❌ Inválido'));
                $this->line('   Score: ' . ($result['score'] ?? 'N/A'));
                
                if (!$result['success']) {
                    $this->line('   Error: ' . ($result['error'] ?? 'Desconocido'));
                }
            } else {
                $this->warn('💡 Para probar en producción, proporciona un token:');
                $this->line('   php artisan recaptcha:test-enterprise --token=TOKEN_AQUI');
            }
        }

        $this->newLine();
        $this->info('✅ Test completado');
        
        return 0;
    }
}