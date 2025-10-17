<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AgroNex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-leaf text-white"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">AgroNex</h1>
                </div>
                <nav class="flex space-x-4">
                    <a href="/dashboard" class="text-green-600 font-medium">Dashboard</a>
                    <a href="/cultivos" class="text-gray-600 hover:text-green-600">Cultivos</a>
                    <a href="/ganado" class="text-gray-600 hover:text-green-600">Ganado</a>
                    <a href="/inventario" class="text-gray-600 hover:text-green-600">Inventario</a>
                    <a href="/sensores" class="text-gray-600 hover:text-green-600">Sensores</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header del Dashboard -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard AgroNex</h1>
                <p class="text-gray-600">Resumen general de tu operación agropecuaria</p>
            </div>

            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Cultivos -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-seedling text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Cultivos
                                    </dt>
                                    <dd class="text-2xl font-semibold text-gray-900">
                                        {{ $totalCrops }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ganado -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-cow text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Ganado
                                    </dt>
                                    <dd class="text-2xl font-semibold text-gray-900">
                                        {{ $totalGanado }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventario -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="fas fa-warehouse text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Items Inventario
                                    </dt>
                                    <dd class="text-2xl font-semibold text-gray-900">
                                        {{ $totalInventory }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alertas Activas -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Alertas Activas
                                    </dt>
                                    <dd class="text-2xl font-semibold text-red-600">
                                        {{ $inventarioBajoStock + $cultivosEnfermos + $ganadoEnfermo }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos y Estadísticas Detalladas -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
                <!-- Estado de Cultivos -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estado de Cultivos</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Saludables</span>
                            <span class="text-sm font-semibold text-green-600">{{ $cultivosSaludables }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalCrops > 0 ? ($cultivosSaludables/$totalCrops)*100 : 0 }}%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">En Riesgo</span>
                            <span class="text-sm font-semibold text-yellow-600">{{ $cultivosRiesgo }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalCrops > 0 ? ($cultivosRiesgo/$totalCrops)*100 : 0 }}%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Enfermos</span>
                            <span class="text-sm font-semibold text-red-600">{{ $cultivosEnfermos }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalCrops > 0 ? ($cultivosEnfermos/$totalCrops)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Estado de Ganado -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estado de Ganado</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Saludable</span>
                            <span class="text-sm font-semibold text-green-600">{{ $ganadoSaludable }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalGanado > 0 ? ($ganadoSaludable/$totalGanado)*100 : 0 }}%"></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Enfermo</span>
                            <span class="text-sm font-semibold text-red-600">{{ $ganadoEnfermo }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalGanado > 0 ? ($ganadoEnfermo/$totalGanado)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas y Acciones Rápidas -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Alertas -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Alertas</h3>
                    <div class="space-y-3">
                        @if($inventarioBajoStock > 0)
                        <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">
                                    {{ $inventarioBajoStock }} items con bajo stock
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($cultivosEnfermos > 0)
                        <div class="flex items-center p-3 bg-red-50 rounded-lg">
                            <i class="fas fa-times-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">
                                    {{ $cultivosEnfermos }} cultivos enfermos
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($ganadoEnfermo > 0)
                        <div class="flex items-center p-3 bg-red-50 rounded-lg">
                            <i class="fas fa-times-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">
                                    {{ $ganadoEnfermo }} animales enfermos
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($inventarioBajoStock == 0 && $cultivosEnfermos == 0 && $ganadoEnfermo == 0)
                        <div class="flex items-center p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-green-800">
                                    Todo en orden
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="/cultivos" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <i class="fas fa-seedling text-green-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium text-green-800">Ver Cultivos</p>
                                <p class="text-sm text-green-600">Gestionar cultivos</p>
                            </div>
                        </a>

                        <a href="/inventario/create" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <i class="fas fa-box text-blue-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium text-blue-800">Agregar Inventario</p>
                                <p class="text-sm text-blue-600">Nuevo item</p>
                            </div>
                        </a>

                        <a href="/ganado" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <i class="fas fa-cow text-yellow-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium text-yellow-800">Ver Ganado</p>
                                <p class="text-sm text-yellow-600">Gestionar animales</p>
                            </div>
                        </a>

                        <a href="/inventario" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <i class="fas fa-warehouse text-purple-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium text-purple-800">Ver Inventario</p>
                                <p class="text-sm text-purple-600">Gestionar stock</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-gray-500 text-sm">
                AgroNex - Plataforma de Gestión Agropecuaria &copy; 2024
            </p>
        </div>
    </footer>

    <!-- Incluir Font Awesome para los íconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>