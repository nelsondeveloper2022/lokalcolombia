<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecaptchaEnterpriseService
{
    private string $siteKey;
    private string $secretKey;
    private string $projectId;
    private string $location;
    private float $minScore;
    private bool $isDevelopment;

    public function __construct()
    {
        $this->siteKey = config('app.recaptcha.site_key', '');
        $this->secretKey = config('app.recaptcha.secret_key', '');
        $this->projectId = config('app.recaptcha.project_id', '');
        $this->location = config('app.recaptcha.location', 'global');
        $this->minScore = config('app.recaptcha.min_score', 0.5);
        $this->isDevelopment = app()->environment('local', 'testing') || empty($this->secretKey) || empty($this->projectId);
    }

    /**
     * Valida un token de reCAPTCHA Enterprise
     */
    public function verify(string $token, string $expectedAction, string $userIp = null): array
    {
        // Modo desarrollo: siempre válido con token válido
        if ($this->isDevelopment) {
            Log::info('reCAPTCHA: Modo desarrollo activo', [
                'token' => substr($token, 0, 20) . '...',
                'action' => $expectedAction,
                'ip' => $userIp
            ]);

            return [
                'success' => !empty($token),
                'score' => 0.9,
                'action' => $expectedAction,
                'valid' => !empty($token),
                'development_mode' => true
            ];
        }

        try {
            // Verificar configuración requerida
            if (empty($this->secretKey) || empty($this->projectId)) {
                Log::error('reCAPTCHA: Configuración incompleta', [
                    'has_secret_key' => !empty($this->secretKey),
                    'has_project_id' => !empty($this->projectId)
                ]);

                return [
                    'success' => false,
                    'error' => 'Configuración de reCAPTCHA incompleta',
                    'valid' => false
                ];
            }

            // Construir URL de la API
            $apiUrl = "https://recaptchaenterprise.googleapis.com/v1/projects/{$this->projectId}/assessments?key={$this->secretKey}";

            // Preparar datos para la API
            $data = [
                'event' => [
                    'token' => $token,
                    'siteKey' => $this->siteKey,
                    'expectedAction' => $expectedAction
                ]
            ];

            if ($userIp) {
                $data['event']['userIpAddress'] = $userIp;
            }

            Log::info('reCAPTCHA: Enviando solicitud a Google', [
                'url' => $apiUrl,
                'action' => $expectedAction,
                'ip' => $userIp
            ]);

            // Realizar solicitud a Google reCAPTCHA Enterprise
            $response = Http::timeout(10)->post($apiUrl, $data);

            if (!$response->successful()) {
                Log::error('reCAPTCHA: Error en respuesta de Google', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'Error al verificar con Google reCAPTCHA',
                    'valid' => false
                ];
            }

            $result = $response->json();

            // Verificar estructura de respuesta
            if (!isset($result['tokenProperties']) || !isset($result['riskAnalysis'])) {
                Log::error('reCAPTCHA: Respuesta inválida de Google', [
                    'response' => $result
                ]);

                return [
                    'success' => false,
                    'error' => 'Respuesta inválida de reCAPTCHA',
                    'valid' => false
                ];
            }

            $tokenProperties = $result['tokenProperties'];
            $riskAnalysis = $result['riskAnalysis'];

            // Verificar validez del token
            $isValid = $tokenProperties['valid'] ?? false;
            $action = $tokenProperties['action'] ?? '';
            $score = $riskAnalysis['score'] ?? 0;

            Log::info('reCAPTCHA: Respuesta de Google recibida', [
                'valid' => $isValid,
                'action' => $action,
                'expected_action' => $expectedAction,
                'score' => $score,
                'min_score' => $this->minScore
            ]);

            // Verificar acción esperada
            if ($action !== $expectedAction) {
                Log::warning('reCAPTCHA: Acción no coincide', [
                    'expected' => $expectedAction,
                    'received' => $action
                ]);

                return [
                    'success' => false,
                    'error' => 'Acción de reCAPTCHA no válida',
                    'valid' => false,
                    'score' => $score,
                    'action' => $action
                ];
            }

            // Verificar puntuación mínima
            $scoreValid = $score >= $this->minScore;

            $success = $isValid && $scoreValid;

            Log::info('reCAPTCHA: Verificación completada', [
                'success' => $success,
                'valid' => $isValid,
                'score_valid' => $scoreValid,
                'final_score' => $score
            ]);

            return [
                'success' => $success,
                'score' => $score,
                'action' => $action,
                'valid' => $isValid,
                'score_valid' => $scoreValid
            ];

        } catch (\Exception $e) {
            Log::error('reCAPTCHA: Excepción durante verificación', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Error interno al verificar reCAPTCHA',
                'valid' => false
            ];
        }
    }

    /**
     * Regla de validación personalizada para reCAPTCHA
     */
    public function validationRule(string $action): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($action) {
            if (empty($value)) {
                $fail('El token de reCAPTCHA es requerido.');
                return;
            }

            $userIp = request()->ip();
            $result = $this->verify($value, $action, $userIp);

            if (!$result['success']) {
                $error = $result['error'] ?? 'Verificación de reCAPTCHA fallida';
                $fail("Error de seguridad: {$error}");
            }
        };
    }

    /**
     * Obtener la clave del sitio
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * Verificar si está en modo desarrollo
     */
    public function isDevelopmentMode(): bool
    {
        return $this->isDevelopment;
    }

    /**
     * Obtener configuración para el frontend
     */
    public function getConfig(): array
    {
        return [
            'site_key' => $this->siteKey,
            'development_mode' => $this->isDevelopment,
            'min_score' => $this->minScore
        ];
    }
}