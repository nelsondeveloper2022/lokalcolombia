<div class="comercio-card">
    <div class="comercio-image">
        @if(!empty($comercio->rutaPortada))
            @php
                $portada = Str::startsWith($comercio->rutaPortada, ['http://','https://','/storage/'])
                    ? $comercio->rutaPortada
                    : Storage::url($comercio->rutaPortada);
            @endphp
            <img src="{{ $portada }}" alt="{{ $comercio->titulo }}" loading="lazy">
        @elseif($comercio->imagenes && $comercio->imagenes->first())
            <img src="{{ $comercio->imagenes->first()->rutaImagen }}" alt="{{ $comercio->titulo }}" loading="lazy">
        @else
            <div class="placeholder-image">
                <i class="fas fa-store"></i>
            </div>
        @endif
        
        @if($comercio->categoria)
            <span class="comercio-category">{{ $comercio->categoria->nombre }}</span>
        @endif

        <div class="comercio-overlay">
            <a href="{{ route('comercio.detalle', $comercio->slug) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i>
                Ver detalles
            </a>
        </div>
    </div>

    <div class="comercio-content">
        <h3 class="comercio-name">{{ $comercio->titulo }}</h3>
        
        <p class="comercio-description">
            {{ Str::limit($comercio->descripcionCorta, 100) }}
        </p>

        <div class="comercio-info">
            @if($comercio->informacion && $comercio->informacion->direccion)
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ Str::limit($comercio->informacion->direccion, 30) }}</span>
                </div>
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->telefono)
                @php
                    $telefonos = explode(',', $comercio->datosContacto->telefono);
                @endphp
                @foreach($telefonos as $index => $telefono)
                    @php $telefono = trim($telefono); @endphp
                    @if($telefono)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ $telefono }}">
                                {{ count($telefonos) > 1 ? 'Tel ' . ($index + 1) . ': ' : '' }}{{ $telefono }}
                            </a>
                        </div>
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
                        <div class="info-item">
                            <i class="fab fa-whatsapp"></i>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                               target="_blank" class="text-green-600">
                                WhatsApp{{ count($whatsapps) > 1 ? ' ' . ($index + 1) : '' }}
                                <span class="text-sm text-gray-500">({{ $whatsapp }})</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->correo)
                @php
                    $correos = explode(',', $comercio->datosContacto->correo);
                @endphp
                @foreach($correos as $index => $correo)
                    @php $correo = trim($correo); @endphp
                    @if($correo)
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ $correo }}">
                                {{ count($correos) > 1 ? 'Email ' . ($index + 1) : 'Email' }}
                                <span class="text-sm text-gray-500">({{ $correo }})</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->sitioWeb)
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
                        <div class="info-item">
                            <i class="fas fa-globe"></i>
                            <a href="{{ $sitioWeb }}" target="_blank" class="text-blue-600">
                                {{ count($sitiosWeb) > 1 ? 'Sitio ' . ($index + 1) : 'Sitio Web' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->facebook)
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
                        <div class="info-item">
                            <i class="fab fa-facebook"></i>
                            <a href="{{ $facebook }}" target="_blank" class="text-blue-800">
                                {{ count($facebooks) > 1 ? 'Facebook ' . ($index + 1) : 'Facebook' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->instagram)
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
                        <div class="info-item">
                            <i class="fab fa-instagram"></i>
                            <a href="{{ $instagram }}" target="_blank" class="text-pink-600">
                                {{ count($instagrams) > 1 ? 'Instagram ' . ($index + 1) : 'Instagram' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif

            @if($comercio->datosContacto && $comercio->datosContacto->tiktok)
                @php
                    $tiktoks = explode(',', $comercio->datosContacto->tiktok);
                @endphp
                @foreach($tiktoks as $index => $tiktok)
                    @php 
                        $tiktok = trim($tiktok);
                        // Normalize TikTok URL
                        if (!empty($tiktok)) {
                            if (!preg_match('/^https?:\/\//', $tiktok)) {
                                if (strpos($tiktok, 'tiktok.com') === false) {
                                    $tiktok = 'https://tiktok.com/@' . ltrim($tiktok, '@/');
                                } else {
                                    $tiktok = 'https://' . $tiktok;
                                }
                            }
                        }
                    @endphp
                    @if($tiktok)
                        <div class="info-item">
                            <i class="fab fa-tiktok"></i>
                            <a href="{{ $tiktok }}" target="_blank" class="text-black">
                                {{ count($tiktoks) > 1 ? 'TikTok ' . ($index + 1) : 'TikTok' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="comercio-actions">
            <a href="{{ route('comercio.detalle', $comercio->slug) }}" class="btn btn-primary btn-block">
                <i class="fas fa-info-circle"></i>
                Más información
            </a>
        </div>
    </div>
</div>