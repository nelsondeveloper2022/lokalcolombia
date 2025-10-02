<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Comercios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Lista de Comercios</h3>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Nuevo Comercio
                        </button>
                    </div>

                    <!-- Filtros -->
                    <form method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="flex items-center space-x-2">
                                <label for="estado" class="text-sm font-medium text-gray-700">Estado:</label>
                                <select name="estado" id="estado" class="border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="2" {{ request('estado') == '2' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="3" {{ request('estado') == '3' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Eliminado</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="search" class="text-sm font-medium text-gray-700">Buscar:</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       placeholder="Título del comercio..." 
                                       class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                                Filtrar
                            </button>
                            <a href="{{ route('admin.comercios') }}" 
                               class="bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-400">
                                Limpiar
                            </a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Comercio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Responsable
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categoría/Tipo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($comercios as $comercio)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($comercio->rutaPortada)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $comercio->rutaPortada) }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-gray-700">{{ substr($comercio->titulo ?? 'SC', 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                @endif
                                                    <div class="text-sm font-medium text-gray-900">{{ $comercio->titulo ?? 'Sin título' }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($comercio->descripcionCorta ?? 'Sin descripción', 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $comercio->responsable ?? 'No asignado' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $comercio->actualizadoEn ? $comercio->actualizadoEn->diffForHumans() : 'Sin fecha' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $comercio->categoria->nombre ?? 'Sin categoría' }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $comercio->tipoComercioServicio->nombre ?? 'Sin tipo' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $estadoColors = [
                                                    0 => ['bg-gray-100', 'text-gray-800', 'Eliminado'],
                                                    1 => ['bg-yellow-100', 'text-yellow-800', 'Pendiente'],
                                                    2 => ['bg-green-100', 'text-green-800', 'Aprobado'],
                                                    3 => ['bg-red-100', 'text-red-800', 'Rechazado']
                                                ];
                                                $estadoInfo = $estadoColors[$comercio->estado] ?? ['bg-gray-100', 'text-gray-800', 'Desconocido'];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoInfo[0] }} {{ $estadoInfo[1] }}">
                                                {{ $estadoInfo[2] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            #{{ $comercio->idMarketComerciosServicios }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-green-600 hover:text-green-900" title="Editar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                @if($comercio->estado == 1)
                                                    <button class="text-emerald-600 hover:text-emerald-900" title="Aprobar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-900" title="Rechazar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No hay comercios registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $comercios->links() }}
                    </div>

                    <!-- Estadísticas -->
                    <div class="mt-6 border-t pt-4">
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                            <div class="bg-blue-50 p-3 rounded">
                                <div class="text-lg font-semibold text-blue-600">{{ $estadisticas['total'] }}</div>
                                <div class="text-sm text-gray-600">Total</div>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded">
                                <div class="text-lg font-semibold text-yellow-600">{{ $estadisticas['pendientes'] }}</div>
                                <div class="text-sm text-gray-600">Pendientes</div>
                            </div>
                            <div class="bg-green-50 p-3 rounded">
                                <div class="text-lg font-semibold text-green-600">{{ $estadisticas['aprobados'] }}</div>
                                <div class="text-sm text-gray-600">Aprobados</div>
                            </div>
                            <div class="bg-red-50 p-3 rounded">
                                <div class="text-lg font-semibold text-red-600">{{ $estadisticas['rechazados'] }}</div>
                                <div class="text-sm text-gray-600">Rechazados</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <div class="text-lg font-semibold text-gray-600">{{ $estadisticas['eliminados'] }}</div>
                                <div class="text-sm text-gray-600">Eliminados</div>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-sm text-gray-500">
                            Mostrando {{ $comercios->firstItem() ?? 0 }} a {{ $comercios->lastItem() ?? 0 }} de {{ $comercios->total() }} resultados
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>