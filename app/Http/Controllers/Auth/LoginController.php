<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirigir al usuario después del inicio de sesión según su rol.
     */
    public function redirectTo()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return '/dashboard';

            case 'capataz_cultivo':
                return '/cultivos';

            case 'capataz_ganado':
                return '/ganado';

            default:
                return '/dashboard';
        }
    }

    /**
     * Maneja el proceso de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo());
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión y redirige al login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
