<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            {{ __('Panel Principal - AgroNex') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Mensaje de bienvenida -->
                    <h3 class="text-2xl font-bold text-green-700 mb-4">
                        👋 ¡Bienvenido, {{ Auth::user()->name }}!
                    </h3>

                    <p class="text-gray-600 mb-6">
                        Estás ingresando como
                        <span class="font-semibold text-green-600">
                            {{ Auth::user()->getRoleNameAttribute() }}
                        </span>.
                    </p>

                    <!-- Contenido dinámico según el rol -->
                    @if (Auth::user()->isAdmin())
                        <div class="p-4 bg-green-100 border border-green-300 rounded-lg mb-4">
                            <h4 class="font-semibold text-green-800 mb-2">Panel del Administrador General</h4>
                            <p class="text-gray-700">Desde aquí puedes gestionar toda la información del sistema, incluyendo:</p>
                            <ul class="list-disc list-inside mt-2 text-gray-700">
                                <li>Usuarios y roles</li>
                                <li>Gestión de cultivos y producción</li>
                                <li>Control de ganado y reportes</li>
                            </ul>
                        </div>
                    @elseif (Auth::user()->isCapatazCultivo())
                        <div class="p-4 bg-yellow-100 border border-yellow-300 rounded-lg mb-4">
                            <h4 class="font-semibold text-yellow-800 mb-2">Panel del Capataz de Cultivo</h4>
                            <p class="text-gray-700">Puedes gestionar todas las tareas y datos relacionados con los cultivos.</p>
                            <ul class="list-disc list-inside mt-2 text-gray-700">
                                <li>Registrar y monitorear siembras</li>
                                <li>Controlar riegos y fertilización</li>
                                <li>Visualizar reportes generales</li>
                            </ul>
                        </div>
                    @elseif (Auth::user()->isCapatazGanado())
                        <div class="p-4 bg-blue-100 border border-blue-300 rounded-lg mb-4">
                            <h4 class="font-semibold text-blue-800 mb-2">Panel del Capataz de Ganado</h4>
                            <p class="text-gray-700">Puedes administrar todo lo relacionado con el manejo del ganado.</p>
                            <ul class="list-disc list-inside mt-2 text-gray-700">
                                <li>Registro de animales</li>
                                <li>Control de alimentación y salud</li>
                                <li>Visualización de reportes generales</li>
                            </ul>
                        </div>
                    @else
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-lg mb-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Rol no reconocido</h4>
                            <p class="text-gray-700">Tu cuenta no tiene un rol válido asignado. Contacta con el administrador.</p>
                        </div>
                    @endif

                    <!-- Enlace para cerrar sesión -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-6">
                        @csrf
                        <x-primary-button class="bg-red-600 hover:bg-red-700">
                            {{ __('Cerrar sesión') }}
                        </x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
