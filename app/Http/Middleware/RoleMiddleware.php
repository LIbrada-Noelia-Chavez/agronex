<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * 🧩 Middleware de control de roles
     * 
     * Verifica que el usuario autenticado tenga uno de los roles permitidos.
     * Si no tiene el rol adecuado, redirige al dashboard con un mensaje de error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Lista de roles permitidos
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 🔒 1️⃣ Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        $user = Auth::user();

        // 🧩 2️⃣ Si no se especifican roles, permite continuar (útil en pruebas o rutas abiertas)
        if (count($roles) === 0) {
            return $next($request);
        }

        // ✅ 3️⃣ Si el usuario tiene uno de los roles permitidos, continúa
        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // 🚫 4️⃣ Si no tiene permiso, redirige al dashboard con un mensaje
        return redirect()
            ->route('dashboard')
            ->with('error', '⚠️ No tienes permisos para acceder a esta página.');
    }
}
