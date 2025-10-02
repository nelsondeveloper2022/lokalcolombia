<?php

if (!function_exists('whatsapp_url')) {
    /**
     * Generar URL de WhatsApp con mensaje personalizado
     *
     * @param string $message Mensaje personalizado
     * @param string|null $messageKey Clave del mensaje predefinido en config
     * @return string
     */
    function whatsapp_url($message = '', $messageKey = null)
    {
        $phone = preg_replace('/[^0-9]/', '', config('contact.whatsapp'));
        
        // Si se proporciona una clave de mensaje, usarla
        if ($messageKey && config("contact.whatsapp_messages.{$messageKey}")) {
            $message = config("contact.whatsapp_messages.{$messageKey}");
        }
        
        $encodedMessage = urlencode($message);
        return "https://wa.me/{$phone}" . ($message ? "?text={$encodedMessage}" : '');
    }
}

if (!function_exists('contact_email_url')) {
    /**
     * Generar URL de mailto con parámetros
     *
     * @param string $subject Asunto del email
     * @param string $body Cuerpo del email
     * @return string
     */
    function contact_email_url($subject = '', $body = '')
    {
        $email = config('contact.email');
        $params = [];
        if ($subject) $params[] = 'subject=' . urlencode($subject);
        if ($body) $params[] = 'body=' . urlencode($body);
        return "mailto:{$email}" . (!empty($params) ? '?' . implode('&', $params) : '');
    }
}

if (!function_exists('contact_info')) {
    /**
     * Obtener información de contacto desde la configuración
     *
     * @param string|null $key Clave específica de configuración
     * @return mixed
     */
    function contact_info($key = null)
    {
        if ($key) {
            return config("contact.{$key}");
        }
        return config('contact');
    }
}