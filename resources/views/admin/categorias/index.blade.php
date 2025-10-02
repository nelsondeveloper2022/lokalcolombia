<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Categorías
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Lista de Categorías</h3>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Nueva Categoría
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($categorias as $categoria)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $categoria->nombre }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $categoria->comercios_servicios_count }} comercios
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4">{{ $categoria->descripcion }}</p>
                                <div class="flex space-x-2">
                                    <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                        Editar
                                    </button>
                                    <button class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay categorías</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva categoría.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginación -->
                    @if($categorias->hasPages())
                        <div class="mt-6">
                            {{ $categorias->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>