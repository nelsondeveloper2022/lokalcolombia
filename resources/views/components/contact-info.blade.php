@props(['comercio', 'type' => 'list'])

@if($comercio->datosContacto)
    {{-- Teléfonos --}}
    @if($comercio->datosContacto->telefono)
        @php
            $telefonos = explode(',', $comercio->datosContacto->telefono);
        @endphp
        @foreach($telefonos as $index => $telefono)
            @php $telefono = trim($telefono); @endphp
            @if($telefono)
                @if($type === 'list')
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $telefono }}">
                            {{ count($telefonos) > 1 ? 'Tel ' . ($index + 1) . ': ' : '' }}{{ $telefono }}
                        </a>
                    </div>
                @elseif($type === 'contact')
                    <div class="contact-detail">
                        <i class="fas fa-phone"></i>
                        <div>
                            <span class="label">Teléfono{{ count($telefonos) > 1 ? ' ' . ($index + 1) : '' }}</span>
                            <a href="tel:{{ $telefono }}" class="contact-link">
                                {{ $telefono }}
                            </a>
                        </div>
                    </div>
                @elseif($type === 'button')
                    <a href="tel:{{ $telefono }}" class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        {{ count($telefonos) > 1 ? 'Llamar ' . ($index + 1) : 'Llamar' }}
                    </a>
                @elseif($type === 'action')
                    <a href="tel:{{ $telefono }}" class="action-btn btn-primary">
                        <i class="fas fa-phone"></i>
                        {{ count($telefonos) > 1 ? 'Llamar ' . ($index + 1) : 'Llamar ahora' }}
                    </a>
                @endif
            @endif
        @endforeach
    @endif

    {{-- WhatsApp --}}
    @if($comercio->datosContacto->whatsapp)
        @php
            $whatsapps = explode(',', $comercio->datosContacto->whatsapp);
        @endphp
        @foreach($whatsapps as $index => $whatsapp)
            @php $whatsapp = trim($whatsapp); @endphp
            @if($whatsapp)
                @if($type === 'list')
                    <div class="info-item">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                           target="_blank" class="text-green-600">
                            WhatsApp{{ count($whatsapps) > 1 ? ' ' . ($index + 1) : '' }}
                            <span class="text-sm text-gray-500">({{ $whatsapp }})</span>
                        </a>
                    </div>
                @elseif($type === 'contact')
                    <div class="contact-detail">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <span class="label">WhatsApp{{ count($whatsapps) > 1 ? ' ' . ($index + 1) : '' }}</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                               target="_blank" class="contact-link">
                                {{ $whatsapp }}
                            </a>
                        </div>
                    </div>
                @elseif($type === 'button')
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                       target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i>
                        {{ count($whatsapps) > 1 ? 'WhatsApp ' . ($index + 1) : 'WhatsApp' }}
                    </a>
                @elseif($type === 'action')
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                       target="_blank" class="action-btn btn-success">
                        <i class="fab fa-whatsapp"></i>
                        {{ count($whatsapps) > 1 ? 'WhatsApp ' . ($index + 1) : 'Enviar WhatsApp' }}
                    </a>
                @endif
            @endif
        @endforeach
    @endif

    {{-- Email --}}
    @if($comercio->datosContacto->correo)
        @php
            $correos = explode(',', $comercio->datosContacto->correo);
        @endphp
        @foreach($correos as $index => $correo)
            @php $correo = trim($correo); @endphp
            @if($correo)
                @if($type === 'list')
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $correo }}">
                            {{ count($correos) > 1 ? 'Email ' . ($index + 1) : 'Email' }}
                            <span class="text-sm text-gray-500">({{ $correo }})</span>
                        </a>
                    </div>
                @elseif($type === 'contact')
                    <div class="contact-detail">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <span class="label">Email{{ count($correos) > 1 ? ' ' . ($index + 1) : '' }}</span>
                            <a href="mailto:{{ $correo }}" class="contact-link">
                                {{ $correo }}
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @endif

    {{-- Sitio Web --}}
    @if($comercio->datosContacto->sitioWeb)
        @php
            $sitiosWeb = explode(',', $comercio->datosContacto->sitioWeb);
            
            // Function to normalize URL
            function normalizeUrl($url) {
                $url = trim($url);
                if (empty($url)) return '';
                
                // If it doesn't start with http:// or https://, add https://
                if (!preg_match('/^https?:\/\//', $url)) {
                    $url = 'https://' . $url;
                }
                return $url;
            }
        @endphp
        @foreach($sitiosWeb as $index => $sitioWeb)
            @php 
                $sitioWeb = normalizeUrl($sitioWeb);
            @endphp
            @if($sitioWeb)
                @if($type === 'action')
                    <a href="{{ $sitioWeb }}" target="_blank" class="action-btn btn-secondary">
                        <i class="fas fa-globe"></i>
                        Visitar Sitio Web
                    </a>
                @endif
            @endif
        @endforeach
    @endif

    {{-- Facebook --}}
    @if($comercio->datosContacto->facebook)
        @php
            $facebooks = explode(',', $comercio->datosContacto->facebook);
            
            function normalizeFacebook($url) {
                $url = trim($url);
                if (empty($url)) return '';
                
                // If it's just a username, convert to full URL
                if (!preg_match('/^https?:\/\//', $url)) {
                    if (strpos($url, 'facebook.com') === false) {
                        $url = 'https://facebook.com/' . ltrim($url, '@/');
                    } else {
                        $url = 'https://' . $url;
                    }
                }
                return $url;
            }
        @endphp
        @foreach($facebooks as $index => $facebook)
            @php 
                $facebook = normalizeFacebook($facebook);
            @endphp
            @if($facebook)
                @if($type === 'action')
                    <a href="{{ $facebook }}" target="_blank" class="action-btn btn-facebook">
                        <i class="fab fa-facebook"></i>
                        Síguenos en Facebook
                    </a>
                @endif
            @endif
        @endforeach
    @endif

    {{-- Instagram --}}
    @if($comercio->datosContacto->instagram)
        @php
            $instagrams = explode(',', $comercio->datosContacto->instagram);
            
            function normalizeInstagram($url) {
                $url = trim($url);
                if (empty($url)) return '';
                
                // If it's just a username, convert to full URL
                if (!preg_match('/^https?:\/\//', $url)) {
                    if (strpos($url, 'instagram.com') === false) {
                        $url = 'https://instagram.com/' . ltrim($url, '@/');
                    } else {
                        $url = 'https://' . $url;
                    }
                }
                return $url;
            }
        @endphp
        @foreach($instagrams as $index => $instagram)
            @php 
                $instagram = normalizeInstagram($instagram);
            @endphp
            @if($instagram)
                @if($type === 'action')
                    <a href="{{ $instagram }}" target="_blank" class="action-btn btn-instagram">
                        <i class="fab fa-instagram"></i>
                        Síguenos en Instagram
                    </a>
                @endif
            @endif
        @endforeach
    @endif
@endif