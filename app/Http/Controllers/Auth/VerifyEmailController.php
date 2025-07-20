<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user());
    }

    private function redirectBasedOnRole($user): RedirectResponse
    {
        return match ($user->role) {
            'admin' => redirect()->route('dashboard', ['verified' => 1]), // or 'admin.dashboard'
            'user'  => redirect()->route('user.dashboard', ['verified' => 1]),
            default => redirect()->route('login')->with('error', 'Invalid role.'),
        };
    }
}
