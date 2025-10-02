@extends('layouts.public')

@section('title', 'Quiénes Somos - Puente Local Colombia')
@section('description', 'Conoce la historia e iniciativa detrás de Puente Local Colombia, el directorio digital que conecta a nuestra comunidad con los comercios locales.')

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <div class="hero-pattern"></div>
    </div>
    
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <h1 class="hero-title" style="color: #fff;">Conoce nuestra historia</h1>
            <p class="hero-subtitle">
                Una iniciativa digital nacida del corazón de Puente Nacional para fortalecer nuestra economía local
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section py-16">
    <div class="container">
        <div class="mission-content">
            <div class="mission-text" data-aos="fade-right">
                <h2 class="section-title">Nuestra Misión</h2>
                <p class="section-description">
                    <strong>Puente Local Colombia</strong> nace como una iniciativa digital comunitaria con el objetivo de crear 
                    el directorio más completo de comercios y servicios de Puente Nacional, Santander.
                </p>
                <p>
                    Creemos firmemente en el poder de la comunidad local y queremos ser el puente que conecte 
                    a los habitantes, visitantes y turistas con los negocios que hacen único a nuestro municipio.
                </p>
                <div class="mission-highlights">
                    <div class="highlight-item">
                        <i class="fas fa-heart"></i>
                        <span>Fortalecemos la economía local</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-users"></i>
                        <span>Conectamos comunidades</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-rocket"></i>
                        <span>Impulsamos el crecimiento digital</span>
                    </div>
                </div>
            </div>
            
            <div class="mission-image" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('storage/imagenes-lokal-colombia/puente-nacional.png') }}" alt="Misión Puente Local" class="rounded-image">
                <div class="image-decoration"></div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section py-16 bg-light">
    <div class="container">
        <div class="section-header text-center mb-12" data-aos="fade-up">
            <h2 class="section-title">Nuestros Valores</h2>
            <p class="section-description">
                Los principios que guían nuestro trabajo y compromiso con la comunidad
            </p>
        </div>

        <div class="values-grid">
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="value-title">Compromiso Comunitario</h3>
                <p class="value-description">
                    Trabajamos de la mano con los comerciantes locales para crear una plataforma 
                    que realmente beneficie a nuestra comunidad.
                </p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="value-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3 class="value-title">Servicio Gratuito</h3>
                <p class="value-description">
                    Creemos que el acceso a una vitrina digital no debe ser un privilegio. 
                    Por eso ofrecemos nuestros servicios completamente gratis.
                </p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                <div class="value-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="value-title">Transparencia</h3>
                <p class="value-description">
                    Verificamos cada negocio para garantizar que la información sea real, 
                    actual y confiable para nuestra comunidad.
                </p>
            </div>

            <div class="value-card" data-aos="fade-up" data-aos-delay="400">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="value-title">Crecimiento Sostenible</h3>
                <p class="value-description">
                    Promovemos un desarrollo que beneficie tanto a los comerciantes como 
                    a los consumidores, creando un ecosistema próspero.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section py-16">
    <div class="container">
        <div class="section-header text-center mb-12" data-aos="fade-up">
            <h2 class="section-title">Cómo lo hacemos realidad</h2>
            <p class="section-description">
                El proceso paso a paso que seguimos para construir el directorio digital más completo
            </p>
        </div>

        <div class="process-timeline">
            <div class="process-step" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3 class="step-title">Recolección de Información</h3>
                    <p class="step-description">
                        Recorremos el municipio identificando y contactando comercios y prestadores de servicios. 
                        Recolectamos información básica de forma gratuita y voluntaria.
                    </p>
                </div>
                <div class="step-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

            <div class="process-step" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3 class="step-title">Verificación y Validación</h3>
                    <p class="step-description">
                        Verificamos que cada negocio sea real y esté activo. Confirmamos datos de contacto, 
                        ubicación y servicios ofrecidos para garantizar información confiable.
                    </p>
                </div>
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="process-step" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3 class="step-title">Creación de Perfil Digital</h3>
                    <p class="step-description">
                        Creamos un perfil atractivo para cada negocio con fotos, información de contacto, 
                        ubicación y descripción de servicios. Todo optimizado para búsquedas.
                    </p>
                </div>
                <div class="step-icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>

            <div class="process-step" data-aos="fade-up" data-aos-delay="400">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3 class="step-title">Conexión con la Comunidad</h3>
                    <p class="step-description">
                        Facilitamos que los habitantes encuentren fácilmente lo que buscan y puedan 
                        contactar directamente con los comercios a través de múltiples canales.
                    </p>
                </div>
                <div class="step-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-16">
    <div class="container">
        <div class="stats-grid" data-aos="fade-up">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-number" data-count="{{ $stats['comercios'] }}">0</div>
                <div class="stat-label">Comercios Registrados</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-number" data-count="{{ $stats['categorias'] }}">0</div>
                <div class="stat-label">Categorías Activas</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-number" data-count="100">0</div>
                <div class="stat-label">% Gratuito</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-number" data-count="{{ $stats['ano_inicio'] }}">0</div>
                <div class="stat-label">Año de Inicio</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-16 bg-primary">
    <div class="container">
        <div class="cta-content text-center" data-aos="fade-up">
            <h2 class="cta-title">¿Quieres ser parte de esta iniciativa?</h2>
            <p class="cta-description">
                Únete a nuestra comunidad digital y ayuda a fortalecer la economía local de Puente Nacional
            </p>
            <div class="cta-buttons">
                <a href="{{ whatsapp_url('', 'register_business') }}" 
                   target="_blank" class="btn btn-white btn-lg">
                    <i class="fab fa-whatsapp"></i>
                    Registrar mi negocio
                </a>
                <a href="{{ contact_email_url('Consulta sobre ' . contact_info('company.name'), 'Hola, me interesa conocer más información sobre ' . contact_info('company.name') . '.') }}" 
                   class="btn btn-outline btn-lg">
                    <i class="text-white fas fa-envelope"></i>
                    <span class="text-white">Contáctanos</span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.about-hero {
    position: relative;
    min-height: 60vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                      radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
}

.hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Mission Section */
.mission-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
}

.section-description {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
}

.section-description strong {
    color: var(--primary-color);
}

.mission-highlights {
    display: grid;
    gap: 1rem;
    margin-top: 2rem;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 0.75rem;
    border: 1px solid var(--border-color);
}

.highlight-item i {
    color: var(--primary-color);
    font-size: 1.25rem;
    width: 20px;
}

.highlight-item span {
    font-weight: 600;
    color: var(--text-dark);
}

.mission-image {
    position: relative;
}

.rounded-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.image-decoration {
    position: absolute;
    top: -20px;
    left: -20px;
    right: 20px;
    bottom: 20px;
    border: 3px solid var(--primary-color);
    border-radius: 1rem;
    z-index: -1;
}

/* Values Section */
.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.value-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 1rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
}

.value-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.value-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* Process Section */
.process-timeline {
    max-width: 800px;
    margin: 0 auto;
}

.process-step {
    display: grid;
    grid-template-columns: 60px 1fr 60px;
    gap: 2rem;
    align-items: center;
    margin-bottom: 3rem;
    position: relative;
}

.process-step:nth-child(even) {
    grid-template-columns: 60px 1fr 60px;
    direction: rtl;
}

.process-step:nth-child(even) > * {
    direction: ltr;
}

.process-step:nth-child(even) .step-content {
    text-align: right;
}

.process-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 30px;
    top: 60px;
    width: 2px;
    height: 60px;
    background: linear-gradient(to bottom, var(--primary-color), transparent);
}

.step-number {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    position: relative;
    z-index: 2;
}

.step-content {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

.step-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.step-description {
    color: var(--text-light);
    line-height: 1.6;
}

.step-icon {
    width: 60px;
    height: 60px;
    background: var(--bg-light);
    color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    border: 2px solid var(--border-color);
}

/* Team Section */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.team-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.team-photo {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.team-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-card:hover .team-img {
    transform: scale(1.05);
}

.team-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.team-card:hover .team-overlay {
    opacity: 1;
}

.team-social {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--primary-dark);
    transform: scale(1.1);
}

.team-info {
    padding: 2rem;
    text-align: center;
}

.team-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.team-role {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.team-description {
    color: var(--text-light);
    line-height: 1.6;
    font-size: 0.875rem;
}

/* Stats Section */
.stats-section {
    background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.stat-item {
    padding: 2rem 1rem;
}

.stat-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.125rem;
    opacity: 0.9;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-white {
    background: white;
    color: var(--primary-color);
}

.btn-white:hover {
    background: #f9fafb;
    transform: translateY(-2px);
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .mission-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }

    .section-title {
        font-size: 2rem;
    }

    .values-grid {
        grid-template-columns: 1fr;
    }

    .process-step {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1rem;
    }

    .process-step:nth-child(even) .step-content {
        text-align: center;
    }

    .process-step:not(:last-child)::after {
        display: none;
    }

    .team-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .cta-title {
        font-size: 2rem;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }

    .value-card {
        padding: 2rem 1.5rem;
    }

    .step-content {
        padding: 1.5rem;
    }

    .team-info {
        padding: 1.5rem;
    }

    .stat-item {
        padding: 1.5rem 1rem;
    }

    .stat-number {
        font-size: 2.5rem;
    }
}
</style>

@push('scripts')
<script>
// Animated counters
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;

    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.getAttribute('data-count');
            const data = +counter.innerText;

            const time = value / speed;
            if (data < value) {
                counter.innerText = Math.ceil(data + time);
                setTimeout(animate, 1);
            } else {
                counter.innerText = value;
            }
        }
        animate();
    });
}

// Intersection Observer for stats animation
const statsSection = document.querySelector('.stats-section');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

if (statsSection) {
    observer.observe(statsSection);
}
</script>
@endpush
@endsection