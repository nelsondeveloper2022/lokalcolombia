@extends('layouts.public')

@section('title', 'Comercios y Servicios - Puente Local Colombia')
@section('description', 'Descubre todos los comercios y servicios locales en Puente Nacional. Filtra por categoría, ubicación y encuentra exactamente lo que buscas.')

@section('content')
<!-- Header Section -->
<section class="page-header">
    <div class="container">
        <div class="header-content" data-aos="fade-up">
            <h1 class="page-title">Comercios y Servicios Registrados</h1>
            <p class="page-description">
                Explora y descubre todos los negocios locales que forman parte de nuestra comunidad digital
            </p>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="filters-section" id="filters-section">
    <div class="container">
        <div class="filters-container" data-aos="fade-up" data-aos-delay="200">
            <form method="GET" action="{{ route('comercios') }}" class="filters-form" id="filters-form">
                <div class="filter-group">
                    <label for="buscar" class="filter-label">
                        <i class="fas fa-search"></i>
                        Buscar
                    </label>
                    <input 
                        type="text" 
                        name="buscar" 
                        id="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Nombre del negocio o servicio..."
                        class="filter-input"
                    >
                </div>

                <div class="filter-group">
                    <label for="categoria" class="filter-label">
                        <i class="fas fa-tags"></i>
                        Categoría
                    </label>
                    <select name="categoria" id="categoria" class="filter-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->idMarketCategoria }}" 
                                {{ request('categoria') == $categoria->idMarketCategoria ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="ubicacion" class="filter-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Ubicación
                    </label>
                    <input 
                        type="text" 
                        name="ubicacion" 
                        id="ubicacion"
                        value="{{ request('ubicacion') }}"
                        placeholder="Barrio, sector o dirección..."
                        class="filter-input"
                    >
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Aplicar filtros
                    </button>
                    <a href="{{ route('comercios') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Results Section -->
<section class="results-section py-8">
    <div class="container">
        <!-- Results Header -->
        <div class="results-header" data-aos="fade-up">
            <div class="results-info">
                <h2 class="results-title">
                    @if(request()->hasAny(['buscar', 'categoria', 'ubicacion']))
                        Resultados de búsqueda
                    @else
                        Todos los comercios
                    @endif
                </h2>
                <p class="results-count">
                    Mostrando {{ $comercios->count() }} de {{ $comercios->total() }} resultados
                </p>
            </div>

            @if(request()->hasAny(['buscar', 'categoria', 'ubicacion']))
            <div class="active-filters">
                <h3 class="filters-title">Filtros activos:</h3>
                <div class="filter-tags">
                    @if(request('buscar'))
                        <span class="filter-tag">
                            <i class="fas fa-search"></i>
                            "{{ request('buscar') }}"
                            <a href="{{ request()->fullUrlWithQuery(['buscar' => null]) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request('categoria'))
                        @php
                            $categoriaActiva = $categorias->where('idMarketCategoria', request('categoria'))->first();
                        @endphp
                        @if($categoriaActiva)
                            <span class="filter-tag">
                                <i class="fas fa-tags"></i>
                                {{ $categoriaActiva->nombre }}
                                <a href="{{ request()->fullUrlWithQuery(['categoria' => null]) }}" class="remove-filter">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                    @endif

                    @if(request('ubicacion'))
                        <span class="filter-tag">
                            <i class="fas fa-map-marker-alt"></i>
                            "{{ request('ubicacion') }}"
                            <a href="{{ request()->fullUrlWithQuery(['ubicacion' => null]) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Comercios Grid -->
        @if($comercios->count() > 0)
            <div class="comercios-grid" id="comercios-grid" data-aos="fade-up" data-aos-delay="300">
                @foreach($comercios as $comercio)
                    @include('partials.comercio-card', ['comercio' => $comercio])
                @endforeach
            </div>

            <!-- Loading indicator for infinite scroll -->
            <div class="loading-indicator" id="loading-indicator" style="display: none;">
                <div class="spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <p>Cargando más comercios...</p>
            </div>

            <!-- End of results indicator -->
            @if(!$comercios->hasMorePages())
                <div class="end-results" id="end-results">
                    <div class="end-results-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p>Has visto todos los comercios disponibles</p>
                </div>
            @endif
        @else
            <!-- No Results -->
            <div class="no-results" data-aos="fade-up" data-aos-delay="300">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="no-results-title">No se encontraron resultados</h3>
                <p class="no-results-description">
                    No encontramos comercios que coincidan con tu búsqueda. 
                    Intenta ajustar los filtros o realizar una búsqueda más amplia.
                </p>
                <div class="no-results-actions">
                    <a href="{{ route('comercios') }}" class="btn btn-primary">
                        <i class="fas fa-refresh"></i>
                        Ver todos los comercios
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline">
                        <i class="fas fa-plus"></i>
                        Registrar mi negocio
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-light) 100%);
    padding: 4rem 0 2rem;
    margin-top: 0;
}

.header-content {
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

/* Filters Section */
.filters-section {
    background: white;
    border-bottom: 1px solid var(--border-color);
    padding: 2rem 0;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

/* Adjust content spacing for fixed filters */
.results-section {
    padding-top: 6rem;
}

.filters-container {
    background: var(--bg-light);
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
}

.filters-form {
    display: grid;
    grid-template-columns: 2fr 1fr 1.5fr auto;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.filter-input,
.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.filter-input:focus,
.filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
}

/* Results Header */
.results-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.results-info h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.results-count {
    color: var(--text-light);
    font-size: 0.875rem;
}

.active-filters {
    text-align: right;
}

.filters-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: flex-end;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.remove-filter {
    color: white;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.remove-filter:hover {
    opacity: 1;
}

/* Comercios Grid */
.comercios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.comercio-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    position: relative;
}

.comercio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.comercio-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.comercio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.comercio-card:hover .comercio-image img {
    transform: scale(1.05);
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
    z-index: 2;
}

.comercio-overlay {
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

.comercio-card:hover .comercio-overlay {
    opacity: 1;
}

.comercio-content {
    padding: 1.5rem;
}

.comercio-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
}

.comercio-description {
    color: var(--text-light);
    line-height: 1.5;
    margin-bottom: 1rem;
}

.comercio-info {
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.info-item i {
    color: var(--primary-color);
    width: 16px;
}

.info-item a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.3s ease;
}

.info-item a:hover {
    color: var(--primary-color);
}

.btn-block {
    width: 100%;
    justify-content: center;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 4rem 2rem;
    max-width: 500px;
    margin: 0 auto;
}

.no-results-icon {
    font-size: 4rem;
    color: var(--text-light);
    margin-bottom: 1.5rem;
}

.no-results-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.no-results-description {
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 2rem;
}

.no-results-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Loading and End Results */
.loading-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.loading-indicator .spinner {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.loading-indicator p {
    color: var(--text-light);
    font-size: 0.875rem;
}

.end-results {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
    text-align: center;
    margin-top: 2rem;
}

.end-results-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    opacity: 0.7;
}

.end-results p {
    color: var(--text-light);
    font-size: 1rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .comercios-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2.5rem;
    }

    .filters-section {
        padding: 1rem 0;
    }

    .filters-form {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .filter-actions {
        justify-content: center;
    }

    .results-section {
        padding-top: 10rem;
    }

    .results-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .active-filters {
        text-align: center;
    }

    .filter-tags {
        justify-content: center;
    }

    .comercios-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .comercio-card {
        max-width: 400px;
        margin: 0 auto;
    }

    .no-results-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .page-header {
        padding: 3rem 0 1.5rem;
    }

    .page-title {
        font-size: 2rem;
    }

    .filters-section {
        padding: 0.75rem 0;
    }

    .filters-container {
        padding: 1rem;
        border-radius: 0.75rem;
    }

    .results-section {
        padding-top: 8rem;
    }

    .comercio-image {
        height: 180px;
    }

    .comercio-content {
        padding: 1rem;
    }

    .filter-input,
    .filter-select {
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
    }
}

/* Estilos para múltiples contactos */
.info-item {
    margin-bottom: 0.5rem;
}

.info-item:last-of-type {
    margin-bottom: 0;
}

.info-item i {
    color: var(--primary-color);
    margin-right: 0.5rem;
    width: 16px;
    text-align: center;
}

.info-item a {
    text-decoration: none;
    transition: color 0.3s ease;
}

.info-item a:hover {
    color: var(--primary-color);
}

.text-green-600 {
    color: #059669;
}

.text-green-600:hover {
    color: #047857;
}

.text-sm {
    font-size: 0.875rem;
}

.text-gray-500 {
    color: #6b7280;
}

.text-blue-600 {
    color: #2563eb;
}

.text-blue-600:hover {
    color: #1d4ed8;
}

.text-blue-800 {
    color: #1e40af;
}

.text-blue-800:hover {
    color: #1d4ed8;
}

.text-pink-600 {
    color: #db2777;
}

.text-pink-600:hover {
    color: #be185d;
}

.text-black {
    color: #000000;
}

.text-black:hover {
    color: #374151;
}

/* Mejoras para el contenedor de información */
.comercio-info {
    max-height: 200px;
    overflow-y: auto;
}

.comercio-info::-webkit-scrollbar {
    width: 4px;
}

.comercio-info::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.comercio-info::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.comercio-info::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = {{ $comercios->currentPage() }};
    let hasMorePages = {{ $comercios->hasMorePages() ? 'true' : 'false' }};
    let isLoading = false;
    
    const comerciosGrid = document.getElementById('comercios-grid');
    const loadingIndicator = document.getElementById('loading-indicator');
    const endResults = document.getElementById('end-results');
    
    // Función para cargar más comercios
    function loadMoreComercios() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        loadingIndicator.style.display = 'flex';
        
        const url = new URL(window.location.href);
        url.searchParams.set('page', currentPage + 1);
        
        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Agregar nuevos comercios al grid
            comerciosGrid.insertAdjacentHTML('beforeend', data.html);
            
            currentPage++;
            hasMorePages = data.hasMore;
            
            // Ocultar loading indicator
            loadingIndicator.style.display = 'none';
            
            // Mostrar end results si no hay más páginas
            if (!hasMorePages && endResults) {
                endResults.style.display = 'flex';
            }
            
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading more comercios:', error);
            loadingIndicator.style.display = 'none';
            isLoading = false;
        });
    }
    
    // Scroll infinito
    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        
        // Cargar más cuando se está cerca del final (200px antes)
        if (scrollTop + windowHeight >= documentHeight - 200) {
            loadMoreComercios();
        }
    }
    
    // Event listener para scroll
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Auto-aplicar filtros cuando cambian los inputs
    const filtersForm = document.getElementById('filters-form');
    const buscarInput = document.getElementById('buscar');
    const categoriaSelect = document.getElementById('categoria');
    const ubicacionInput = document.getElementById('ubicacion');
    
    let filterTimeout;
    
    function autoApplyFilters() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            filtersForm.submit();
        }, 800); // Esperar 800ms después de dejar de escribir
    }
    
    // Auto-aplicar filtros en inputs de texto
    buscarInput?.addEventListener('input', autoApplyFilters);
    ubicacionInput?.addEventListener('input', autoApplyFilters);
    
    // Auto-aplicar filtros en select inmediatamente
    categoriaSelect?.addEventListener('change', function() {
        filtersForm.submit();
    });
});
</script>
@endsection