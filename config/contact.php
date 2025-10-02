<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Información de Contacto
    |--------------------------------------------------------------------------
    |
    | Esta configuración contiene toda la información de contacto de
    | Puente Local Colombia, incluyendo email, teléfono, redes sociales
    | y mensajes predefinidos para WhatsApp.
    |
    */

    'email' => env('CONTACT_EMAIL', 'info@puentelokalcolombia.com'),
    
    'phone' => env('CONTACT_PHONE', '+573001234567'),
    
    'whatsapp' => env('CONTACT_WHATSAPP', '+573001234567'),
    
    'whatsapp_support' => env('WHATSAPP_SUPPORT', '+573001234567'),
    
    'address' => env('CONTACT_ADDRESS', 'Puente Nacional, Santander, Colombia'),

    /*
    |--------------------------------------------------------------------------
    | Redes Sociales
    |--------------------------------------------------------------------------
    */

    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', 'https://facebook.com/puentelokalcolombia'),
        'instagram' => env('SOCIAL_INSTAGRAM', 'https://instagram.com/puentelokalcolombia'),
        'twitter' => env('SOCIAL_TWITTER', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Mensajes Predefinidos para WhatsApp
    |--------------------------------------------------------------------------
    */

    'whatsapp_messages' => [
        'register_business' => '¡Hola! Quiero registrar mi comercio en Puente Local Colombia. ¿Podrían ayudarme con el proceso? Me interesa conocer los requisitos y el proceso completo.',
        'general_inquiry' => '¡Hola! Me interesa conocer más sobre Puente Local Colombia.',
        'support' => '¡Hola! Necesito ayuda con mi perfil en Puente Local Colombia.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Información de la Empresa
    |--------------------------------------------------------------------------
    */

    'company' => [
        'name' => env('APP_NAME', 'Puente Local Colombia'),
        'slogan' => 'Conectando comunidades, fortaleciendo la economía local',
        'description' => 'Una iniciativa digital gratuita para fortalecer la economía local de Puente Nacional, Santander.',
        'mission' => 'Fortalecer la economía local de Puente Nacional mediante una plataforma digital que conecte comerciantes y consumidores, promoviendo el desarrollo sostenible de nuestra comunidad.',
    ],

];