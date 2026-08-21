<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

         $user = $request->user();

        // 1. Si le client venait d'un clic sur un créneau de rendez-vous
        if ($request->filled('redirect') && $user->isClient()) {
            return redirect()->to($request->input('redirect'));
        }

        // 2. Sinon redirection standard selon son rôle
        if ($user->isAdministrateur()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDirecteurTechnique()) {
            return redirect()->route('directeur.dashboard');
        } elseif ($user->isChefDepartement()) {
            return redirect()->route('chef.dashboard');
        } elseif ($user->isReceptionniste()) {
            return redirect()->route('receptionniste.dashboard');
        } elseif ($user->isClient()) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
