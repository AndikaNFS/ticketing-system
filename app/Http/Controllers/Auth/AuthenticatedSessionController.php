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
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            // return redirect()->route('dashboard');
            $user = Auth::user();

            if ($user->hasRole(['superadmin','admin','direksi'])) {
                return redirect()->route('dashboard');
            } elseif ($user->hasRole('hrd')) {
                return redirect()->route('schedules.index');
            } elseif ($user->hasRole(['building','building-user','maintenance','maintenance1'])) {
                return redirect()->route('building.tickets.index');
            } elseif ($user->hasRole(['user'])) {
                return redirect()->route('welcome');
            } else {
                return redirect()->route('welcome');

            }
        //     return match ($user->hasRole) {
        //     'superadmin|admin' => redirect()->route('dashboard'),
        //     'hrd' => redirect()->route('schedules'),
        //     'building' => redirect()->route('building.tickets.index'),
        //     default => abort(403, 'Unauthorized hasRole'),
        // };
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole(['superadmin','admin','direksi'])) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('hrd')) {
            return redirect()->route('schedules.index');
        } elseif ($user->hasRole(['building','building-user','maintenance','maintenance1'])) {
            return redirect()->route('building.tickets.index');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('welcome');
        } else {
        // abort(403, 'Unauthorized role');
                return redirect()->route('welcome');

        }

        return redirect()->intended(route('welcome', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
