<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('client.dashboard', absolute: false));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // 🎯 Redirige directement vers la réservation du RDV ou le dashboard
        return redirect()->intended(route('client.dashboard', absolute: false))
            ->with('success', 'Votre compte a été activé avec succès ! Vous pouvez maintenant finaliser votre rendez-vous.');
    }
}