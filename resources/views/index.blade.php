@extends('layouts.public')

@section('title', 'Lokal Colombia - Directorio Digital')
@section('description', 'Descubre y conecta con comercios y servicios locales en Colombia. Plataforma gratuita para impulsar nuestra economía local.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <div class="hero-content container">
            <div class="hero-text" data-aos="fade-up">
                <span class="hero-badge">Lokal Colombia - Conectando comunidades</span>
                <h1 class="hero-title">
                    Encuentra la solución perfecta para tus 
                    <span class="text-primary">necesidades</span>
                </h1>
                <p class="hero-description">
                    Explora comercios, servicios y productos locales. Impulsa lo nuestro y conecta con tu comunidad a través de nuestro directorio digital.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store"></i>
                        Registrar mi negocio
                    </a>
                    <a href="{{ route('comercios') }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-search"></i>
                        Explorar comercios
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('storage/imagenes-lokal-colombia/puente-nacional.webp') }}" alt="Puente Nacional" class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-16 bg-light">
    <div class="container">
        <div class="section-header text-center mb-12" data-aos="fade-up">
            <h2 class="section-title">¿Cómo funciona nuestro proyecto?</h2>
            <p class="section-description">
                Conoce cómo funciona nuestro directorio digital para conectar comercios y consumidores en Colombia
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="feature-content">
                    <span class="feature-number">01</span>
                    <h3 class="feature-title">Registro gratuito</h3>
                    <p class="feature-description">
                        Estamos recolectando información de comercios y servicios locales sin costo alguno.
                    </p>
                </div>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-content">
                    <span class="feature-number">02</span>
                    <h3 class="feature-title">Verificación</h3>
                    <p class="feature-description">
                        Validamos que el negocio sea real y activo.
                    </p>
                </div>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="feature-content">
                    <span class="feature-number">03</span>
                    <h3 class="feature-title">Presencia digital</h3>
                    <p class="feature-description">
                        Aparecen en nuestro portal local con fotos y contacto.
                    </p>
                </div>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="feature-content">
                    <span class="feature-number">04</span>
                    <h3 class="feature-title">Conexión local</h3>
                    <p class="feature-description">
                        Los habitantes pueden encontrar fácilmente lo que buscan y apoyar el comercio local.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($comerciosDestacados->count() > 0)
<!-- Featured Businesses Section -->
<section class="featured-section py-16">
    <div class="container">
        <div class="section-header text-center mb-12" data-aos="fade-up">
            <h2 class="section-title">Comercios y Servicios Registrados</h2>
            <p class="section-description">
                Descubre algunos de los negocios locales que ya forman parte de nuestra comunidad digital
            </p>
        </div>

        <div class="comercios-carousel" data-aos="fade-up" data-aos-delay="200">
            <div class="carousel-container">
                <div class="carousel-track" id="carouselTrack">
                    @foreach($comerciosDestacados as $comercio)
                    <div class="comercio-card">
                        <div class="comercio-image">
                            @if($comercio->imagenes->first())
                                <img src="{{ $comercio->imagenes->first()->rutaImagen }}" alt="{{ $comercio->titulo }}">
                            @else
                                <div class="placeholder-image">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                            @if($comercio->categoria)
                                <span class="comercio-category">{{ $comercio->categoria->nombre }}</span>
                            @endif
                        </div>
                        <div class="comercio-content">
                            <h3 class="comercio-name">{{ $comercio->titulo }}</h3>
                            <p class="comercio-description">
                                {{ Str::limit($comercio->descripcionCorta, 80) }}
                            </p>
                            @if($comercio->datosContacto)
                                <div class="comercio-contact">
                                    @if($comercio->datosContacto->telefono)
                                        <span class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            {{ $comercio->datosContacto->telefono }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <a href="{{ route('comercio.detalle', $comercio->slug) }}" class="btn btn-primary btn-sm">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <button class="carousel-btn carousel-prev" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-next" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('comercios') }}" class="btn btn-outline btn-lg">
                <i class="fas fa-th"></i>
                Ver todos los comercios
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section py-16 bg-primary">
    <div class="container">
        <div class="cta-content text-center" data-aos="fade-up">
            <h2 class="cta-title">¿Tienes un negocio en Puente Nacional?</h2>
            <p class="cta-description">
                Únete a nuestra comunidad digital de forma gratuita y dale mayor visibilidad a tu negocio
            </p>
            <a href="{{ route('register') }}" class="btn btn-white btn-lg">
                <i class="fas fa-rocket"></i>
                Registrar mi negocio ahora
            </a>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.hero-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(55, 65, 81, 0.6) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    min-height: 80vh;
}

.hero-badge {
    display: inline-block;
    background: rgba(245, 158, 11, 0.1);
    color: var(--primary-color);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    color: white;
    margin-bottom: 1.5rem;
}

.hero-description {
    font-size: 1.25rem;
    color: #d1d5db;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

.btn-white {
    background: white;
    color: var(--primary-color);
}

.btn-white:hover {
    background: #f9fafb;
    transform: translateY(-2px);
}

.hero-image {
    position: relative;
}

.hero-img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

/* Features Section */
.section-header {
    max-width: 600px;
    margin: 0 auto;
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
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.feature-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.feature-icon {
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

.feature-number {
    position: absolute;
    top: -10px;
    right: 20px;
    background: var(--primary-color);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.feature-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* Comercios Carousel */
.comercios-carousel {
    position: relative;
    overflow: hidden;
    border-radius: 1rem;
}

.carousel-container {
    position: relative;
}

.carousel-track {
    display: flex;
    transition: transform 0.5s ease;
    gap: 1.5rem;
}

.comercio-card {
    min-width: 320px;
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.comercio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.comercio-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.comercio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--bg-light), #e5e7eb);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: var(--text-light);
}

.comercio-category {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.comercio-content {
    padding: 1.5rem;
}

.comercio-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.comercio-description {
    color: var(--text-light);
    margin-bottom: 1rem;
    line-height: 1.5;
}

.comercio-contact {
    margin-bottom: 1rem;
}

.contact-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-light);
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: 1px solid var(--border-color);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.carousel-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.carousel-prev {
    left: -25px;
}

.carousel-next {
    right: -25px;
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

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .hero-buttons {
        justify-content: center;
    }

    .section-title {
        font-size: 2rem;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .carousel-track {
        padding: 0 1rem;
    }

    .comercio-card {
        min-width: 280px;
    }

    .carousel-btn {
        display: none;
    }

    .cta-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    .comercio-card {
        min-width: 260px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (track && prevBtn && nextBtn) {
        let currentIndex = 0;
        const cards = track.children;
        const cardWidth = 320 + 24; // card width + gap
        const visibleCards = Math.floor(track.parentElement.offsetWidth / cardWidth);
        const maxIndex = Math.max(0, cards.length - visibleCards);

        function updateCarousel() {
            const translateX = -currentIndex * cardWidth;
            track.style.transform = `translateX(${translateX}px)`;
            
            prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        }

        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Auto-scroll carousel
        setInterval(function() {
            if (currentIndex >= maxIndex) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            updateCarousel();
        }, 5000);

        // Initial setup
        updateCarousel();

        // Handle window resize
        window.addEventListener('resize', function() {
            const newVisibleCards = Math.floor(track.parentElement.offsetWidth / cardWidth);
            const newMaxIndex = Math.max(0, cards.length - newVisibleCards);
            if (currentIndex > newMaxIndex) {
                currentIndex = newMaxIndex;
            }
            updateCarousel();
        });
    }
});
</script>
@endpush
@endsection