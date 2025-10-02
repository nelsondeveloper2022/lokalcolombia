<?php

namespace App\Services;

use App\Models\MarketComercioServicio;
use App\Models\MarketComerciosServiciosInformacion;
use App\Models\MarketComerciosServiciosDatosContacto;
use App\Models\MarketComercioServicioImagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ComercioService
{
    /**
     * Estados válidos para comercios
     */
    const ESTADOS = [
        0 => 'eliminado',
        1 => 'pendiente', 
        2 => 'aprobado',
        3 => 'rechazado'
    ];

    /**
     * Crear un nuevo comercio
     */
    public function createComercio(array $data, int $userId): MarketComercioServicio
    {
        DB::beginTransaction();
        
        try {
            // Crear el comercio
            $comercio = MarketComercioServicio::create([
                'idUsuarioCreacion' => $userId,
                'titulo' => $data['titulo'],
                'slug' => MarketComercioServicio::generateUniqueSlug($data['titulo']),
                'idMarketCategoria' => $data['idMarketCategoria'],
                'idMarketTipoComercioServicio' => $data['idMarketTipoComercioServicio'],
                'responsable' => $data['responsable'] ?? null,
                'descripcionCorta' => $data['descripcionCorta'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'estado' => 1, // Pendiente por defecto
                'publicadoEn' => now(),
                'actualizadoEn' => now(),
            ]);

            // Crear información básica si se proporciona
            if (isset($data['info_nombre']) || isset($data['info_email'])) {
                $this->createOrUpdateInformacion($comercio, $data);
            }

            // Crear datos de contacto si se proporcionan
            if (isset($data['contactos']) && is_array($data['contactos'])) {
                $this->createOrUpdateDatosContacto($comercio, $data['contactos']);
            }

            DB::commit();
            return $comercio;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear comercio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualizar un comercio existente
     */
    public function updateComercio(MarketComercioServicio $comercio, array $data): MarketComercioServicio
    {
        DB::beginTransaction();
        
        try {
            // Log para debug
            Log::info('ComercioService updateComercio - Actualizando comercio:', [
                'comercio_id' => $comercio->idMarketComerciosServicios,
                'data_keys' => array_keys($data)
            ]);
            
            // Log del estado actual del comercio
            Log::info('SERVICE 4. Estado actual del comercio:', [
                'titulo' => $comercio->titulo,
                'descripcionCorta' => $comercio->descripcionCorta,
                'contenidoHtml' => $comercio->contenidoHtml,
                'ciudad' => $comercio->ciudad,
                'departamento' => $comercio->departamento,
                'latitud' => $comercio->latitud,
                'longitud' => $comercio->longitud
            ]);
            // Generar slug si es necesario
            if (isset($data['titulo']) && $data['titulo'] !== $comercio->titulo) {
                $data['slug'] = $data['slug'] ?? MarketComercioServicio::generateUniqueSlug(
                    $data['titulo'], 
                    $comercio->idMarketComerciosServicios
                );
            }

            // Actualizar datos básicos
            $comercioDataPrepared = $this->prepareComercioData($data);
            Log::info('SERVICE 5. Datos preparados para update:', $comercioDataPrepared);
            
            $comercio->update($comercioDataPrepared);
            Log::info('SERVICE 6. Comercio después del update:', [
                'titulo' => $comercio->titulo,
                'descripcionCorta' => $comercio->descripcionCorta,
                'contenidoHtml' => $comercio->contenidoHtml,
                'ciudad' => $comercio->ciudad,
                'departamento' => $comercio->departamento,
                'latitud' => $comercio->latitud,
                'longitud' => $comercio->longitud
            ]);

            // Actualizar información interna
            if (isset($data['info_nombre']) || isset($data['info_email']) || isset($data['info_comentarios']) || isset($data['info_whatsapp'])) {
                Log::info('SERVICE 7. Actualizando información interna');
                $this->createOrUpdateInformacion($comercio, $data);
            } else {
                Log::info('SERVICE 7. No hay información interna para actualizar');
            }

            // Actualizar datos de contacto
            if (isset($data['contactos']) && is_array($data['contactos'])) {
                Log::info('SERVICE 8. Actualizando contactos:', $data['contactos']);
                $this->createOrUpdateDatosContacto($comercio, $data['contactos']);
            } else {
                Log::info('SERVICE 8. No hay contactos para actualizar');
            }

            // Manejar imágenes
            if (isset($data['imagenes'])) {
                $this->handleImagenes($comercio, $data['imagenes']);
            }

            DB::commit();
            
            $comercioFresh = $comercio->fresh();
            Log::info('SERVICE 9. Comercio final después de fresh:', [
                'titulo' => $comercioFresh->titulo,
                'descripcionCorta' => $comercioFresh->descripcionCorta,
                'contenidoHtml' => $comercioFresh->contenidoHtml,
                'ciudad' => $comercioFresh->ciudad,
                'departamento' => $comercioFresh->departamento,
                'latitud' => $comercioFresh->latitud,
                'longitud' => $comercioFresh->longitud
            ]);
            Log::info('=== FIN ComercioService updateComercio ===');
            
            return $comercioFresh;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar comercio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Preparar datos del comercio para actualización
     */
    private function prepareComercioData(array $data): array
    {
        $comercioData = [];
        
        $allowedFields = [
            'titulo', 'slug', 'responsable', 'descripcionCorta', 'contenidoHtml',
            'direccion', 'idMarketCategoria', 'idMarketTipoComercioServicio',
            'metaTitulo', 'metaDescripcion', 'estado', 'rutaPortada'
        ];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $comercioData[$field] = $data[$field];
            }
        }

        // Siempre actualizar timestamp
        $comercioData['actualizadoEn'] = now();

        // Validar estado
        if (isset($comercioData['estado'])) {
            $comercioData['estado'] = $this->validateEstado($comercioData['estado']);
        }

        // Auto-generar meta campos si no se proporcionan
        if (isset($data['titulo']) && !isset($data['metaTitulo'])) {
            $comercioData['metaTitulo'] = $data['titulo'];
        }

        if (isset($data['descripcionCorta']) && !isset($data['metaDescripcion'])) {
            $comercioData['metaDescripcion'] = Str::limit($data['descripcionCorta'], 160);
        }

        return $comercioData;
    }

    /**
     * Crear o actualizar información interna del comercio
     */
    private function createOrUpdateInformacion(MarketComercioServicio $comercio, array $data): void
    {
        $informacionData = [
            'nombre' => $data['info_nombre'] ?? null,
            'whatsapp' => isset($data['info_whatsapp']) ? 
                MarketComerciosServiciosDatosContacto::formatPhoneNumber($data['info_whatsapp']) : null,
            'email' => $data['info_email'] ?? null,
            'comentarios' => $data['info_comentarios'] ?? null,
            'estado' => $this->validateEstado($data['info_estado'] ?? 1)
        ];

        // Remover campos null
        $informacionData = array_filter($informacionData, function($value) {
            return !is_null($value);
        });

        if (empty($informacionData)) {
            return;
        }

        if ($comercio->informacion) {
            $comercio->informacion->update($informacionData);
        } else {
            $comercio->informacion()->create($informacionData);
        }
    }

    /**
     * Crear o actualizar datos de contacto
     */
    private function createOrUpdateDatosContacto(MarketComercioServicio $comercio, array $contactos): void
    {
        $datosContacto = $comercio->datosContacto ?? new MarketComerciosServiciosDatosContacto();
        $datosContacto->idMarketComerciosServicios = $comercio->idMarketComerciosServicios;

        // Procesar contactos por tipo
        $contactosPorTipo = $this->groupContactsByType($contactos);

        // Campos de contacto disponibles
        $camposContacto = [
            'direccion', 'telefono', 'whatsapp', 'correo', 'sitioWeb',
            'facebook', 'instagram', 'tiktok', 'twitter', 'linkedin',
            'youtube', 'telegram', 'pinterest', 'snapchat'
        ];

        // Limpiar todos los campos
        foreach ($camposContacto as $campo) {
            $datosContacto->$campo = null;
        }

        // Establecer nuevos valores
        foreach ($contactosPorTipo as $tipo => $valores) {
            if (in_array($tipo, $camposContacto)) {
                if (in_array($tipo, ['telefono', 'whatsapp', 'correo']) && count($valores) > 1) {
                    // Para campos que permiten múltiples valores, usar separador coma
                    $datosContacto->$tipo = implode(',', $valores);
                } else {
                    // Para campos únicos, tomar el primero
                    $datosContacto->$tipo = $valores[0] ?? null;
                }
            }
        }

        $datosContacto->save();
    }

    /**
     * Agrupar contactos por tipo
     */
    private function groupContactsByType(array $contactos): array
    {
        $agrupados = [];

        foreach ($contactos as $contacto) {
            if (!isset($contacto['tipo']) || !isset($contacto['valor'])) {
                continue;
            }

            $tipo = $contacto['tipo'];
            $valor = trim($contacto['valor']);

            if (empty($valor)) {
                continue;
            }

            // Formatear valor según tipo
            $valor = MarketComerciosServiciosDatosContacto::formatContactValue($tipo, $valor);

            if (!isset($agrupados[$tipo])) {
                $agrupados[$tipo] = [];
            }

            // Evitar duplicados
            if (!in_array($valor, $agrupados[$tipo])) {
                $agrupados[$tipo][] = $valor;
            }
        }

        return $agrupados;
    }

    /**
     * Manejar subida y gestión de imágenes
     */
    private function handleImagenes(MarketComercioServicio $comercio, array $imagenesData): void
    {
        // Manejar imagen de portada
        if (isset($imagenesData['portada'])) {
            $this->handleImagenPortada($comercio, $imagenesData['portada']);
        }

        // Manejar eliminación de imágenes
        if (isset($imagenesData['eliminar']) && is_array($imagenesData['eliminar'])) {
            $this->deleteImagenes($comercio, $imagenesData['eliminar']);
        }

        // Manejar nuevas imágenes de galería
        if (isset($imagenesData['galeria']) && is_array($imagenesData['galeria'])) {
            $this->addImagenesGaleria($comercio, $imagenesData['galeria']);
        }

        // Actualizar orden de imágenes
        if (isset($imagenesData['orden']) && is_array($imagenesData['orden'])) {
            $this->updateImagenesOrden($comercio, $imagenesData['orden']);
        }
    }

    /**
     * Manejar imagen de portada
     */
    private function handleImagenPortada(MarketComercioServicio $comercio, $imagenPortada): void
    {
        if (!$imagenPortada || !$imagenPortada->isValid()) {
            return;
        }

        $extension = $imagenPortada->getClientOriginalExtension();
        $nombreArchivo = 'portada_' . time() . '_' . Str::random(10) . '.' . $extension;
        $rutaImagen = $imagenPortada->storeAs(
            'comercios/' . $comercio->idMarketComerciosServicios, 
            $nombreArchivo, 
            'public'
        );

        // Eliminar imagen anterior si existe
        if ($comercio->rutaPortada && Storage::disk('public')->exists($comercio->rutaPortada)) {
            Storage::disk('public')->delete($comercio->rutaPortada);
        }

        $comercio->update(['rutaPortada' => $rutaImagen]);
    }

    /**
     * Eliminar imágenes
     */
    private function deleteImagenes(MarketComercioServicio $comercio, array $imagenesIds): void
    {
        foreach ($imagenesIds as $imagenId) {
            $imagen = $comercio->imagenes()->find($imagenId);
            if ($imagen) {
                // Eliminar archivo físico
                if (Storage::disk('public')->exists($imagen->rutaImagen)) {
                    Storage::disk('public')->delete($imagen->rutaImagen);
                }
                // Eliminar registro
                $imagen->delete();
            }
        }

        // Reordenar imágenes restantes
        MarketComercioServicioImagen::reorderForCommerce($comercio->idMarketComerciosServicios);
    }

    /**
     * Agregar imágenes de galería
     */
    private function addImagenesGaleria(MarketComercioServicio $comercio, array $imagenes): void
    {
        $siguienteOrden = $comercio->imagenes()->max('orden') + 1;

        foreach ($imagenes as $imagen) {
            if (!$imagen || !$imagen->isValid() || $imagen->getSize() > 2048 * 1024) {
                continue; // Saltar imágenes inválidas o muy grandes
            }

            $extension = $imagen->getClientOriginalExtension();
            $nombreArchivo = 'galeria_' . time() . '_' . Str::random(10) . '.' . $extension;
            $rutaImagen = $imagen->storeAs(
                'comercios/' . $comercio->idMarketComerciosServicios . '/galeria', 
                $nombreArchivo, 
                'public'
            );

            $comercio->imagenes()->create([
                'rutaImagen' => $rutaImagen,
                'orden' => $siguienteOrden++
            ]);
        }
    }

    /**
     * Actualizar orden de imágenes
     */
    private function updateImagenesOrden(MarketComercioServicio $comercio, array $ordenData): void
    {
        foreach ($ordenData as $imagenId => $nuevoOrden) {
            $imagen = $comercio->imagenes()->find($imagenId);
            if ($imagen && is_numeric($nuevoOrden) && $nuevoOrden > 0) {
                $imagen->update(['orden' => $nuevoOrden]);
            }
        }
    }

    /**
     * Validar estado
     */
    private function validateEstado($estado): int
    {
        $estado = (int) $estado;
        return array_key_exists($estado, self::ESTADOS) ? $estado : 1; // Por defecto: pendiente
    }

    /**
     * Calcular completitud del perfil
     */
    public function calculateProfileCompleteness($user, $comercio): int
    {
        $analysis = $this->getProfileCompletenessAnalysis($user, $comercio);
        return $analysis['percentage'];
    }

    /**
     * Obtener análisis detallado de completitud del perfil
     */
    public function getProfileCompletenessAnalysis($user, $comercio): array
    {
        $totalFields = 20;
        $completedFields = 0;
        $missingFields = [];
        $completedSections = [];

        // === CAMPOS DEL USUARIO (3 campos) ===
        $userFields = [
            'name' => 'Nombre completo del usuario',
            'email' => 'Correo electrónico del usuario',
            'email_verified' => 'Verificación de correo electrónico'
        ];

        $userCompleted = 0;
        if (!empty($user->name)) {
            $completedFields++;
            $userCompleted++;
        } else {
            $missingFields[] = $userFields['name'];
        }

        if (!empty($user->email)) {
            $completedFields++;
            $userCompleted++;
        } else {
            $missingFields[] = $userFields['email'];
        }

        if ($user->hasVerifiedEmail()) {
            $completedFields++;
            $userCompleted++;
        } else {
            $missingFields[] = $userFields['email_verified'];
        }

        $completedSections['usuario'] = [
            'completed' => $userCompleted,
            'total' => 3,
            'percentage' => (int)(($userCompleted / 3) * 100)
        ];

        if (!$comercio) {
            return [
                'percentage' => (int)(($completedFields / $totalFields) * 100),
                'completed_fields' => $completedFields,
                'total_fields' => $totalFields,
                'missing_fields' => $missingFields,
                'sections' => $completedSections
            ];
        }

        // === CAMPOS BÁSICOS DEL COMERCIO (8 campos) ===
        $comercioFields = [
            'titulo' => 'Título del negocio',
            'responsable' => 'Nombre del responsable',
            'descripcionCorta' => 'Descripción breve',
            'contenidoHtml' => 'Descripción detallada',
            'direccion' => 'Dirección física',
            'categoria' => 'Categoría del negocio',
            'tipo' => 'Tipo de comercio/servicio',
            'imagen_portada' => 'Imagen de portada'
        ];

        $comercioCompleted = 0;
        if (!empty($comercio->titulo)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['titulo'];
        }

        if (!empty($comercio->responsable)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['responsable'];
        }

        if (!empty($comercio->descripcionCorta)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['descripcionCorta'];
        }

        if (!empty($comercio->contenidoHtml)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['contenidoHtml'];
        }

        if (!empty($comercio->direccion)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['direccion'];
        }

        if (!empty($comercio->idMarketCategoria)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['categoria'];
        }

        if (!empty($comercio->idMarketTipoComercioServicio)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['tipo'];
        }

        if (!empty($comercio->rutaPortada)) {
            $completedFields++;
            $comercioCompleted++;
        } else {
            $missingFields[] = $comercioFields['imagen_portada'];
        }

        $completedSections['comercio_basico'] = [
            'completed' => $comercioCompleted,
            'total' => 8,
            'percentage' => (int)(($comercioCompleted / 8) * 100)
        ];

        // === DATOS DE CONTACTO (4 campos) ===
        $contactoFields = [
            'telefono_whatsapp' => 'Teléfono o WhatsApp',
            'correo' => 'Correo electrónico de contacto',
            'redes_sociales' => 'Al menos una red social',
            'sitio_web' => 'Sitio web o página'
        ];

        $contactoCompleted = 0;
        $datosContacto = $comercio->datosContacto;
        if ($datosContacto) {
            // Campo 1: Teléfono o WhatsApp
            if (!empty($datosContacto->telefono) || !empty($datosContacto->whatsapp)) {
                $completedFields++;
                $contactoCompleted++;
            } else {
                $missingFields[] = $contactoFields['telefono_whatsapp'];
            }

            // Campo 2: Correo electrónico
            if (!empty($datosContacto->correo)) {
                $completedFields++;
                $contactoCompleted++;
            } else {
                $missingFields[] = $contactoFields['correo'];
            }

            // Campo 3: Redes sociales
            if (!empty($datosContacto->facebook) || !empty($datosContacto->instagram) || 
                !empty($datosContacto->tiktok) || !empty($datosContacto->twitter) || 
                !empty($datosContacto->linkedin) || !empty($datosContacto->youtube) ||
                !empty($datosContacto->telegram) || !empty($datosContacto->pinterest) ||
                !empty($datosContacto->snapchat)) {
                $completedFields++;
                $contactoCompleted++;
            } else {
                $missingFields[] = $contactoFields['redes_sociales'];
            }

            // Campo 4: Sitio web
            if (!empty($datosContacto->sitioWeb)) {
                $completedFields++;
                $contactoCompleted++;
            } else {
                $missingFields[] = $contactoFields['sitio_web'];
            }
        } else {
            // Si no hay datos de contacto, todos están faltando
            $missingFields = array_merge($missingFields, array_values($contactoFields));
        }

        $completedSections['contacto'] = [
            'completed' => $contactoCompleted,
            'total' => 4,
            'percentage' => (int)(($contactoCompleted / 4) * 100)
        ];

        // === INFORMACIÓN ADICIONAL (2 campos) ===
        $infoFields = [
            'nombre_contacto' => 'Nombre de contacto interno',
            'comentarios' => 'Comentarios adicionales'
        ];

        $infoCompleted = 0;
        $informacion = $comercio->informacion;
        if ($informacion) {
            if (!empty($informacion->nombre)) {
                $completedFields++;
                $infoCompleted++;
            } else {
                $missingFields[] = $infoFields['nombre_contacto'];
            }

            if (!empty($informacion->comentarios)) {
                $completedFields++;
                $infoCompleted++;
            } else {
                $missingFields[] = $infoFields['comentarios'];
            }
        } else {
            $missingFields = array_merge($missingFields, array_values($infoFields));
        }

        $completedSections['informacion'] = [
            'completed' => $infoCompleted,
            'total' => 2,
            'percentage' => (int)(($infoCompleted / 2) * 100)
        ];

        // === IMÁGENES ADICIONALES (3 campos progresivos) ===
        $imagenes = $comercio->imagenes;
        $totalImagenes = $imagenes ? $imagenes->count() : 0;
        
        $imagenesCompleted = 0;
        $imagenesFields = [];

        if ($totalImagenes >= 1) {
            $completedFields++;
            $imagenesCompleted++;
        } else {
            $imagenesFields[] = 'Al menos 1 imagen en galería';
        }

        if ($totalImagenes >= 3) {
            $completedFields++;
            $imagenesCompleted++;
        } else {
            $imagenesFields[] = 'Al menos 3 imágenes en galería';
        }

        if ($totalImagenes >= 5) {
            $completedFields++;
            $imagenesCompleted++;
        } else {
            $imagenesFields[] = 'Al menos 5 imágenes en galería';
        }

        $missingFields = array_merge($missingFields, $imagenesFields);

        $completedSections['imagenes'] = [
            'completed' => $imagenesCompleted,
            'total' => 3,
            'percentage' => (int)(($imagenesCompleted / 3) * 100),
            'current_count' => $totalImagenes
        ];

        return [
            'percentage' => (int)(($completedFields / $totalFields) * 100),
            'completed_fields' => $completedFields,
            'total_fields' => $totalFields,
            'missing_fields' => $missingFields,
            'sections' => $completedSections
        ];
    }

    /**
     * Verificar y aplicar aprobación automática basada en completitud
     */
    public function checkAndApplyAutomaticApproval($user, MarketComercioServicio $comercio): bool
    {
        // Solo aplicar si el comercio está en estado pendiente
        if ($comercio->estado != 1) {
            return false;
        }
        
        $completitud = $this->calculateProfileCompleteness($user, $comercio);
        
        if ($completitud >= 80) {
            $comercio->update(['estado' => 2]); // Aprobar automáticamente
            
            Log::info('Comercio aprobado automáticamente:', [
                'comercio_id' => $comercio->idMarketComerciosServicios,
                'completitud' => $completitud,
                'estado_anterior' => 1,
                'estado_nuevo' => 2
            ]);
            
            return true;
        }
        
        return false;
    }

    /**
     * Obtener opciones de estado
     */
    public static function getEstadosOptions(): array
    {
        return [
            1 => 'Pendiente',
            2 => 'Aprobado', 
            3 => 'Rechazado',
            0 => 'Eliminado'
        ];
    }
}