<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    public ?string $error = null;

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): bool
    {
        $this->validate();
        $this->error = null;

        try {
            // Try admin authentication first
            if (Auth::guard('admin')->attempt([
                'email' => $this->email,
                'password' => $this->password,
            ], $this->remember)) {
                session()->regenerate();
                redirect()->intended(route('admin.dashboard'));
                return true;
            }

            // If not admin, try regular user authentication
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password,
            ], $this->remember)) {
                session()->regenerate();
                return true;
            }

            // If both authentications fail
            $this->addError('email', 'These credentials do not match our records.');
            $this->error = 'Invalid credentials. Please check your email and password.';
            return false;

        } catch (\Exception $e) {
            $this->addError('email', 'An error occurred during authentication.');
            $this->error = 'Authentication error. Please try again later.';
            return false;
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
