<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo electrónico - Lokal Colombia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: #f59e0b;
        }
        
        .content {
            padding: 2rem;
        }
        
        .greeting {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .business-info {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }
        
        .business-info h3 {
            color: #1f2937;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .business-info p {
            color: #6b7280;
            margin-bottom: 0.25rem;
        }
        
        .verify-button {
            text-align: center;
            margin: 2rem 0;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }
        
        .features {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }
        
        .features h3 {
            color: #1f2937;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .feature-list {
            display: grid;
            gap: 0.75rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .feature-icon {
            width: 20px;
            height: 20px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        
        .warning {
            background: #fef3cd;
            border: 1px solid #fcd34d;
            color: #92400e;
            padding: 1rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }
        
        .footer {
            background: #374151;
            color: #d1d5db;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
        }
        
        .footer a {
            color: #f59e0b;
            text-decoration: none;
        }
        
        .social-links {
            margin-top: 1rem;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 0.5rem;
            color: #9ca3af;
            text-decoration: none;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 2rem 0;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                🏪
            </div>
            <h1>Lokal Colombia</h1>
            <p>Tu directorio digital de confianza</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                ¡Hola, {{ $user->name }}! 👋
            </div>
            
            <p>Gracias por registrarte en <strong>Lokal Colombia</strong>. Para completar tu registro y comenzar a promocionar tu negocio, necesitamos verificar tu dirección de correo electrónico.</p>
            
            @if($user->hasComercio() && $user->comercioServicio)
                <div class="business-info">
                    <h3>📍 Información de tu negocio:</h3>
                    <p><strong>Nombre:</strong> {{ $user->comercioServicio->titulo }}</p>
                    @if($user->comercioServicio->descripcionCorta)
                        <p><strong>Descripción:</strong> {{ $user->comercioServicio->descripcionCorta }}</p>
                    @endif
                    @if($user->comercioServicio->categoria)
                        <p><strong>Categoría:</strong> {{ $user->comercioServicio->categoria->nombre }}</p>
                    @endif
                    <p><strong>Email de contacto:</strong> {{ $user->email }}</p>
                </div>
            @endif
            
            <div class="verify-button">
                <a href="{{ $verificationUrl }}" class="btn">
                    ✅ Verificar mi correo electrónico
                </a>
            </div>
            
            <div class="features">
                <h3>🎯 ¿Qué obtienes al verificar tu cuenta?</h3>
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Acceso completo a tu panel de control</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Posibilidad de editar información de tu negocio</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Recibir consultas directas de clientes</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Aparecer en búsquedas de tu localidad</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Soporte técnico personalizado</span>
                    </div>
                </div>
            </div>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong> Este enlace de verificación expirará en 60 minutos por seguridad. Si no verificas tu correo, no podrás acceder a todas las funcionalidades de tu cuenta.
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 0.9rem; color: #6b7280;">
                Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:<br>
                <a href="{{ $verificationUrl }}" style="color: #f59e0b; word-break: break-all;">{{ $verificationUrl }}</a>
            </p>
            
            <div class="divider"></div>
            
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0;">
                <h3 style="color: #1f2937; margin-bottom: 1rem; text-align: center;">📞 ¿Necesitas ayuda?</h3>
                <p style="color: #6b7280; text-align: center; margin-bottom: 1rem;">
                    Nuestro equipo está disponible para apoyarte:
                </p>
                <div style="text-align: center;">
                    <p style="margin: 0.5rem 0;">
                        📧 <a href="mailto:{{ config('services.contact.email') }}" style="color: #f59e0b;">{{ config('services.contact.email') }}</a>
                    </p>
                    <p style="margin: 0.5rem 0;">
                        📱 <a href="tel:{{ config('services.contact.phone') }}" style="color: #f59e0b;">{{ config('services.contact.phone') }}</a>
                    </p>
                    <p style="margin: 0.5rem 0;">
                        💬 <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', config('services.contact.whatsapp')) }}" style="color: #f59e0b;" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
            
            <p style="font-size: 0.9rem; color: #6b7280; margin-top: 1.5rem;">
                Si no creaste esta cuenta, puedes ignorar este correo de forma segura.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong> - Conectando comunidades, fortaleciendo la economía local</p>
            
            <div class="social-links">
                @if(config('services.social.facebook'))
                    <a href="{{ config('services.social.facebook') }}" target="_blank">Facebook</a>
                @endif
                @if(config('services.social.instagram'))
                    <a href="{{ config('services.social.instagram') }}" target="_blank">Instagram</a>
                @endif
                @if(config('services.social.twitter'))
                    <a href="{{ config('services.social.twitter') }}" target="_blank">Twitter</a>
                @endif
            </div>
            
            <p style="margin-top: 1rem; font-size: 0.875rem;">
                <strong>Contáctanos:</strong><br>
                📧 <a href="mailto:{{ config('services.contact.email') }}">{{ config('services.contact.email') }}</a><br>
                📱 <a href="tel:{{ config('services.contact.phone') }}">{{ config('services.contact.phone') }}</a><br>
                📍 {{ config('services.contact.address') }}
            </p>
            
            <p style="margin-top: 1rem; font-size: 0.8rem;">
                © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.<br>
                <a href="#">Política de Privacidad</a> | <a href="#">Términos de Servicio</a>
            </p>
        </div>
    </div>
</body>
</html>