@if ($paginator->hasPages())
    <nav class="pagination-nav" role="navigation" aria-label="Navegación de páginas">
        <div class="pagination-container">
            <div class="pagination-info">
                <p class="pagination-text">
                    Mostrando
                    <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    a
                    <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="font-semibold">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <div class="pagination-links">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="pagination-link disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span class="sr-only">Anterior</span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="sr-only">Anterior</span>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="pagination-dots">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-link active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link" rel="next">
                        <i class="fas fa-chevron-right"></i>
                        <span class="sr-only">Siguiente</span>
                    </a>
                @else
                    <span class="pagination-link disabled">
                        <i class="fas fa-chevron-right"></i>
                        <span class="sr-only">Siguiente</span>
                    </span>
                @endif
            </div>
        </div>
    </nav>

    <style>
        .pagination-nav {
            margin: 2rem 0;
        }

        .pagination-container {
            display: flex;
            justify-content: between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            flex: 1;
        }

        .pagination-text {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0;
        }

        .pagination-text .font-semibold {
            font-weight: 600;
            color: var(--text-dark);
        }

        .pagination-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background: white;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-link:hover:not(.disabled):not(.active) {
            background: var(--bg-light);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .pagination-link.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .pagination-link.disabled {
            background: var(--bg-light);
            color: var(--text-light);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-dots {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            color: var(--text-light);
            font-weight: 500;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .pagination-container {
                flex-direction: column;
                text-align: center;
            }

            .pagination-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .pagination-link {
                min-width: 35px;
                height: 35px;
                font-size: 0.875rem;
            }

            .pagination-text {
                font-size: 0.75rem;
            }
        }
    </style>
@endif