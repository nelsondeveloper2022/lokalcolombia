<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        Log::info('Email verification started', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'already_verified' => $user->hasVerifiedEmail(),
            'email_verified_at' => $user->email_verified_at
        ]);

        if ($user->hasVerifiedEmail()) {
            Log::info('Email already verified, redirecting');
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        $result = $user->markEmailAsVerified();
        Log::info('Mark email as verified result', [
            'result' => $result,
            'user_id' => $user->id,
            'email_verified_at_after' => $user->fresh()->email_verified_at
        ]);

        if ($result) {
            Log::info('Firing Verified event');
            event(new Verified($user));
        }

        Log::info('Email verification completed, redirecting');
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
