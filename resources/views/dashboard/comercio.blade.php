@extends('layouts.dashboard')

@section('title', 'Información del Comercio - Lokal Colombia')
@section('page-title', 'Información del Comercio')

@section('content')
<div class="dashboard-content">
    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul style="margin-top: 0.5rem; margin-bottom: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Email Verification Block -->
    @if(!$user->hasVerifiedEmail())
        <div class="verification-block">
            <div class="verification-overlay">
                <div class="verification-content">
                    <div class="verification-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Email no verificado</h3>
                    <p>Debes verificar tu correo electrónico antes de poder editar la información de tu comercio.</p>
                    <div class="verification-actions">
                        <form method="POST" action="{{ route('dashboard.resend-verification') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Reenviar correo de verificación
                            </button>
                        </form>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i>
                            Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Commerce Form -->
    <div class="commerce-form {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}">
        <form method="POST" action="{{ route('dashboard.comercio.update') }}" id="comercioForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="form-header">
                <div class="header-content">
                    <h2 class="form-title">
                        <i class="fas fa-store"></i>
                        Información de tu Comercio
                    </h2>
                    <p class="form-description">
                        Completa la información de tu negocio para que los clientes puedan encontrarte fácilmente.
                        @if($completitud < 80)
                            <br><small style="opacity: 0.8; font-size: 0.875rem;">
                                <i class="fas fa-rocket"></i> 
                                Con 80% de completitud, tu comercio se publica automáticamente.
                            </small>
                        @endif
                    </p>
                </div>
                <div class="completion-badge">
                    <div class="completion-circle {{ $completitud >= 80 ? 'auto-published' : ($completitud >= 70 ? 'near-auto-publish' : '') }}">
                        <span>{{ $completitud }}%</span>
                        @if($completitud >= 80)
                            <i class="fas fa-check-circle" style="position: absolute; top: -5px; right: -5px; font-size: 0.75rem; color: #10b981; background: white; border-radius: 50%; padding: 2px;"></i>
                        @endif
                    </div>
                    <div class="completion-info">
                        <span class="completion-text">Completitud</span>
                        <button type="button" class="completion-help-btn" onclick="toggleCompletionHelp()">
                            <i class="fas fa-question-circle"></i>
                            <span>¿Qué falta?</span>
                        </button>
                    </div>
                    
                    <!-- Modal/Dropdown de ayuda -->
                    <div id="completion-help-modal" class="completion-help-modal" style="display: none;">
                        <div class="completion-help-content">
                            <div class="help-header">
                                <h4>
                                    <i class="fas fa-chart-line"></i>
                                    Completa tu perfil al 100%
                                </h4>
                                <button type="button" class="help-close-btn" onclick="toggleCompletionHelp()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <div class="help-progress">
                                <div class="overall-progress">
                                    <div class="progress-info">
                                        <span class="progress-label">Progreso general</span>
                                        <span class="progress-value">{{ $completitud }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $completitud }}%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="help-sections">
                                @if(isset($completitudAnalisis['sections']))
                                    @php
                                        $sectionIcons = [
                                            'usuario' => 'fas fa-user',
                                            'comercio_basico' => 'fas fa-store',
                                            'contacto' => 'fas fa-phone',
                                            'informacion' => 'fas fa-info-circle',
                                            'imagenes' => 'fas fa-images'
                                        ];
                                        
                                        $sectionNames = [
                                            'usuario' => 'Usuario',
                                            'comercio_basico' => 'Información Básica',
                                            'contacto' => 'Contacto',
                                            'informacion' => 'Información Adicional',
                                            'imagenes' => 'Galería'
                                        ];
                                    @endphp
                                    
                                    @foreach($completitudAnalisis['sections'] as $sectionKey => $sectionData)
                                        <div class="help-section">
                                            <div class="section-header">
                                                <i class="{{ $sectionIcons[$sectionKey] ?? 'fas fa-circle' }} section-icon"></i>
                                                <span class="section-name">{{ $sectionNames[$sectionKey] ?? ucfirst($sectionKey) }}</span>
                                                <span class="section-progress">{{ $sectionData['completed'] }}/{{ $sectionData['total'] }}</span>
                                            </div>
                                            <div class="section-items">
                                                @if($sectionKey === 'usuario')
                                                    <div class="item {{ !empty($user->name) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($user->name) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Nombre completo del usuario</span>
                                                    </div>
                                                    <div class="item {{ !empty($user->email) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($user->email) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Correo electrónico del usuario</span>
                                                    </div>
                                                    <div class="item {{ $user->hasVerifiedEmail() ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ $user->hasVerifiedEmail() ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Verificación de correo electrónico</span>
                                                    </div>
                                                @elseif($sectionKey === 'comercio_basico')
                                                    <div class="item {{ !empty($comercio->titulo ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->titulo ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Título del negocio</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->responsable ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->responsable ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Nombre del responsable</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->descripcionCorta ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->descripcionCorta ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Descripción breve</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->contenidoHtml ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->contenidoHtml ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Descripción detallada</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->direccion ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->direccion ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Dirección física</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->idMarketCategoria ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->idMarketCategoria ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Categoría del negocio</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->idMarketTipoComercioServicio ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->idMarketTipoComercioServicio ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Tipo de comercio/servicio</span>
                                                    </div>
                                                    <div class="item {{ !empty($comercio->rutaPortada ?? '') ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ !empty($comercio->rutaPortada ?? '') ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Imagen de portada</span>
                                                    </div>
                                                @elseif($sectionKey === 'contacto')
                                                    @php $datosContacto = $comercio->datosContacto ?? null; @endphp
                                                    <div class="item {{ ($datosContacto && (!empty($datosContacto->telefono) || !empty($datosContacto->whatsapp))) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($datosContacto && (!empty($datosContacto->telefono) || !empty($datosContacto->whatsapp))) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Teléfono o WhatsApp</span>
                                                    </div>
                                                    <div class="item {{ ($datosContacto && !empty($datosContacto->correo)) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($datosContacto && !empty($datosContacto->correo)) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Correo electrónico de contacto</span>
                                                    </div>
                                                    <div class="item {{ ($datosContacto && (!empty($datosContacto->facebook) || !empty($datosContacto->instagram) || !empty($datosContacto->tiktok) || !empty($datosContacto->twitter) || !empty($datosContacto->linkedin) || !empty($datosContacto->youtube))) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($datosContacto && (!empty($datosContacto->facebook) || !empty($datosContacto->instagram) || !empty($datosContacto->tiktok) || !empty($datosContacto->twitter) || !empty($datosContacto->linkedin) || !empty($datosContacto->youtube))) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Al menos una red social</span>
                                                    </div>
                                                    <div class="item {{ ($datosContacto && !empty($datosContacto->sitioWeb)) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($datosContacto && !empty($datosContacto->sitioWeb)) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Sitio web o página</span>
                                                    </div>
                                                @elseif($sectionKey === 'informacion')
                                                    @php $informacion = $comercio->informacion ?? null; @endphp
                                                    <div class="item {{ ($informacion && !empty($informacion->nombre)) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($informacion && !empty($informacion->nombre)) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Nombre de contacto interno</span>
                                                    </div>
                                                    <div class="item {{ ($informacion && !empty($informacion->comentarios)) ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ ($informacion && !empty($informacion->comentarios)) ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Comentarios adicionales</span>
                                                    </div>
                                                @elseif($sectionKey === 'imagenes')
                                                    @php 
                                                        $totalImagenes = $comercio && $comercio->imagenes ? $comercio->imagenes->count() : 0;
                                                        $currentCount = $sectionData['current_count'] ?? $totalImagenes;
                                                    @endphp
                                                    <div class="item {{ $currentCount >= 1 ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ $currentCount >= 1 ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Al menos 1 imagen en galería ({{ $currentCount }}/1)</span>
                                                    </div>
                                                    <div class="item {{ $currentCount >= 3 ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ $currentCount >= 3 ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Al menos 3 imágenes en galería ({{ $currentCount }}/3)</span>
                                                    </div>
                                                    <div class="item {{ $currentCount >= 5 ? 'completed' : 'pending' }}">
                                                        <i class="fas fa-{{ $currentCount >= 5 ? 'check-circle' : 'clock' }}"></i>
                                                        <span>Al menos 5 imágenes en galería ({{ $currentCount }}/5)</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="help-section">
                                        <div class="section-items">
                                            <div class="item pending">
                                                <i class="fas fa-info-circle"></i>
                                                <span>No se pudo cargar la información de completitud detallada.</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="help-footer">
                                <!-- Alerta de Publicación Automática -->
                                @if($completitud >= 80)
                                    <div class="auto-publish-alert auto-publish-success">
                                        <div class="alert-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="alert-content">
                                            <h6>¡Comercio publicado automáticamente!</h6>
                                            <p>Tu perfil tiene {{ $completitud }}% de completitud. Los comercios con 80% o más se publican automáticamente.</p>
                                        </div>
                                    </div>
                                @elseif($completitud >= 70)
                                    <div class="auto-publish-alert auto-publish-warning">
                                        <div class="alert-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="alert-content">
                                            <h6>¡Estás muy cerca!</h6>
                                            <p>Solo necesitas {{ 80 - $completitud }}% más para que tu comercio se publique automáticamente.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="auto-publish-alert auto-publish-info">
                                        <div class="alert-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div class="alert-content">
                                            <h6>Publicación Automática</h6>
                                            <p>Cuando tu perfil alcance el 80% de completitud, tu comercio se publicará automáticamente sin necesidad de revisión manual.</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="help-tips">
                                    <h5><i class="fas fa-lightbulb"></i> Consejos para completar:</h5>
                                    <ul>
                                        <li>Un perfil completo atrae más clientes</li>
                                        <li>Las imágenes son fundamentales para generar confianza</li>
                                        <li>Completa la información de contacto para facilitar que te encuentren</li>
                                        <li>Una buena descripción ayuda a posicionarte mejor</li>
                                        <li><strong>Con 80% o más, tu comercio se publica automáticamente</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <span>Información Básica</span>
                </div>
                <div class="step" data-step="2">
                    <div class="step-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <span>Ubicación</span>
                </div>
                <div class="step" data-step="3">
                    <div class="step-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <span>Contacto</span>
                </div>
                <div class="step" data-step="4">
                    <div class="step-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <span>Multimedia</span>
                </div>
            </div>

            <!-- Step 1: Basic Information -->
            <div class="form-step active" data-step="1">
                <div class="step-header">
                    <h3>Información Básica</h3>
                    <p>Datos fundamentales de tu negocio</p>
                </div>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="titulo" class="form-label">
                            <i class="fas fa-store"></i>
                            Nombre del Comercio
                        </label>
                        <input type="text" 
                               id="titulo" 
                               name="titulo" 
                               class="form-input"
                               value="{{ old('titulo', $comercio->titulo ?? '') }}"
                               placeholder="Ingresa el nombre de tu negocio"
                               {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                        <small class="form-hint">Este será el nombre principal que verán los clientes</small>
                    </div>

                    <div class="form-group">
                        <label for="idMarketCategoria" class="form-label">
                            <i class="fas fa-tags"></i>
                            Categoría
                        </label>
                        <select id="idMarketCategoria" 
                                name="idMarketCategoria" 
                                class="form-select search-select"
                                {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->idMarketCategoria }}" 
                                        {{ old('idMarketCategoria', $comercio->idMarketCategoria ?? '') == $categoria->idMarketCategoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="idMarketTipoComercioServicio" class="form-label">
                            <i class="fas fa-briefcase"></i>
                            Tipo de Comercio
                        </label>
                        <select id="idMarketTipoComercioServicio" 
                                name="idMarketTipoComercioServicio" 
                                class="form-select search-select"
                                {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposComercio as $tipo)
                                <option value="{{ $tipo->idMarketTipoComercioServicio }}" 
                                        {{ old('idMarketTipoComercioServicio', $comercio->idMarketTipoComercioServicio ?? '') == $tipo->idMarketTipoComercioServicio ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="responsable" class="form-label">
                            <i class="fas fa-user-tie"></i>
                            Responsable del Comercio
                        </label>
                        <input type="text" 
                               id="responsable" 
                               name="responsable" 
                               class="form-input"
                               value="{{ old('responsable', $comercio->responsable ?? '') }}"
                               placeholder="Nombre del responsable o propietario"
                               {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                    </div>

                    <div class="form-group full-width">
                        <label for="descripcionCorta" class="form-label">
                            <i class="fas fa-align-left"></i>
                            Descripción Corta
                        </label>
                        <textarea id="descripcionCorta" 
                                  name="descripcionCorta" 
                                  class="form-textarea"
                                  rows="3"
                                  placeholder="Describe brevemente tu negocio (máximo 500 caracteres)"
                                  maxlength="500"
                                  {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>{{ old('descripcionCorta', $comercio->descripcionCorta ?? '') }}</textarea>
                        <div class="char-counter">
                            <span id="charCountCorta">0</span>/500 caracteres
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="contenidoHtml" class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Descripción Detallada
                        </label>
                        <textarea id="contenidoHtml" 
                                  name="contenidoHtml" 
                                  class="form-textarea"
                                  rows="6"
                                  placeholder="Proporciona una descripción completa de tu negocio, productos y servicios"
                                  maxlength="5000"
                                  {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>{{ old('contenidoHtml', $comercio->contenidoHtml ?? '') }}</textarea>
                        <div class="char-counter">
                            <span id="charCountDetallada">0</span>/5000 caracteres
                        </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-search"></i>
                            Información SEO (Opcional)
                        </h4>
                        <p class="section-description">Esta información ayudará a que tu comercio aparezca mejor en los resultados de búsqueda.</p>
                        
                        <div class="form-group full-width">
                            <label for="metaTitulo" class="form-label">
                                <i class="fas fa-heading"></i>
                                Meta Título
                            </label>
                            <input type="text" 
                                   id="metaTitulo" 
                                   name="metaTitulo" 
                                   class="form-input"
                                   value="{{ old('metaTitulo', $comercio->metaTitulo ?? '') }}"
                                   placeholder="Título para motores de búsqueda"
                                   maxlength="255"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <small class="form-hint">Si no se proporciona, se usará el nombre del comercio</small>
                        </div>

                        <div class="form-group full-width">
                            <label for="metaDescripcion" class="form-label">
                                <i class="fas fa-paragraph"></i>
                                Meta Descripción
                            </label>
                            <textarea id="metaDescripcion" 
                                      name="metaDescripcion" 
                                      class="form-textarea"
                                      rows="3"
                                      placeholder="Descripción para motores de búsqueda"
                                      maxlength="500"
                                      {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>{{ old('metaDescripcion', $comercio->metaDescripcion ?? '') }}</textarea>
                            <div class="char-counter">
                                <span id="charCountMeta">0</span>/500 caracteres
                            </div>
                            <small class="form-hint">Si no se proporciona, se usará la descripción corta</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Location -->
            <div class="form-step" data-step="2">
                <div class="step-header">
                    <h3>Ubicación</h3>
                    <p>Información de ubicación de tu negocio</p>
                </div>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="direccion" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Dirección Completa
                        </label>
                        <textarea id="direccion" 
                                  name="direccion" 
                                  class="form-textarea"
                                  rows="3"
                                  placeholder="Ej: Calle 45 #23-67, Barrio Centro, Bogotá, Cundinamarca - Cerca al parque principal"
                                  {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>{{ old('direccion', $comercio->direccion ?? '') }}</textarea>
                        <small class="form-hint">Incluye dirección exacta, barrio, ciudad, departamento y puntos de referencia importantes para facilitar la ubicación del negocio.</small>
                    </div>
                </div>
            </div>

            <!-- Step 3: Contact -->
            <div class="form-step" data-step="3">
                <div class="step-header">
                    <h3>Información de Contacto</h3>
                    <p>Medios de contacto para tus clientes</p>
                </div>

                <!-- Información Interna (Administrativa) -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-shield-alt"></i>
                        Información Administrativa (Interna)
                    </h4>
                    <p class="section-description">Esta información es solo para comunicación directa entre la plataforma y tu comercio.</p>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="info_nombre" class="form-label">
                                <i class="fas fa-user"></i>
                                Nombre del Responsable
                            </label>
                            <input type="text" 
                                   id="info_nombre" 
                                   name="info_nombre" 
                                   class="form-input"
                                   value="{{ old('info_nombre', $comercio->informacion->nombre ?? '') }}"
                                   placeholder="Nombre completo del responsable"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="info_whatsapp" class="form-label">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp Administrativo
                            </label>
                            <input type="tel" 
                                   id="info_whatsapp" 
                                   name="info_whatsapp" 
                                   class="form-input"
                                   value="{{ old('info_whatsapp', $comercio->informacion->whatsapp ?? '') }}"
                                   placeholder="WhatsApp para comunicación directa"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="info_email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email Administrativo
                            </label>
                            <input type="email" 
                                   id="info_email" 
                                   name="info_email" 
                                   class="form-input"
                                   value="{{ old('info_email', $comercio->informacion->email ?? '') }}"
                                   placeholder="Email para comunicación directa"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                        </div>

                        <div class="form-group full-width">
                            <label for="info_comentarios" class="form-label">
                                <i class="fas fa-comment-alt"></i>
                                Comentarios Internos
                            </label>
                            <textarea id="info_comentarios" 
                                      name="info_comentarios" 
                                      class="form-textarea"
                                      rows="3"
                                      placeholder="Información adicional para uso interno"
                                      {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>{{ old('info_comentarios', $comercio->informacion->comentarios ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Datos de Contacto Públicos (Dinámicos) -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-globe"></i>
                        Información de Contacto Pública
                    </h4>
                    <p class="section-description">Esta información será visible para tus clientes en el perfil de tu comercio.</p>
                    
                    <div id="contactos-dinamicos">
                        <!-- Contactos existentes -->
                        @if($comercio && $comercio->datosContacto)
                            @php
                                $datosContacto = $comercio->datosContacto;
                                $contactos = [];
                                
                                // Procesar contactos existentes
                                if ($datosContacto->telefono) {
                                    foreach(explode(',', $datosContacto->telefono) as $tel) {
                                        $contactos[] = ['tipo' => 'telefono', 'valor' => trim($tel)];
                                    }
                                }
                                if ($datosContacto->whatsapp) {
                                    foreach(explode(',', $datosContacto->whatsapp) as $whats) {
                                        $contactos[] = ['tipo' => 'whatsapp', 'valor' => trim($whats)];
                                    }
                                }
                                if ($datosContacto->correo) {
                                    foreach(explode(',', $datosContacto->correo) as $email) {
                                        $contactos[] = ['tipo' => 'correo', 'valor' => trim($email)];
                                    }
                                }
                                if ($datosContacto->sitioWeb) $contactos[] = ['tipo' => 'sitioWeb', 'valor' => $datosContacto->sitioWeb];
                                if ($datosContacto->facebook) $contactos[] = ['tipo' => 'facebook', 'valor' => $datosContacto->facebook];
                                if ($datosContacto->instagram) $contactos[] = ['tipo' => 'instagram', 'valor' => $datosContacto->instagram];
                                if ($datosContacto->tiktok) $contactos[] = ['tipo' => 'tiktok', 'valor' => $datosContacto->tiktok];
                                if ($datosContacto->twitter) $contactos[] = ['tipo' => 'twitter', 'valor' => $datosContacto->twitter];
                                if ($datosContacto->linkedin) $contactos[] = ['tipo' => 'linkedin', 'valor' => $datosContacto->linkedin];
                                if ($datosContacto->youtube) $contactos[] = ['tipo' => 'youtube', 'valor' => $datosContacto->youtube];
                                if ($datosContacto->telegram) $contactos[] = ['tipo' => 'telegram', 'valor' => $datosContacto->telegram];
                                if ($datosContacto->pinterest) $contactos[] = ['tipo' => 'pinterest', 'valor' => $datosContacto->pinterest];
                                if ($datosContacto->snapchat) $contactos[] = ['tipo' => 'snapchat', 'valor' => $datosContacto->snapchat];
                            @endphp
                            
                            @forelse($contactos as $index => $contacto)
                                <div class="contacto-item" data-index="{{ $index }}">
                                    <div class="form-grid contacto-grid">
                                        <div class="form-group">
                                            <label class="form-label">Tipo de Contacto</label>
                                            <select name="contactos_tipo[]" class="form-select contacto-tipo" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="telefono" {{ $contacto['tipo'] == 'telefono' ? 'selected' : '' }}>📞 Teléfono</option>
                                                <option value="whatsapp" {{ $contacto['tipo'] == 'whatsapp' ? 'selected' : '' }}>📱 WhatsApp</option>
                                                <option value="correo" {{ $contacto['tipo'] == 'correo' ? 'selected' : '' }}>📧 Correo electrónico</option>
                                                <option value="sitioWeb" {{ $contacto['tipo'] == 'sitioWeb' ? 'selected' : '' }}>🌐 Sitio web</option>
                                                <option value="facebook" {{ $contacto['tipo'] == 'facebook' ? 'selected' : '' }}>👤 Facebook</option>
                                                <option value="instagram" {{ $contacto['tipo'] == 'instagram' ? 'selected' : '' }}>📷 Instagram</option>
                                                <option value="tiktok" {{ $contacto['tipo'] == 'tiktok' ? 'selected' : '' }}>🎵 TikTok</option>
                                                <option value="twitter" {{ $contacto['tipo'] == 'twitter' ? 'selected' : '' }}>🐦 Twitter (X)</option>
                                                <option value="linkedin" {{ $contacto['tipo'] == 'linkedin' ? 'selected' : '' }}>💼 LinkedIn</option>
                                                <option value="youtube" {{ $contacto['tipo'] == 'youtube' ? 'selected' : '' }}>📺 YouTube</option>
                                                <option value="telegram" {{ $contacto['tipo'] == 'telegram' ? 'selected' : '' }}>✈️ Telegram</option>
                                                <option value="pinterest" {{ $contacto['tipo'] == 'pinterest' ? 'selected' : '' }}>📌 Pinterest</option>
                                                <option value="snapchat" {{ $contacto['tipo'] == 'snapchat' ? 'selected' : '' }}>👻 Snapchat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Valor del Contacto</label>
                                            <input type="text" 
                                                   name="contactos_valor[]" 
                                                   class="form-input contacto-valor"
                                                   value="{{ $contacto['valor'] }}"
                                                   placeholder="Ingresa el valor del contacto"
                                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                        </div>

                                        <div class="form-group contacto-actions">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-contacto" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <!-- Contacto inicial vacío -->
                                <div class="contacto-item" data-index="0">
                                    <div class="form-grid contacto-grid">
                                        <div class="form-group">
                                            <label class="form-label">Tipo de Contacto</label>
                                            <select name="contactos_tipo[]" class="form-select contacto-tipo" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="telefono">📞 Teléfono</option>
                                                <option value="whatsapp">📱 WhatsApp</option>
                                                <option value="correo">📧 Correo electrónico</option>
                                                <option value="sitioWeb">🌐 Sitio web</option>
                                                <option value="facebook">👤 Facebook</option>
                                                <option value="instagram">📷 Instagram</option>
                                                <option value="tiktok">🎵 TikTok</option>
                                                <option value="twitter">🐦 Twitter (X)</option>
                                                <option value="linkedin">💼 LinkedIn</option>
                                                <option value="youtube">📺 YouTube</option>
                                                <option value="telegram">✈️ Telegram</option>
                                                <option value="pinterest">📌 Pinterest</option>
                                                <option value="snapchat">👻 Snapchat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Valor del Contacto</label>
                                            <input type="text" 
                                                   name="contactos_valor[]" 
                                                   class="form-input contacto-valor"
                                                   placeholder="Ingresa el valor del contacto"
                                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                        </div>

                                        <div class="form-group contacto-actions">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-contacto" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        @else
                            <!-- Contacto inicial vacío -->
                            <div class="contacto-item" data-index="0">
                                <div class="form-grid contacto-grid">
                                    <div class="form-group">
                                        <label class="form-label">Tipo de Contacto</label>
                                        <select name="contactos_tipo[]" class="form-select contacto-tipo" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="telefono">📞 Teléfono</option>
                                            <option value="whatsapp">📱 WhatsApp</option>
                                            <option value="correo">📧 Correo electrónico</option>
                                            <option value="sitioWeb">🌐 Sitio web</option>
                                            <option value="facebook">👤 Facebook</option>
                                            <option value="instagram">📷 Instagram</option>
                                            <option value="tiktok">🎵 TikTok</option>
                                            <option value="twitter">🐦 Twitter (X)</option>
                                            <option value="linkedin">💼 LinkedIn</option>
                                            <option value="youtube">📺 YouTube</option>
                                            <option value="telegram">✈️ Telegram</option>
                                            <option value="pinterest">📌 Pinterest</option>
                                            <option value="snapchat">👻 Snapchat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Valor del Contacto</label>
                                        <input type="text" 
                                               name="contactos_valor[]" 
                                               class="form-input contacto-valor"
                                               placeholder="Ingresa el valor del contacto"
                                               {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                    </div>

                                    <div class="form-group contacto-actions">
                                        <button type="button" class="btn btn-danger btn-sm eliminar-contacto" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="contacto-add-section">
                        <button type="button" id="agregar-contacto" class="btn btn-outline" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <i class="fas fa-plus"></i>
                            Agregar Contacto
                        </button>
                        <small class="form-hint">Puedes agregar múltiples contactos del mismo tipo (ej: 2 WhatsApp, 3 teléfonos, etc.)</small>
                    </div>
                </div>
            </div>

            <!-- Step 4: Multimedia -->
            <div class="form-step" data-step="4">
                <div class="step-header">
                    <h3>Multimedia</h3>
                    <p>Imágenes de tu negocio</p>
                </div>

                <div class="form-grid">
                    <!-- Imagen de Portada/Perfil (Obligatoria) -->
                    <div class="form-group full-width">
                        <label for="imagen_portada" class="form-label">
                            <i class="fas fa-image"></i>
                            Imagen de Portada/Perfil
                        </label>
                        <div class="file-upload-area">
                            <input type="file" 
                                   id="imagen_portada" 
                                   name="imagen_portada" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="file-input"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Arrastra tu imagen de portada aquí o haz clic para seleccionar</p>
                                <small>Formatos: JPG, PNG, GIF (Max: 2MB) - Esta imagen será la principal de tu comercio</small>
                            </div>
                        </div>
                        @if($comercio && $comercio->rutaPortada)
                            <div class="current-file">
                                <img src="{{ asset('storage/' . $comercio->rutaPortada) }}" alt="Imagen de portada actual" class="file-preview">
                                <span>Imagen de portada actual</span>
                            </div>
                        @endif
                    </div>

                    <!-- Galería de Imágenes Adicionales -->
                    <div class="form-group full-width">
                        <label for="imagenes_galeria" class="form-label">
                            <i class="fas fa-images"></i>
                            Galería de Imágenes Adicionales
                        </label>
                        <div class="file-upload-area">
                            <input type="file" 
                                   id="imagenes_galeria" 
                                   name="imagenes_galeria[]" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   multiple
                                   class="file-input"
                                   {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                            <div class="file-upload-content">
                                <i class="fas fa-images"></i>
                                <p>Selecciona múltiples imágenes para tu galería</p>
                                <small>Formatos: JPG, PNG, GIF (Max: 2MB cada una) - Estas imágenes complementarán tu perfil</small>
                            </div>
                        </div>
                        
                        <!-- Imágenes existentes de la galería -->
                        @if($comercio && $comercio->imagenes && $comercio->imagenes->count() > 0)
                            <div class="images-grid">
                                <h5 class="images-title">Imágenes actuales en tu galería:</h5>
                                @foreach($comercio->imagenes->sortBy('orden') as $imagen)
                                    <div class="image-item" data-imagen-id="{{ $imagen->idMarketComercioServicioImagen }}">
                                        <img src="{{ asset('storage/' . $imagen->rutaImagen) }}" alt="Imagen de galería">
                                        <div class="image-overlay">
                                            <div class="image-actions">
                                                <span class="image-order">Orden: {{ $imagen->orden }}</span>
                                                <label class="image-delete">
                                                    <input type="checkbox" 
                                                           name="imagenes_eliminar[]" 
                                                           value="{{ $imagen->idMarketComercioServicioImagen }}"
                                                           {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="images-help">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Marca las imágenes que deseas eliminar y luego guarda los cambios. Las nuevas imágenes se agregarán al final de la galería.
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" id="prevStep" class="btn btn-outline" style="display: none;">
                    <i class="fas fa-arrow-left"></i>
                    Anterior
                </button>
                
                <div class="action-buttons">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                    
                    <button type="button" id="nextStep" class="btn btn-primary">
                        Siguiente
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <button type="submit" id="submitForm" class="btn btn-success" style="display: none;" {{ !$user->hasVerifiedEmail() ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i>
                        Guardar Información
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.dashboard-content {
    max-width: 1000px;
    margin: 0 auto;
}

/* Verification Block */
.verification-block {
    position: relative;
    margin-bottom: 2rem;
}

.verification-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    border-radius: 1.5rem;
    backdrop-filter: blur(5px);
}

.verification-content {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color);
}

.verification-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1rem;
}

.verification-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.verification-content p {
    color: var(--text-light);
    margin-bottom: 1.5rem;
}

.verification-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Commerce Form */
.commerce-form {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.commerce-form.disabled {
    opacity: 0.7;
    position: relative;
}

/* Form Header */
.form-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-title {
    font-size: 1.75rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-description {
    opacity: 0.9;
    font-size: 1rem;
}

.completion-badge {
    text-align: center;
    position: relative;
}

.completion-circle {
    width: 60px;
    height: 60px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    margin: 0 auto 0.5rem;
    position: relative;
    transition: all 0.3s ease;
}

.completion-circle.near-auto-publish {
    border-color: rgba(255, 255, 255, 0.6);
    background: rgba(255, 255, 255, 0.2);
    animation: pulse-completion 2s infinite;
}

.completion-circle.auto-published {
    border-color: rgba(16, 185, 129, 0.8);
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

@keyframes pulse-completion {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

.completion-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.completion-text {
    font-size: 0.875rem;
    opacity: 0.9;
}

.completion-help-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    backdrop-filter: blur(10px);
}

.completion-help-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-1px);
}

.completion-help-btn span {
    font-weight: 500;
}

/* Completion Help Modal */
.completion-help-modal {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    width: 400px;
    max-height: 80vh;
    overflow-y: auto;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    border: 1px solid var(--border-color);
    margin-top: 1rem;
}

.completion-help-content {
    padding: 0;
}

.help-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 1rem 1rem 0 0;
}

.help-header h4 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.help-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.help-progress {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-light);
}

.overall-progress {
    background: white;
    border-radius: 0.75rem;
    padding: 1rem;
    border: 1px solid var(--border-color);
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.progress-label {
    font-weight: 600;
    color: var(--text-dark);
}

.progress-value {
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.125rem;
}

.progress-bar {
    height: 8px;
    background: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    border-radius: 4px;
    transition: width 0.3s ease;
}

.help-sections {
    padding: 1rem;
    max-height: 400px;
    overflow-y: auto;
}

.help-section {
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    overflow: hidden;
}

.section-header {
    background: var(--bg-light);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border-color);
}

.section-header .section-icon {
    color: var(--primary-color);
    margin-right: 0.5rem;
}

.section-name {
    font-weight: 600;
    color: var(--text-dark);
    flex: 1;
}

.section-progress {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary-color);
    background: rgba(245, 158, 11, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
}

.section-items {
    padding: 0.75rem;
}

.item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    font-size: 0.875rem;
}

.item.completed {
    color: #059669;
}

.item.completed i {
    color: #10b981;
}

.item.pending {
    color: var(--text-light);
}

.item.pending i {
    color: #f59e0b;
}

.help-footer {
    padding: 1.5rem;
    background: var(--bg-light);
    border-top: 1px solid var(--border-color);
}

.help-tips h5 {
    margin: 0 0 0.75rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-tips h5 i {
    color: var(--primary-color);
}

.help-tips ul {
    margin: 0;
    padding-left: 1.25rem;
    list-style: none;
}

.help-tips li {
    font-size: 0.875rem;
    color: var(--text-light);
    margin-bottom: 0.375rem;
    position: relative;
}

.help-tips li::before {
    content: '•';
    color: var(--primary-color);
    position: absolute;
    left: -1rem;
}

/* Auto Publish Alerts */
.auto-publish-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    border: 1px solid;
}

.auto-publish-success {
    background: rgba(16, 185, 129, 0.1);
    border-color: rgba(16, 185, 129, 0.3);
    color: #059669;
}

.auto-publish-warning {
    background: rgba(245, 158, 11, 0.1);
    border-color: rgba(245, 158, 11, 0.3);
    color: #d97706;
}

.auto-publish-info {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.3);
    color: #2563eb;
}

.alert-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    margin-top: 0.125rem;
}

.alert-content h6 {
    margin: 0 0 0.25rem 0;
    font-size: 0.875rem;
    font-weight: 600;
}

.alert-content p {
    margin: 0;
    font-size: 0.8rem;
    opacity: 0.9;
    line-height: 1.4;
}

/* Progress Steps */
.progress-steps {
    display: flex;
    background: var(--bg-light);
    padding: 1rem 2rem;
    gap: 1rem;
    overflow-x: auto;
}

.step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    cursor: pointer;
    white-space: nowrap;
    min-width: fit-content;
    position: relative;
    border: 2px solid transparent;
}

.step.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    transform: translateY(-1px);
}

.step:not(.active) {
    color: var(--text-light);
    background: rgba(255, 255, 255, 0.7);
}

.step:not(.active):hover {
    background: white;
    color: var(--text-dark);
    border-color: var(--primary-color);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.step.completed:not(.active) {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border-color: rgba(16, 185, 129, 0.3);
}

.step.completed:not(.active):hover {
    background: rgba(16, 185, 129, 0.2);
}

.step.completed .step-icon::after {
    content: '✓';
    position: absolute;
    top: -2px;
    right: -2px;
    background: #10b981;
    color: white;
    font-size: 0.6rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    position: relative;
}

.step.has-data .step-icon {
    background: #10b981 !important;
    color: white !important;
}

.step.active.has-data .step-icon {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

/* Form Steps */
.form-step {
    display: none;
    padding: 2rem;
}

.form-step.active {
    display: block;
}

.step-header {
    margin-bottom: 2rem;
    text-align: center;
}

.step-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.step-header p {
    color: var(--text-light);
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* Form Elements */
.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: '*';
    color: #dc2626;
    margin-left: 0.25rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-hint {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-light);
}

/* Character Counter */
.char-counter {
    text-align: right;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-light);
}

/* File Upload */
.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 0.75rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.file-upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(245, 158, 11, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-content i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.file-upload-content p {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.file-upload-content small {
    color: var(--text-light);
}

/* Current File */
.current-file {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-preview {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 0.5rem;
}

/* Images Grid */
.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.image-item img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 0.5rem;
}

/* Form Actions */
.form-actions {
    padding: 2rem;
    background: var(--bg-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

/* Select2 Customization */
.select2-container {
    width: 100% !important;
}

.select2-selection {
    border: 2px solid var(--border-color) !important;
    border-radius: 0.75rem !important;
    padding: 0.75rem 1rem !important;
    font-size: 1rem !important;
    min-height: auto !important;
}

.select2-selection:focus-within {
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .form-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .progress-steps {
        padding: 1rem;
    }
    
    .step span {
        display: none;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .action-buttons {
        width: 100%;
        justify-content: center;
    }
    
    /* Completion Help Modal Responsive */
    .completion-help-modal {
        width: 95vw;
        max-width: 350px;
        right: -50px;
        max-height: 70vh;
    }
    
    .help-sections {
        max-height: 300px;
    }
}

/* === CONTACTOS DINÁMICOS === */
.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 1rem;
    border: 1px solid var(--border-color);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.section-title i {
    color: var(--primary-color);
}

.section-description {
    color: var(--text-light);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

#contactos-dinamicos {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.contacto-item {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    padding: 1rem;
    transition: all 0.2s ease;
}

.contacto-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.contacto-grid {
    display: grid;
    grid-template-columns: 1fr 2fr auto;
    gap: 1rem;
    align-items: end;
}

.contacto-actions {
    display: flex;
    align-items: center;
    justify-content: center;
}

.contacto-actions .btn {
    padding: 0.5rem;
    min-width: auto;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contacto-add-section {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.contacto-add-section .btn {
    margin-bottom: 0.5rem;
}

.contacto-add-section .form-hint {
    display: block;
    color: var(--text-light);
    font-size: 0.875rem;
}

/* Imagen Grid Mejorada */
.images-grid {
    margin-top: 1rem;
}

.images-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.images-title::before {
    content: '📷';
    font-size: 1.2rem;
}

.image-item {
    position: relative;
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.image-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.image-item img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    opacity: 0;
    transition: opacity 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.5rem;
}

.image-item:hover .image-overlay {
    opacity: 1;
}

.image-actions {
    text-align: center;
}

.image-order {
    font-size: 0.75rem;
    font-weight: 600;
    display: block;
    margin-bottom: 0.5rem;
}

.image-delete {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    background: rgba(220, 38, 38, 0.8);
    border-radius: 0.25rem;
    transition: background 0.2s ease;
}

.image-delete:hover {
    background: rgba(220, 38, 38, 1);
}

.image-delete input[type="checkbox"] {
    margin: 0;
}

.images-help {
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 0.5rem;
    border-left: 4px solid var(--primary-color);
}

.images-help .form-hint {
    margin: 0;
    color: var(--text-dark);
}

.images-help i {
    color: var(--primary-color);
    margin-right: 0.25rem;
}

/* Responsive para contactos */
@media (max-width: 768px) {
    .contacto-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .contacto-actions {
        justify-content: flex-end;
    }
    
    .form-section {
        padding: 1rem;
    }
    
    .images-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.75rem;
    }
    
    .image-item img {
        height: 100px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.search-select').select2({
            placeholder: 'Buscar...',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            }
        });
    }

    // Character counters
    function setupCharCounter(textareaId, counterId, maxLength) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(counterId);
        
        if (textarea && counter) {
            function updateCharCount() {
                const count = textarea.value.length;
                counter.textContent = count;
                const percentage = count / maxLength;
                counter.style.color = percentage > 0.9 ? '#dc2626' : percentage > 0.8 ? '#f59e0b' : '#6b7280';
            }
            
            textarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        }
    }
    
    // Setup character counters
    setupCharCounter('descripcionCorta', 'charCountCorta', 500);
    setupCharCounter('contenidoHtml', 'charCountDetallada', 5000);
    setupCharCounter('metaDescripcion', 'charCountMeta', 500);

    // Multi-step form
    let currentStep = 1;
    const totalSteps = 4;
    
    const nextBtn = document.getElementById('nextStep');
    const prevBtn = document.getElementById('prevStep');
    const submitBtn = document.getElementById('submitForm');
    
    function showStep(step) {
        // Validar que el step esté en el rango correcto
        if (step < 1 || step > totalSteps) {
            console.error('Step inválido:', step);
            return;
        }
        
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        
        // Show current step
        const currentFormStep = document.querySelector(`.form-step[data-step="${step}"]`);
        const currentProgressStep = document.querySelector(`.step[data-step="${step}"]`);
        
        if (currentFormStep) {
            currentFormStep.classList.add('active');
        } else {
            console.error('No se encontró form-step para step:', step);
        }
        
        if (currentProgressStep) {
            currentProgressStep.classList.add('active');
        } else {
            console.error('No se encontró progress step para step:', step);
        }
        
        // Update buttons
        if (prevBtn) {
            prevBtn.style.display = step === 1 ? 'none' : 'flex';
        }
        if (nextBtn) {
            nextBtn.style.display = step === totalSteps ? 'none' : 'flex';
        }
        if (submitBtn) {
            submitBtn.style.display = step === totalSteps ? 'flex' : 'none';
        }
        
        // Marcar steps anteriores como completados
        document.querySelectorAll('.step').forEach((s, index) => {
            const stepNum = index + 1;
            if (stepNum < step) {
                s.classList.add('completed');
            } else if (stepNum === step) {
                s.classList.remove('completed');
            }
        });
        
        // Scroll to top of form
        document.querySelector('.commerce-form').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        
        console.log('Mostrando step:', step);
    }
    
    // Función para validar step antes de avanzar (sin validaciones restrictivas)
    function validateCurrentStep() {
        // Todos los campos son opcionales, el usuario puede ir completando gradualmente
        // Solo validamos formato básico si hay datos
        
        switch(currentStep) {
            case 1:
                // Validación opcional de formato
                const titulo = document.getElementById('titulo');
                if (titulo.value.trim() && titulo.value.trim().length < 2) {
                    alert('El nombre del comercio debe tener al menos 2 caracteres');
                    titulo.focus();
                    return false;
                }
                break;
            case 2:
                // Validación opcional de dirección
                const direccion = document.getElementById('direccion');
                if (direccion.value.trim() && direccion.value.trim().length < 10) {
                    alert('La dirección debe tener al menos 10 caracteres');
                    direccion.focus();
                    return false;
                }
                break;
            case 3:
                // Validación opcional de formato de contactos
                const tipos = document.querySelectorAll('select[name="contactos_tipo[]"]');
                const valores = document.querySelectorAll('input[name="contactos_valor[]"]');
                
                for (let i = 0; i < tipos.length; i++) {
                    const tipo = tipos[i].value;
                    const valor = valores[i].value.trim();
                    
                    // Solo validar si ambos campos tienen valor
                    if (tipo && valor) {
                        // Validaciones básicas de formato
                        if (tipo === 'correo' && valor) {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(valor)) {
                                alert('Por favor ingresa un email válido');
                                valores[i].focus();
                                return false;
                            }
                        }
                        
                        if ((tipo === 'telefono' || tipo === 'whatsapp') && valor) {
                            const phoneRegex = /^[\d\s\+\-\(\)]+$/;
                            if (!phoneRegex.test(valor)) {
                                alert('Por favor ingresa un número de teléfono válido');
                                valores[i].focus();
                                return false;
                            }
                        }
                        
                        if (tipo === 'sitioWeb' && valor && !valor.startsWith('http')) {
                            // Auto-corregir URLs sin protocolo
                            valores[i].value = 'https://' + valor;
                        }
                    }
                    
                    // Validar que si hay tipo, también hay valor y viceversa
                    if ((tipo && !valor) || (!tipo && valor)) {
                        alert('Si agregas un contacto, debes completar tanto el tipo como el valor');
                        if (!tipo) tipos[i].focus();
                        else valores[i].focus();
                        return false;
                    }
                }
                break;
            case 4:
                // Sin validaciones restrictivas para multimedia
                break;
        }
        return true;
    }
    
    nextBtn?.addEventListener('click', function() {
        if (validateCurrentStep() && currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });
    
    prevBtn?.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });
    
    // Step navigation - permitir navegación directa solo a steps anteriores o el actual
    document.querySelectorAll('.step').forEach(step => {
        step.addEventListener('click', function() {
            const stepNumber = parseInt(this.dataset.step);
            
            // Permitir ir a steps anteriores sin validación
            if (stepNumber <= currentStep) {
                currentStep = stepNumber;
                showStep(currentStep);
            } else {
                // Para avanzar, validar step actual
                let canAdvance = true;
                let tempStep = currentStep;
                
                // Validar todos los steps intermedios
                while (tempStep < stepNumber && canAdvance) {
                    currentStep = tempStep;
                    canAdvance = validateCurrentStep();
                    if (canAdvance) {
                        tempStep++;
                    }
                }
                
                if (canAdvance) {
                    currentStep = stepNumber;
                    showStep(currentStep);
                } else {
                    // Restaurar currentStep si no se pudo avanzar
                    currentStep = tempStep;
                }
            }
        });
    });
    
    // Función para actualizar indicadores visuales de completitud
    function updateStepCompletionIndicators() {
        // Step 1: Información básica - mostrar indicador si tiene al menos un campo
        const step1Fields = [
            document.getElementById('titulo'),
            document.getElementById('idMarketCategoria'),
            document.getElementById('idMarketTipoComercioServicio'),
            document.getElementById('responsable'),
            document.getElementById('descripcionCorta'),
            document.getElementById('contenidoHtml'),
            document.getElementById('metaTitulo'),
            document.getElementById('metaDescripcion')
        ];
        const step1Complete = step1Fields.some(field => field && field.value.trim());
        
        // Step 2: Ubicación - mostrar indicador si tiene dirección
        const step2Fields = [
            document.getElementById('direccion')
        ];
        const step2Complete = step2Fields.some(field => field && field.value.trim());
        
        // Step 3: Contacto - mostrar indicador si tiene al menos un contacto válido o información administrativa
        const tipos = document.querySelectorAll('select[name="contactos_tipo[]"]');
        const valores = document.querySelectorAll('input[name="contactos_valor[]"]');
        let hasPublicContact = false;
        for (let i = 0; i < tipos.length; i++) {
            if (tipos[i].value && valores[i].value.trim()) {
                hasPublicContact = true;
                break;
            }
        }
        
        const adminFields = [
            document.getElementById('info_nombre'),
            document.getElementById('info_whatsapp'),
            document.getElementById('info_email'),
            document.getElementById('info_comentarios')
        ];
        const hasAdminInfo = adminFields.some(field => field && field.value.trim());
        const step3Complete = hasPublicContact || hasAdminInfo;
        
        // Step 4: Multimedia - mostrar indicador si tiene imagen de portada o imágenes existentes
        const hasCurrentImage = document.querySelector('.current-file') !== null;
        const hasGalleryImages = document.querySelector('.images-grid') !== null;
        const step4Complete = hasCurrentImage || hasGalleryImages;
        
        // Actualizar indicadores visuales
        const completionStates = [step1Complete, step2Complete, step3Complete, step4Complete];
        document.querySelectorAll('.step').forEach((step, index) => {
            const stepIcon = step.querySelector('.step-icon');
            if (completionStates[index]) {
                step.classList.add('has-data');
                stepIcon.style.background = '#10b981';
                stepIcon.style.color = 'white';
            } else {
                step.classList.remove('has-data');
                stepIcon.style.background = '';
                stepIcon.style.color = '';
            }
        });
    }
    
    // Escuchar cambios en campos importantes
    const watchFields = [
        'titulo', 'idMarketCategoria', 'idMarketTipoComercioServicio', 'responsable',
        'descripcionCorta', 'contenidoHtml', 'metaTitulo', 'metaDescripcion',
        'direccion', 'info_nombre', 'info_whatsapp', 'info_email', 'info_comentarios'
    ];
    
    watchFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', updateStepCompletionIndicators);
            field.addEventListener('change', updateStepCompletionIndicators);
        }
    });
    
    // Inicializar el primer step y los indicadores
    showStep(1);
    updateStepCompletionIndicators();

    // === CONTACTOS DINÁMICOS ===
    let contactoIndex = document.querySelectorAll('.contacto-item').length;
    
    // Función para crear nuevo contacto
    function crearNuevoContacto() {
        const contactosContainer = document.getElementById('contactos-dinamicos');
        const nuevoContacto = document.createElement('div');
        nuevoContacto.className = 'contacto-item';
        nuevoContacto.setAttribute('data-index', contactoIndex);
        
        nuevoContacto.innerHTML = `
            <div class="form-grid contacto-grid">
                <div class="form-group">
                    <label class="form-label">Tipo de Contacto</label>
                    <select name="contactos_tipo[]" class="form-select contacto-tipo">
                        <option value="">Seleccionar tipo</option>
                        <option value="telefono">📞 Teléfono</option>
                        <option value="whatsapp">📱 WhatsApp</option>
                        <option value="correo">📧 Correo electrónico</option>
                        <option value="sitioWeb">🌐 Sitio web</option>
                        <option value="facebook">👤 Facebook</option>
                        <option value="instagram">📷 Instagram</option>
                        <option value="tiktok">🎵 TikTok</option>
                        <option value="twitter">🐦 Twitter (X)</option>
                        <option value="linkedin">💼 LinkedIn</option>
                        <option value="youtube">📺 YouTube</option>
                        <option value="telegram">✈️ Telegram</option>
                        <option value="pinterest">📌 Pinterest</option>
                        <option value="snapchat">👻 Snapchat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Valor del Contacto</label>
                    <input type="text" 
                           name="contactos_valor[]" 
                           class="form-input contacto-valor"
                           placeholder="Ingresa el valor del contacto">
                </div>
                <div class="form-group contacto-actions">
                    <button type="button" class="btn btn-danger btn-sm eliminar-contacto">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        contactosContainer.appendChild(nuevoContacto);
        contactoIndex++;
        
        // Agregar event listener al botón eliminar del nuevo contacto
        nuevoContacto.querySelector('.eliminar-contacto').addEventListener('click', function() {
            eliminarContacto(nuevoContacto);
        });
        
        // Agregar event listener al select para actualizar placeholder
        nuevoContacto.querySelector('.contacto-tipo').addEventListener('change', function() {
            actualizarPlaceholder(this);
            updateStepCompletionIndicators();
        });
        
        // Agregar event listener al input para actualizar indicadores
        nuevoContacto.querySelector('.contacto-valor').addEventListener('input', function() {
            updateStepCompletionIndicators();
        });
    }
    
    // Función para eliminar contacto
    function eliminarContacto(contactoElement) {
        const contactosContainer = document.getElementById('contactos-dinamicos');
        const contactos = contactosContainer.querySelectorAll('.contacto-item');
        
        // No permitir eliminar si es el único contacto
        if (contactos.length > 1) {
            contactoElement.remove();
        } else {
            // Si es el único, limpiar los valores en lugar de eliminar
            contactoElement.querySelector('.contacto-tipo').value = '';
            contactoElement.querySelector('.contacto-valor').value = '';
        }
        
        // Actualizar indicadores después de eliminar
        updateStepCompletionIndicators();
    }
    
    // Función para actualizar placeholder según el tipo de contacto
    function actualizarPlaceholder(selectElement) {
        const contactoItem = selectElement.closest('.contacto-item');
        const inputValor = contactoItem.querySelector('.contacto-valor');
        const tipo = selectElement.value;
        
        const placeholders = {
            'telefono': 'Ej: +57 300 123 4567',
            'whatsapp': 'Ej: +57 300 123 4567',
            'correo': 'Ej: contacto@comercio.com',
            'sitioWeb': 'Ej: https://www.micomercio.com',
            'facebook': 'Ej: https://facebook.com/micomercio',
            'instagram': 'Ej: https://instagram.com/micomercio',
            'tiktok': 'Ej: https://tiktok.com/@micomercio',
            'twitter': 'Ej: https://twitter.com/micomercio',
            'linkedin': 'Ej: https://linkedin.com/company/micomercio',
            'youtube': 'Ej: https://youtube.com/c/micomercio',
            'telegram': 'Ej: https://t.me/micomercio',
            'pinterest': 'Ej: https://pinterest.com/micomercio',
            'snapchat': 'Ej: https://snapchat.com/add/micomercio'
        };
        
        inputValor.placeholder = placeholders[tipo] || 'Ingresa el valor del contacto';
    }
    
    // Event listeners para contactos dinámicos
    document.getElementById('agregar-contacto')?.addEventListener('click', crearNuevoContacto);
    
    // Agregar event listeners a contactos existentes
    document.querySelectorAll('.eliminar-contacto').forEach(btn => {
        btn.addEventListener('click', function() {
            const contactoItem = this.closest('.contacto-item');
            eliminarContacto(contactoItem);
        });
    });
    
    // Agregar event listeners a selects existentes
    document.querySelectorAll('.contacto-tipo').forEach(select => {
        select.addEventListener('change', function() {
            actualizarPlaceholder(this);
            updateStepCompletionIndicators();
        });
        // Actualizar placeholder inicial
        actualizarPlaceholder(select);
    });
    
    // Agregar event listeners a inputs existentes
    document.querySelectorAll('.contacto-valor').forEach(input => {
        input.addEventListener('input', function() {
            updateStepCompletionIndicators();
        });
    });

    // File upload preview
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function() {
            const area = this.closest('.file-upload-area');
            const content = area.querySelector('.file-upload-content');
            
            if (this.files.length > 0) {
                if (this.multiple) {
                    content.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <p>${this.files.length} archivo(s) seleccionado(s)</p>
                    `;
                } else {
                    content.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <p>${this.files[0].name}</p>
                    `;
                }
            }
        });
    });
    
    // Validación antes de enviar (solo validaciones de formato, no de campos obligatorios)
    document.getElementById('comercioForm')?.addEventListener('submit', function(e) {
        // Validar duplicados en contactos
        const tipos = document.querySelectorAll('select[name="contactos_tipo[]"]');
        const valores = document.querySelectorAll('input[name="contactos_valor[]"]');
        const contactosMap = new Map();
        let tieneDuplicados = false;
        
        for (let i = 0; i < tipos.length; i++) {
            const tipo = tipos[i].value;
            const valor = valores[i].value.trim();
            
            if (tipo && valor) {
                const key = `${tipo}:${valor}`;
                if (contactosMap.has(key)) {
                    tieneDuplicados = true;
                    break;
                }
                contactosMap.set(key, true);
            }
        }
        
        if (tieneDuplicados) {
            e.preventDefault();
            alert('No puedes tener contactos duplicados (mismo tipo y valor).');
            return false;
        }
        
        // Validar que los contactos que tengan tipo también tengan valor y viceversa
        for (let i = 0; i < tipos.length; i++) {
            const tipo = tipos[i].value;
            const valor = valores[i].value.trim();
            
            if ((tipo && !valor) || (!tipo && valor)) {
                e.preventDefault();
                alert('Si agregas un contacto, debes completar tanto el tipo como el valor.');
                return false;
            }
        }
        
        // Log de datos del formulario antes de enviar
        const formData = new FormData(this);
        console.log('Datos del formulario:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ':', value);
        }
        console.log('Formulario enviado correctamente');
    });
});

// Función para mostrar/ocultar el modal de ayuda de completitud
function toggleCompletionHelp() {
    const modal = document.getElementById('completion-help-modal');
    if (modal) {
        const isVisible = modal.style.display !== 'none';
        modal.style.display = isVisible ? 'none' : 'block';
        
        // Cerrar modal al hacer clic fuera
        if (!isVisible) {
            document.addEventListener('click', function closeModal(e) {
                if (!modal.contains(e.target) && !e.target.closest('.completion-help-btn')) {
                    modal.style.display = 'none';
                    document.removeEventListener('click', closeModal);
                }
            });
        }
    }
}

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('completion-help-modal');
        if (modal && modal.style.display !== 'none') {
            modal.style.display = 'none';
        }
    }
});
</script>
@endsection