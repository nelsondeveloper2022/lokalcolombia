@extends('layouts.public')

@section('title', 'Contacto - Puente Local Colombia')
@section('description', 'Contáctanos para registrar tu negocio, hacer sugerencias o resolver cualquier duda. Estamos aquí para ayudarte a ser parte de nuestra comunidad digital.')

@section('content')
<!-- Header Section -->
<section class="contact-header">
    <div class="header-background">
        <div class="header-overlay"></div>
    </div>
    
    <div class="container">
        <div class="header-content" data-aos="fade-up">
            <h1 class="page-title">Contáctanos</h1>
            <p class="page-description">
                Estamos aquí para ayudarte. Escríbenos y te responderemos lo más pronto posible.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-16">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-container" data-aos="fade-right">
                <div class="form-header">
                    <h2 class="form-title">Envíanos un mensaje</h2>
                    <p class="form-description">
                        Completa el formulario y nos pondremos en contacto contigo en menos de 24 horas.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contacto.enviar') }}" method="POST" class="contact-form">
                    @csrf
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user"></i>
                                Nombre completo *
                            </label>
                            <input 
                                type="text" 
                                id="nombre" 
                                name="nombre" 
                                value="{{ old('nombre') }}"
                                class="form-input {{ $errors->has('nombre') ? 'error' : '' }}"
                                placeholder="Tu nombre completo"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Correo electrónico *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                                placeholder="tu@email.com"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefono" class="form-label">
                            <i class="fas fa-phone"></i>
                            Teléfono (opcional)
                        </label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono" 
                            value="{{ old('telefono') }}"
                            class="form-input"
                            placeholder="3001234567"
                        >
                    </div>

                    <div class="form-group">
                        <label for="asunto" class="form-label">
                            <i class="fas fa-tag"></i>
                            Asunto
                        </label>
                        <select id="asunto" name="asunto" class="form-select">
                            <option value="">Selecciona un asunto</option>
                            <option value="registro_negocio" {{ old('asunto') == 'registro_negocio' ? 'selected' : '' }}>
                                Quiero registrar mi negocio
                            </option>
                            <option value="informacion_general" {{ old('asunto') == 'informacion_general' ? 'selected' : '' }}>
                                Información general
                            </option>
                            <option value="problema_tecnico" {{ old('asunto') == 'problema_tecnico' ? 'selected' : '' }}>
                                Problema técnico
                            </option>
                            <option value="sugerencia" {{ old('asunto') == 'sugerencia' ? 'selected' : '' }}>
                                Sugerencia o mejora
                            </option>
                            <option value="colaboracion" {{ old('asunto') == 'colaboracion' ? 'selected' : '' }}>
                                Colaboración o alianza
                            </option>
                            <option value="otro" {{ old('asunto') == 'otro' ? 'selected' : '' }}>
                                Otro
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mensaje" class="form-label">
                            <i class="fas fa-comment"></i>
                            Mensaje *
                        </label>
                        <textarea 
                            id="mensaje" 
                            name="mensaje" 
                            rows="6"
                            class="form-textarea {{ $errors->has('mensaje') ? 'error' : '' }}"
                            placeholder="Escribe tu mensaje aquí... Cuéntanos qué necesitas o en qué podemos ayudarte."
                            required
                        >{{ old('mensaje') }}</textarea>
                        <div class="char-counter">
                            <span id="charCount">0</span> / 500 caracteres
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i>
                            Enviar mensaje
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-container" data-aos="fade-left" data-aos-delay="200">
                <!-- Contact Cards -->
                <div class="contact-cards">
                    <div class="contact-card">
                        <div class="card-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Correo Electrónico</h3>
                            <p class="card-description">
                                Escríbenos directamente a nuestro correo principal
                            </p>
                            <a href="mailto:info@puentelokalcolombia.com" class="card-link">
                                info@puentelokalcolombia.com
                            </a>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">WhatsApp</h3>
                            <p class="card-description">
                                Contáctanos por WhatsApp para respuestas rápidas
                            </p>
                            <a href="https://wa.me/573001234567" target="_blank" class="card-link">
                                +57 300 123 4567
                            </a>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Ubicación</h3>
                            <p class="card-description">
                                Nos encontramos en el corazón de Puente Nacional
                            </p>
                            <span class="card-link">
                                Puente Nacional<br>
                                Santander, Colombia
                            </span>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Horario de Atención</h3>
                            <p class="card-description">
                                Tiempo de respuesta promedio
                            </p>
                            <span class="card-link">
                                Lunes a Viernes<br>
                                8:00 AM - 6:00 PM
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-section">
                    <h3 class="social-title">Síguenos en redes sociales</h3>
                    <p class="social-description">
                        Mantente al día con las últimas novedades y comercios registrados
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link facebook" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="social-link instagram" target="_blank">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="#" class="social-link twitter" target="_blank">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="#" class="social-link youtube" target="_blank">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-section">
                    <h3 class="faq-title">Preguntas Frecuentes</h3>
                    <div class="faq-list">
                        <div class="faq-item" onclick="toggleFaq(this)">
                            <div class="faq-question">
                                <span>¿Es realmente gratis registrar mi negocio?</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Sí, el registro es completamente gratuito. No cobramos ninguna tarifa por incluir tu negocio en nuestro directorio digital.</p>
                            </div>
                        </div>

                        <div class="faq-item" onclick="toggleFaq(this)">
                            <div class="faq-question">
                                <span>¿Cuánto tiempo toma registrar mi negocio?</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Una vez envíes la información, verificaremos los datos en 24-48 horas y tu negocio aparecerá en el directorio.</p>
                            </div>
                        </div>

                        <div class="faq-item" onclick="toggleFaq(this)">
                            <div class="faq-question">
                                <span>¿Puedo actualizar la información de mi negocio?</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>¡Por supuesto! Contáctanos cuando necesites actualizar información, fotos o cualquier detalle de tu negocio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-16 bg-light">
    <div class="container">
        <div class="section-header text-center mb-8" data-aos="fade-up">
            <h2 class="section-title">Nuestra Ubicación</h2>
            <p class="section-description">
                Conoce dónde nos encontramos en Puente Nacional, Santander
            </p>
        </div>

        <div class="map-container" data-aos="fade-up" data-aos-delay="200">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.8471234567!2d-73.6834567!3d5.7856789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwNDcnMDguNCJOIDczwrA0MScwMC40Ilc!5e0!3m2!1ses!2sco!4v1234567890"
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                class="map-iframe">
            </iframe>
        </div>
    </div>
</section>

<style>
/* Header Section */
.contact-header {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    padding: 8rem 0 4rem;
    position: relative;
    overflow: hidden;
}

.header-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
}

.header-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.page-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.page-description {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

/* Contact Grid */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

/* Contact Form */
.contact-form-container {
    background: white;
    padding: 3rem;
    border-radius: 1rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color);
}

.form-header {
    margin-bottom: 2rem;
}

.form-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* Alerts */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.error-list {
    list-style: none;
    margin: 0;
}

.error-list li {
    margin-bottom: 0.25rem;
}

/* Form Styles */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label i {
    color: var(--primary-color);
    width: 16px;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
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

.form-input.error,
.form-textarea.error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.char-counter {
    text-align: right;
    font-size: 0.75rem;
    color: var(--text-light);
    margin-top: 0.5rem;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

/* Contact Cards */
.contact-cards {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.contact-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    transition: all 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.card-content {
    flex: 1;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.card-description {
    color: var(--text-light);
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.card-link {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.card-link:hover {
    color: var(--primary-dark);
}

/* Social Section */
.social-section {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.social-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.social-description {
    color: var(--text-light);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.social-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.social-link.facebook {
    color: #1877f2;
}

.social-link.facebook:hover {
    background: #1877f2;
    color: white;
}

.social-link.instagram {
    color: #e4405f;
}

.social-link.instagram:hover {
    background: #e4405f;
    color: white;
}

.social-link.twitter {
    color: #1da1f2;
}

.social-link.twitter:hover {
    background: #1da1f2;
    color: white;
}

.social-link.youtube {
    color: #ff0000;
}

.social-link.youtube:hover {
    background: #ff0000;
    color: white;
}

/* FAQ Section */
.faq-section {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

.faq-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
}

.faq-list {
    display: grid;
    gap: 1rem;
}

.faq-item {
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: var(--primary-color);
}

.faq-question {
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg-light);
    font-weight: 600;
    color: var(--text-dark);
}

.faq-question i {
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.faq-item.active .faq-question i {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item.active .faq-answer {
    padding: 1rem 1.5rem;
    max-height: 200px;
}

.faq-answer p {
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
}

/* Map Section */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.section-description {
    font-size: 1.125rem;
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
}

.map-container {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color);
}

.map-iframe {
    border-radius: 1rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
}

@media (max-width: 768px) {
    .contact-header {
        padding: 6rem 0 3rem;
    }

    .page-title {
        font-size: 2.5rem;
    }

    .contact-form-container {
        padding: 2rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .contact-card {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
    }

    .card-icon {
        margin: 0 auto;
    }

    .social-links {
        grid-template-columns: 1fr;
    }

    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 2rem;
    }

    .contact-form-container {
        padding: 1.5rem;
    }

    .form-title {
        font-size: 1.5rem;
    }

    .contact-card {
        padding: 1rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .faq-question {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .faq-answer {
        padding: 0 1rem;
    }

    .faq-item.active .faq-answer {
        padding: 0.75rem 1rem;
    }
}
</style>

@push('scripts')
<script>
// Character counter for textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('mensaje');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = currentLength;
            
            if (currentLength > 500) {
                charCount.style.color = '#ef4444';
            } else if (currentLength > 400) {
                charCount.style.color = '#f59e0b';
            } else {
                charCount.style.color = '#6b7280';
            }
        });

        // Initialize counter
        charCount.textContent = textarea.value.length;
    }
});

// FAQ Toggle
function toggleFaq(element) {
    const isActive = element.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
        element.classList.add('active');
    }
}

// Form validation enhancement
document.querySelector('.contact-form').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const mensaje = document.getElementById('mensaje').value.trim();
    
    if (!nombre || !email || !mensaje) {
        e.preventDefault();
        alert('Por favor completa todos los campos obligatorios.');
        return false;
    }
    
    if (mensaje.length < 10) {
        e.preventDefault();
        alert('El mensaje debe tener al menos 10 caracteres.');
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    submitBtn.disabled = true;
    
    // Re-enable after 3 seconds (in case of error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});
</script>
@endpush
@endsection