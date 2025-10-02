@props(['comercio', 'type' => 'list'])

@php
    $socialNetworks = [
        'sitioWeb' => [
            'icon' => 'fas fa-globe',
            'color' => 'text-blue-600',
            'label' => 'Sitio Web',
            'action' => 'Visitar sitio web'
        ],
        'facebook' => [
            'icon' => 'fab fa-facebook',
            'color' => 'text-blue-800',
            'label' => 'Facebook',
            'action' => 'Síguenos en Facebook'
        ],
        'instagram' => [
            'icon' => 'fab fa-instagram',
            'color' => 'text-pink-600',
            'label' => 'Instagram',
            'action' => 'Síguenos en Instagram'
        ],
        'tiktok' => [
            'icon' => 'fab fa-tiktok',
            'color' => 'text-black',
            'label' => 'TikTok',
            'action' => 'Síguenos en TikTok'
        ],
        'twitter' => [
            'icon' => 'fab fa-twitter',
            'color' => 'text-blue-400',
            'label' => 'Twitter',
            'action' => 'Síguenos en Twitter'
        ],
        'linkedin' => [
            'icon' => 'fab fa-linkedin',
            'color' => 'text-blue-700',
            'label' => 'LinkedIn',
            'action' => 'Conecta en LinkedIn'
        ],
        'youtube' => [
            'icon' => 'fab fa-youtube',
            'color' => 'text-red-600',
            'label' => 'YouTube',
            'action' => 'Ver en YouTube'
        ],
        'telegram' => [
            'icon' => 'fab fa-telegram',
            'color' => 'text-blue-500',
            'label' => 'Telegram',
            'action' => 'Conecta por Telegram'
        ],
        'pinterest' => [
            'icon' => 'fab fa-pinterest',
            'color' => 'text-red-700',
            'label' => 'Pinterest',
            'action' => 'Síguenos en Pinterest'
        ],
        'snapchat' => [
            'icon' => 'fab fa-snapchat',
            'color' => 'text-yellow-400',
            'label' => 'Snapchat',
            'action' => 'Agréganos en Snapchat'
        ]
    ];
@endphp

@if($comercio->datosContacto)
    @foreach($socialNetworks as $network => $config)
        @if($comercio->datosContacto->{$network})
            @php
                $links = explode(',', $comercio->datosContacto->{$network});
            @endphp
            @foreach($links as $index => $link)
                @php $link = trim($link); @endphp
                @if($link)
                    @if($type === 'list')
                        <div class="info-item">
                            <i class="{{ $config['icon'] }}"></i>
                            <a href="{{ $link }}" target="_blank" class="{{ $config['color'] }}">
                                {{ count($links) > 1 ? $config['label'] . ' ' . ($index + 1) : $config['label'] }}
                                @if($type === 'list' && count($links) === 1)
                                    <span class="text-sm text-gray-500">({{ Str::limit($link, 30) }})</span>
                                @endif
                            </a>
                        </div>
                    @elseif($type === 'contact')
                        <div class="contact-detail">
                            <i class="{{ $config['icon'] }}"></i>
                            <div>
                                <span class="label">{{ $config['label'] }}{{ count($links) > 1 ? ' ' . ($index + 1) : '' }}</span>
                                <a href="{{ $link }}" target="_blank" class="contact-link">
                                    {{ count($links) > 1 ? $config['action'] . ' ' . ($index + 1) : $config['action'] }}
                                </a>
                            </div>
                        </div>
                    @elseif($type === 'button' && $index === 0)
                        <a href="{{ $link }}" target="_blank" class="action-btn btn-{{ strtolower($network) }}">
                            <i class="{{ $config['icon'] }}"></i>
                            {{ $config['action'] }}
                        </a>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach
@endif