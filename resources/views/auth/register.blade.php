<x-guest-layout>
    <!-- Encabezado -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-green-700">Crear una cuenta</h1>
        <p class="text-gray-600 mt-1">Regístrate para acceder a <span class="font-semibold text-green-600">AgroNex</span></p>
    </div>

    <!-- Formulario de registro -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre completo')" />
            <x-text-input id="name" class="block mt-1 w-full"
                          type="text"
                          name="name"
                          :value="old('name')"
                          required autofocus
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Correo electrónico -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Rol -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Seleccionar rol')" />
            <select id="role" name="role"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm
                           focus:ring-green-500 focus:border-green-500"
                    required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Selecciona un rol --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="capataz_cultivo" {{ old('role') == 'capataz_cultivo' ? 'selected' : '' }}>Capataz de Cultivo</option>
                <option value="capataz_ganado" {{ old('role') == 'capataz_ganado' ? 'selected' : '' }}>Capataz de Ganado</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-green-700
                      rounded-md focus:outline-none focus:ring-2
                      focus:ring-offset-2 focus:ring-green-500"
               href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
            </a>

            <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700 focus:ring-green-500">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
