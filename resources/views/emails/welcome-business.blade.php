<x-mail::message>
# ¡Bienvenido a Lokal Colombia, {{ $user->name }}!

Gracias por registrar tu negocio **{{ $comercio->titulo }}** en nuestra plataforma. Tu registro ha sido exitoso y ya puedes acceder a tu panel de control.

## ¿Qué sigue?

Para aprovechar al máximo Lokal Colombia, te recomendamos completar la información de tu comercio:

- Agregar imágenes atractivas de tu negocio
- Completar la descripción detallada
- Configurar datos de contacto (teléfono, WhatsApp, redes sociales)
- Establecer horarios de atención
- Añadir dirección exacta

<x-mail::button :url="$dashboardUrl">
Ir a mi Dashboard
</x-mail::button>

<x-mail::button :url="$completeInfoUrl" color="success">
Completar información del comercio
</x-mail::button>

## Beneficios de estar en Lokal Colombia

- **Visibilidad**: Tu negocio será visible para toda la comunidad
- **Contacto directo**: Los clientes podrán contactarte fácilmente
- **Gratuito**: Sin costos ocultos, completamente gratis
- **Local**: Conecta con tu comunidad y fortalece la economía local

Si tienes alguna pregunta, no dudes en contactarnos.

Saludos cordiales,<br>
El equipo de {{ config('app.name') }}

---
*Este correo fue enviado porque registraste tu negocio en Lokal Colombia.*
</x-mail::message>
