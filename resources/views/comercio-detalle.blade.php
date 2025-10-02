@extends('layouts.public')

@section('title', $comercio->titulo . ' - Puente Local Colombia')
@section('description', Str::limit($comercio->descripcionCorta, 160))

@section('content')
<!-- Header Section -->
<section class="comercio-header">
    <div class="header-background">
        @if($comercio->rutaPortada)
            <img src="{{ asset('storage/' . $comercio->rutaPortada) }}" alt="{{ $comercio->titulo }}" class="header-bg-img">
        @elseif($comercio->imagenes->first())
            <img src="{{ asset('storage/' . $comercio->imagenes->first()->rutaImagen) }}" alt="{{ $comercio->titulo }}" class="header-bg-img">
        @endif
        <div class="header-overlay"></div>
    </div>
    
    <div class="container">
        <div class="header-content" data-aos="fade-up">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Inicio</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('comercios') }}">Comercios</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $comercio->titulo }}</span>
            </nav>

            <div class="comercio-main-info">
                <div class="comercio-logo">
                    @if($comercio->rutaPortada)
                        <img src="{{ asset('storage/' . $comercio->rutaPortada) }}" alt="{{ $comercio->titulo }}">
                    @elseif($comercio->imagenes->first())
                        <img src="{{ asset('storage/' . $comercio->imagenes->first()->rutaImagen) }}" alt="{{ $comercio->titulo }}">
                    @else
                        <div class="placeholder-logo">
                            <i class="fas fa-store"></i>
                        </div>
                    @endif
                </div>

                <div class="comercio-details">
                    <h1 class="comercio-name">{{ $comercio->titulo }}</h1>
                    
                    @if($comercio->categoria)
                        <span class="comercio-category">
                            <i class="fas fa-tags"></i>
                            {{ $comercio->categoria->nombre }}
                        </span>
                    @endif

                    <p class="comercio-description">{{ $comercio->descripcionCorta }}</p>

                    <div class="comercio-quick-actions">
                        @if($comercio->datosContacto && $comercio->datosContacto->telefono)
                            @php
                                $telefonos = explode(',', $comercio->datosContacto->telefono);
                            @endphp
                            @foreach($telefonos as $index => $telefono)
                                @php $telefono = trim($telefono); @endphp
                                @if($telefono)
                                    <a href="tel:{{ $telefono }}" class="btn btn-primary">
                                        <i class="fas fa-phone"></i>
                                        {{ count($telefonos) > 1 ? 'Llamar ' . ($index + 1) : 'Llamar' }}
                                    </a>
                                @endif
                            @endforeach
                        @endif

                        @if($comercio->datosContacto && $comercio->datosContacto->whatsapp)
                            @php
                                $whatsapps = explode(',', $comercio->datosContacto->whatsapp);
                            @endphp
                            @foreach($whatsapps as $index => $whatsapp)
                                @php $whatsapp = trim($whatsapp); @endphp
                                @if($whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                                       target="_blank" class="btn btn-success">
                                        <i class="fab fa-whatsapp"></i>
                                        {{ count($whatsapps) > 1 ? 'WhatsApp ' . ($index + 1) : 'WhatsApp' }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="comercio-content py-8">
    <div class="container">
        <div class="content-grid">
            <!-- Left Column -->
            <div class="content-main">
                <!-- Gallery Section -->
                @if($comercio->imagenes->count() > 1)
                <div class="section-card" data-aos="fade-up">
                    <h2 class="section-title">
                        <i class="fas fa-images"></i>
                        Galería de imágenes
                    </h2>
                    <div class="gallery-grid">
                        @foreach($comercio->imagenes as $imagen)
                            <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $imagen->rutaImagen) }}')">
                                <img src="{{ asset('storage/' . $imagen->rutaImagen) }}" alt="{{ $comercio->titulo }}" loading="lazy">
                                <div class="gallery-overlay">
                                    <i class="fas fa-expand"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description Section -->
                <div class="section-card" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Información detallada
                    </h2>
                    <div class="description-content">
                        @if($comercio->informacion && $comercio->informacion->descripcionDetallada)
                            <p>{{ $comercio->informacion->descripcionDetallada }}</p>
                        @else
                            <p>{{ $comercio->descripcionCorta }}</p>
                        @endif

                        @if($comercio->informacion)
                            @if($comercio->informacion->horarios)
                                <div class="info-item">
                                    <h3><i class="fas fa-clock"></i> Horarios de atención</h3>
                                    <p>{{ $comercio->informacion->horarios }}</p>
                                </div>
                            @endif

                            @if($comercio->informacion->serviciosOferece)
                                <div class="info-item">
                                    <h3><i class="fas fa-list"></i> Servicios que ofrece</h3>
                                    <p>{{ $comercio->informacion->serviciosOferece }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Contact Methods -->
                @if($comercio->contactos->count() > 0)
                <div class="section-card" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="section-title">
                        <i class="fas fa-address-book"></i>
                        Formas de contacto
                    </h2>
                    <div class="contact-methods">
                        @foreach($comercio->contactos as $contacto)
                            <div class="contact-item">
                                <div class="contact-icon">
                                    @switch($contacto->tipoContacto)
                                        @case('telefono')
                                            <i class="fas fa-phone"></i>
                                            @break
                                        @case('whatsapp')
                                            <i class="fab fa-whatsapp"></i>
                                            @break
                                        @case('email')
                                            <i class="fas fa-envelope"></i>
                                            @break
                                        @case('facebook')
                                            <i class="fab fa-facebook"></i>
                                            @break
                                        @case('instagram')
                                            <i class="fab fa-instagram"></i>
                                            @break
                                        @default
                                            <i class="fas fa-link"></i>
                                    @endswitch
                                </div>
                                <div class="contact-info">
                                    <h4>{{ ucfirst($contacto->tipoContacto) }}</h4>
                                    @if(in_array($contacto->tipoContacto, ['telefono', 'whatsapp']))
                                        <a href="{{ $contacto->tipoContacto === 'whatsapp' ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $contacto->valor) : 'tel:' . $contacto->valor }}">
                                            {{ $contacto->valor }}
                                        </a>
                                    @elseif($contacto->tipoContacto === 'email')
                                        <a href="mailto:{{ $contacto->valor }}">{{ $contacto->valor }}</a>
                                    @else
                                        <a href="{{ $contacto->valor }}" target="_blank">{{ $contacto->valor }}</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Comments Section -->
                @if($comercio->comentarios->where('aprobado', 1)->count() > 0)
                <div class="section-card" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="section-title">
                        <i class="fas fa-comments"></i>
                        Comentarios de clientes
                    </h2>
                    <div class="comments-list">
                        @foreach($comercio->comentarios->where('aprobado', 1)->take(5) as $comentario)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-author">
                                        <div class="author-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="author-info">
                                            <h4>{{ $comentario->nombreCliente ?? 'Cliente' }}</h4>
                                            <span class="comment-date">{{ $comentario->fechaComentario ? \Carbon\Carbon::parse($comentario->fechaComentario)->format('d/m/Y') : '' }}</span>
                                        </div>
                                    </div>
                                    @if($comentario->calificacion)
                                        <div class="comment-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $comentario->calificacion ? 'active' : '' }}"></i>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                                <p class="comment-text">{{ $comentario->comentario }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="content-sidebar">
                <!-- Contact Card -->
                <div class="sidebar-card" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="card-title">
                        <i class="fas fa-info"></i>
                        Información de contacto
                    </h3>
                    
                    @if($comercio->datosContacto)
                        @if($comercio->datosContacto->telefono)
                            <div class="contact-detail">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <span class="label">Teléfono{{ str_contains($comercio->datosContacto->telefono, ',') ? 's' : '' }}</span>
                                    @php
                                        $telefonos = explode(',', $comercio->datosContacto->telefono);
                                    @endphp
                                    @foreach($telefonos as $telefono)
                                        @php $telefono = trim($telefono); @endphp
                                        @if($telefono)
                                            <a href="tel:{{ $telefono }}" class="contact-link">
                                                {{ $telefono }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->whatsapp)
                            <div class="contact-detail">
                                <i class="fab fa-whatsapp"></i>
                                <div>
                                    <span class="label">WhatsApp</span>
                                    @php
                                        $whatsapps = explode(',', $comercio->datosContacto->whatsapp);
                                    @endphp
                                    @foreach($whatsapps as $whatsapp)
                                        @php $whatsapp = trim($whatsapp); @endphp
                                        @if($whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                                               target="_blank" class="contact-link">
                                                {{ $whatsapp }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->correo)
                            <div class="contact-detail">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <span class="label">Email{{ str_contains($comercio->datosContacto->correo, ',') ? 's' : '' }}</span>
                                    @php
                                        $correos = explode(',', $comercio->datosContacto->correo);
                                    @endphp
                                    @foreach($correos as $correo)
                                        @php $correo = trim($correo); @endphp
                                        @if($correo)
                                            <a href="mailto:{{ $correo }}" class="contact-link">
                                                {{ $correo }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->sitioWeb)
                            <div class="contact-detail">
                                <i class="fas fa-globe"></i>
                                <div>
                                    <span class="label">Sitio{{ str_contains($comercio->datosContacto->sitioWeb, ',') ? 's' : '' }} Web</span>
                                    @php
                                        $sitiosWeb = explode(',', $comercio->datosContacto->sitioWeb);
                                    @endphp
                                    @foreach($sitiosWeb as $index => $sitioWeb)
                                        @php 
                                            $sitioWeb = trim($sitioWeb);
                                            // Normalize website URL
                                            if (!empty($sitioWeb)) {
                                                if (!preg_match('/^https?:\/\//', $sitioWeb)) {
                                                    $sitioWeb = 'https://' . $sitioWeb;
                                                }
                                            }
                                        @endphp
                                        @if($sitioWeb)
                                            <a href="{{ $sitioWeb }}" target="_blank" class="contact-link">
                                                {{ count($sitiosWeb) > 1 ? 'Sitio ' . ($index + 1) : 'Visitar sitio web' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->facebook)
                            <div class="contact-detail">
                                <i class="fab fa-facebook"></i>
                                <div>
                                    <span class="label">Facebook</span>
                                    @php
                                        $facebooks = explode(',', $comercio->datosContacto->facebook);
                                    @endphp
                                    @foreach($facebooks as $index => $facebook)
                                        @php 
                                            $facebook = trim($facebook);
                                            // Normalize Facebook URL
                                            if (!empty($facebook)) {
                                                if (!preg_match('/^https?:\/\//', $facebook)) {
                                                    if (strpos($facebook, 'facebook.com') === false) {
                                                        $facebook = 'https://facebook.com/' . ltrim($facebook, '@/');
                                                    } else {
                                                        $facebook = 'https://' . $facebook;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($facebook)
                                            <a href="{{ $facebook }}" target="_blank" class="contact-link">
                                                {{ count($facebooks) > 1 ? 'Facebook ' . ($index + 1) : 'Síguenos en Facebook' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->instagram)
                            <div class="contact-detail">
                                <i class="fab fa-instagram"></i>
                                <div>
                                    <span class="label">Instagram</span>
                                    @php
                                        $instagrams = explode(',', $comercio->datosContacto->instagram);
                                    @endphp
                                    @foreach($instagrams as $index => $instagram)
                                        @php 
                                            $instagram = trim($instagram);
                                            // Normalize Instagram URL
                                            if (!empty($instagram)) {
                                                if (!preg_match('/^https?:\/\//', $instagram)) {
                                                    if (strpos($instagram, 'instagram.com') === false) {
                                                        $instagram = 'https://instagram.com/' . ltrim($instagram, '@/');
                                                    } else {
                                                        $instagram = 'https://' . $instagram;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($instagram)
                                            <a href="{{ $instagram }}" target="_blank" class="contact-link">
                                                {{ count($instagrams) > 1 ? 'Instagram ' . ($index + 1) : 'Síguenos en Instagram' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->tiktok)
                            <div class="contact-detail">
                                <i class="fab fa-tiktok"></i>
                                <div>
                                    <span class="label">TikTok</span>
                                    @php
                                        $tiktoks = explode(',', $comercio->datosContacto->tiktok);
                                    @endphp
                                    @foreach($tiktoks as $index => $tiktok)
                                        @php $tiktok = trim($tiktok); @endphp
                                        @if($tiktok)
                                            <a href="{{ $tiktok }}" target="_blank" class="contact-link">
                                                {{ count($tiktoks) > 1 ? 'TikTok ' . ($index + 1) : 'Síguenos en TikTok' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->twitter)
                            <div class="contact-detail">
                                <i class="fab fa-twitter"></i>
                                <div>
                                    <span class="label">Twitter</span>
                                    @php
                                        $twitters = explode(',', $comercio->datosContacto->twitter);
                                    @endphp
                                    @foreach($twitters as $index => $twitter)
                                        @php $twitter = trim($twitter); @endphp
                                        @if($twitter)
                                            <a href="{{ $twitter }}" target="_blank" class="contact-link">
                                                {{ count($twitters) > 1 ? 'Twitter ' . ($index + 1) : 'Síguenos en Twitter' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->linkedin)
                            <div class="contact-detail">
                                <i class="fab fa-linkedin"></i>
                                <div>
                                    <span class="label">LinkedIn</span>
                                    @php
                                        $linkedins = explode(',', $comercio->datosContacto->linkedin);
                                    @endphp
                                    @foreach($linkedins as $index => $linkedin)
                                        @php $linkedin = trim($linkedin); @endphp
                                        @if($linkedin)
                                            <a href="{{ $linkedin }}" target="_blank" class="contact-link">
                                                {{ count($linkedins) > 1 ? 'LinkedIn ' . ($index + 1) : 'Conecta en LinkedIn' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->youtube)
                            <div class="contact-detail">
                                <i class="fab fa-youtube"></i>
                                <div>
                                    <span class="label">YouTube</span>
                                    @php
                                        $youtubes = explode(',', $comercio->datosContacto->youtube);
                                    @endphp
                                    @foreach($youtubes as $index => $youtube)
                                        @php $youtube = trim($youtube); @endphp
                                        @if($youtube)
                                            <a href="{{ $youtube }}" target="_blank" class="contact-link">
                                                {{ count($youtubes) > 1 ? 'YouTube ' . ($index + 1) : 'Ver en YouTube' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->telegram)
                            <div class="contact-detail">
                                <i class="fab fa-telegram"></i>
                                <div>
                                    <span class="label">Telegram</span>
                                    @php
                                        $telegrams = explode(',', $comercio->datosContacto->telegram);
                                    @endphp
                                    @foreach($telegrams as $index => $telegram)
                                        @php $telegram = trim($telegram); @endphp
                                        @if($telegram)
                                            <a href="{{ $telegram }}" target="_blank" class="contact-link">
                                                {{ count($telegrams) > 1 ? 'Telegram ' . ($index + 1) : 'Conecta por Telegram' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->pinterest)
                            <div class="contact-detail">
                                <i class="fab fa-pinterest"></i>
                                <div>
                                    <span class="label">Pinterest</span>
                                    @php
                                        $pinterests = explode(',', $comercio->datosContacto->pinterest);
                                    @endphp
                                    @foreach($pinterests as $index => $pinterest)
                                        @php $pinterest = trim($pinterest); @endphp
                                        @if($pinterest)
                                            <a href="{{ $pinterest }}" target="_blank" class="contact-link">
                                                {{ count($pinterests) > 1 ? 'Pinterest ' . ($index + 1) : 'Síguenos en Pinterest' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($comercio->datosContacto->snapchat)
                            <div class="contact-detail">
                                <i class="fab fa-snapchat"></i>
                                <div>
                                    <span class="label">Snapchat</span>
                                    @php
                                        $snapchats = explode(',', $comercio->datosContacto->snapchat);
                                    @endphp
                                    @foreach($snapchats as $index => $snapchat)
                                        @php $snapchat = trim($snapchat); @endphp
                                        @if($snapchat)
                                            <a href="{{ $snapchat }}" target="_blank" class="contact-link">
                                                {{ count($snapchats) > 1 ? 'Snapchat ' . ($index + 1) : 'Agréganos en Snapchat' }}
                                            </a>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    @if($comercio->informacion && $comercio->informacion->direccion)
                        <div class="contact-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="label">Dirección</span>
                                <span>{{ $comercio->informacion->direccion }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions Card -->
                <div class="sidebar-card" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Acciones rápidas
                    </h3>
                    
                    <div class="action-buttons">
                        @if($comercio->datosContacto && $comercio->datosContacto->telefono)
                            @php
                                $telefonos = explode(',', $comercio->datosContacto->telefono);
                            @endphp
                            @foreach($telefonos as $index => $telefono)
                                @php $telefono = trim($telefono); @endphp
                                @if($telefono)
                                    <a href="tel:{{ $telefono }}" class="action-btn btn-primary">
                                        <i class="fas fa-phone"></i>
                                        {{ count($telefonos) > 1 ? 'Llamar ' . ($index + 1) : 'Llamar ahora' }}
                                    </a>
                                @endif
                            @endforeach
                        @endif

                        @if($comercio->datosContacto && $comercio->datosContacto->whatsapp)
                            @php
                                $whatsapps = explode(',', $comercio->datosContacto->whatsapp);
                            @endphp
                            @foreach($whatsapps as $index => $whatsapp)
                                @php $whatsapp = trim($whatsapp); @endphp
                                @if($whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                                       target="_blank" class="action-btn btn-success">
                                        <i class="fab fa-whatsapp"></i>
                                        {{ count($whatsapps) > 1 ? 'WhatsApp ' . ($index + 1) : 'Enviar WhatsApp' }}
                                    </a>
                                @endif
                            @endforeach
                        @endif

                        @if($comercio->informacion && $comercio->informacion->direccion)
                            <a href="https://maps.google.com/?q={{ urlencode($comercio->informacion->direccion . ', Puente Nacional, Santander') }}" 
                               target="_blank" class="action-btn btn-info">
                                <i class="fas fa-map-marker-alt"></i>
                                Ver en Google Maps
                            </a>
                        @endif

                        @if($comercio->datosContacto && $comercio->datosContacto->sitioWeb)
                            @php
                                $sitiosWeb = explode(',', $comercio->datosContacto->sitioWeb);
                                $sitioWebPrincipal = trim($sitiosWeb[0]);
                                
                                // Normalize website URL
                                if (!empty($sitioWebPrincipal)) {
                                    if (!preg_match('/^https?:\/\//', $sitioWebPrincipal)) {
                                        $sitioWebPrincipal = 'https://' . $sitioWebPrincipal;
                                    }
                                }
                            @endphp
                            <a href="{{ $sitioWebPrincipal }}" target="_blank" class="action-btn btn-secondary">
                                <i class="fas fa-globe"></i>
                                Visitar Sitio Web
                            </a>
                        @endif

                        @if($comercio->datosContacto && $comercio->datosContacto->facebook)
                            @php
                                $facebooks = explode(',', $comercio->datosContacto->facebook);
                                $facebookPrincipal = trim($facebooks[0]);
                                
                                // Normalize Facebook URL
                                if (!empty($facebookPrincipal)) {
                                    if (!preg_match('/^https?:\/\//', $facebookPrincipal)) {
                                        if (strpos($facebookPrincipal, 'facebook.com') === false) {
                                            $facebookPrincipal = 'https://facebook.com/' . ltrim($facebookPrincipal, '@/');
                                        } else {
                                            $facebookPrincipal = 'https://' . $facebookPrincipal;
                                        }
                                    }
                                }
                            @endphp
                            <a href="{{ $facebookPrincipal }}" target="_blank" class="action-btn btn-facebook">
                                <i class="fab fa-facebook"></i>
                                Síguenos en Facebook
                            </a>
                        @endif

                        @if($comercio->datosContacto && $comercio->datosContacto->instagram)
                            @php
                                $instagrams = explode(',', $comercio->datosContacto->instagram);
                                $instagramPrincipal = trim($instagrams[0]);
                                
                                // Normalize Instagram URL
                                if (!empty($instagramPrincipal)) {
                                    if (!preg_match('/^https?:\/\//', $instagramPrincipal)) {
                                        if (strpos($instagramPrincipal, 'instagram.com') === false) {
                                            $instagramPrincipal = 'https://instagram.com/' . ltrim($instagramPrincipal, '@/');
                                        } else {
                                            $instagramPrincipal = 'https://' . $instagramPrincipal;
                                        }
                                    }
                                }
                            @endphp
                            <a href="{{ $instagramPrincipal }}" target="_blank" class="action-btn btn-instagram">
                                <i class="fab fa-instagram"></i>
                                Síguenos en Instagram
                            </a>
                        @endif

                        <button onclick="shareComercio()" class="action-btn btn-outline">
                            <i class="fas fa-share-alt"></i>
                            Compartir
                        </button>
                    </div>
                </div>

                <!-- Back to List -->
                <div class="sidebar-card" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('comercios') }}" class="btn btn-outline btn-block">
                        <i class="fas fa-arrow-left"></i>
                        Volver a comercios
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <div class="lightbox-content">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightbox-img" src="" alt="">
    </div>
</div>

<style>
/* Header Section */
.comercio-header {
    position: relative;
    padding: 8rem 0 4rem;
    overflow: hidden;
}

.header-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.header-bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: blur(2px);
}

.header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(55, 65, 81, 0.6) 100%);
}

.header-content {
    position: relative;
    z-index: 2;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: var(--primary-color);
}

.breadcrumb i {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.75rem;
}

.breadcrumb span {
    color: white;
    font-weight: 600;
}

.comercio-main-info {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

.comercio-logo {
    width: 120px;
    height: 120px;
    border-radius: 1rem;
    overflow: hidden;
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    flex-shrink: 0;
}

.comercio-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-logo {
    width: 100%;
    height: 100%;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--text-light);
}

.comercio-details {
    flex: 1;
    color: white;
}

.comercio-name {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: white;
}

.comercio-category {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.comercio-description {
    font-size: 1.125rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.comercio-quick-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-info {
    background: #3b82f6;
    color: white;
}

.btn-info:hover {
    background: #2563eb;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    align-items: start;
}

.section-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--bg-light);
}

.section-title i {
    color: var(--primary-color);
}

/* Gallery */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.gallery-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 0.5rem;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.05);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay i {
    color: white;
    font-size: 1.5rem;
}

/* Description Content */
.description-content {
    line-height: 1.8;
    color: var(--text-dark);
}

.info-item {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.info-item h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.info-item h3 i {
    color: var(--primary-color);
}

/* Contact Methods */
.contact-methods {
    display: grid;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 0.75rem;
    border: 1px solid var(--border-color);
}

.contact-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.contact-info h4 {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.contact-info a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-info a:hover {
    color: var(--primary-dark);
}

/* Comments */
.comments-list {
    display: grid;
    gap: 1.5rem;
}

.comment-item {
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 0.75rem;
    border: 1px solid var(--border-color);
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.comment-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.author-info h4 {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.comment-date {
    font-size: 0.875rem;
    color: var(--text-light);
}

.comment-rating {
    display: flex;
    gap: 0.25rem;
}

.comment-rating i {
    color: #d1d5db;
    font-size: 0.875rem;
}

.comment-rating i.active {
    color: #fbbf24;
}

.comment-text {
    color: var(--text-dark);
    line-height: 1.6;
}

/* Sidebar */
.sidebar-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    position: sticky;
    top: 90px;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.card-title i {
    color: var(--primary-color);
}

.contact-detail {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.contact-detail i {
    color: var(--primary-color);
    font-size: 1.125rem;
    width: 20px;
    margin-top: 0.125rem;
}

.contact-detail .label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 0.25rem;
}

.contact-detail a,
.contact-detail span {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-detail a:hover {
    color: var(--primary-color);
}

.action-buttons {
    display: grid;
    gap: 0.75rem;
}

.action-btn {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-btn.btn-primary {
    background: var(--primary-color);
    color: white;
}

.action-btn.btn-primary:hover {
    background: var(--primary-dark);
}

.action-btn.btn-success {
    background: #10b981;
    color: white;
}

.action-btn.btn-success:hover {
    background: #059669;
}

.action-btn.btn-info {
    background: #3b82f6;
    color: white;
}

.action-btn.btn-info:hover {
    background: #2563eb;
}

.action-btn.btn-outline {
    background: transparent;
    color: var(--text-dark);
    border-color: var(--border-color);
}

.action-btn.btn-outline:hover {
    background: var(--bg-light);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
}

.lightbox-content {
    position: relative;
    margin: auto;
    padding: 20px;
    width: 90%;
    max-width: 800px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.lightbox-close:hover {
    color: var(--primary-color);
}

#lightbox-img {
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .sidebar-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .comercio-header {
        padding: 6rem 0 3rem;
    }

    .comercio-main-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .comercio-logo {
        width: 100px;
        height: 100px;
    }

    .comercio-name {
        font-size: 2rem;
    }

    .comercio-quick-actions {
        justify-content: center;
    }

    .section-card {
        padding: 1.5rem;
    }

    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }

    .contact-item {
        padding: 0.75rem;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .comercio-header {
        padding: 5rem 0 2rem;
    }

    .comercio-name {
        font-size: 1.75rem;
    }

    .comercio-quick-actions {
        flex-direction: column;
    }

    .section-title {
        font-size: 1.25rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Badge para múltiples contactos */
.badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.125rem 0.375rem;
    border-radius: 0.5rem;
    margin-left: 0.25rem;
}

/* Mejoras para enlaces de contacto múltiples */
.contact-link {
    display: inline-block;
    margin-bottom: 0.25rem;
    padding: 0.25rem 0;
    border-bottom: 1px solid transparent;
    transition: all 0.3s ease;
}

.contact-link:hover {
    border-bottom-color: var(--primary-color);
    transform: translateX(2px);
}

/* Estilo mejorado para múltiples números */
.contact-detail div {
    line-height: 1.6;
}

.contact-detail .label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

/* Hover effects para botones de acción rápida */
.comercio-quick-actions .btn {
    position: relative;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.comercio-quick-actions .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.comercio-quick-actions .btn:hover::before {
    left: 100%;
}

/* Mejoras para múltiples botones de contacto */
.comercio-quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.action-buttons {
    display: grid;
    gap: 0.75rem;
}

.action-buttons .action-btn {
    margin-bottom: 0;
}

/* Estilos para indicadores de múltiples contactos */
.btn-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-facebook {
    background: #1877f2;
    color: white;
}

.btn-facebook:hover {
    background: #166fe5;
}

.btn-instagram {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    color: white;
}

.btn-instagram:hover {
    background: linear-gradient(45deg, #e6683c 0%, #dc2743 25%, #cc2366 50%, #bc1888 75%, #a51890 100%);
}

.btn-twitter {
    background: #1da1f2;
    color: white;
}

.btn-twitter:hover {
    background: #0d8bd9;
}

.btn-linkedin {
    background: #0077b5;
    color: white;
}

.btn-linkedin:hover {
    background: #006ba1;
}

.btn-youtube {
    background: #ff0000;
    color: white;
}

.btn-youtube:hover {
    background: #cc0000;
}

.btn-tiktok {
    background: #000000;
    color: white;
}

.btn-tiktok:hover {
    background: #333333;
}

.btn-telegram {
    background: #0088cc;
    color: white;
}

.btn-telegram:hover {
    background: #0077b3;
}

/* Responsive para múltiples botones */
@media (max-width: 768px) {
    .comercio-quick-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .comercio-quick-actions .btn {
        width: 100%;
        text-align: center;
    }
}

}    .action-buttons {
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>

@push('scripts')
<script>
function openLightbox(imageSrc) {
    document.getElementById('lightbox').style.display = 'block';
    document.getElementById('lightbox-img').src = imageSrc;
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function shareComercio() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $comercio->titulo }} - Puente Local Colombia',
            text: '{{ Str::limit($comercio->descripcionCorta, 100) }}',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que no soportan Web Share API
        const url = window.location.href;
        const title = '{{ $comercio->titulo }} - Puente Local Colombia';
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Enlace copiado al portapapeles');
            });
        } else {
            // Fallback más básico
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Enlace copiado al portapapeles');
        }
    }
}

// Cerrar lightbox con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>
@endpush
@endsection