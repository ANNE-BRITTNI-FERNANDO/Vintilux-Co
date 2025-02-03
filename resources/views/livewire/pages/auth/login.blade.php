<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        
        if ($this->form->authenticate()) {
            if (auth()->guard('admin')->check()) {
                $this->redirect(route('admin.dashboard'));
            } else if (auth()->check()) {
                $this->redirect(route('dashboard'));
            }
        }
    }
}; ?>


<div>
    <div class="bg-gray-50 min-h-screen">
        <!-- Page Header -->
        <div class="bg-black text-white py-12">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-light text-center tracking-wider">LOGIN</h1>
                <p class="text-center text-gray-400 mt-4">Welcome back to Vintilux & Co.</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16">
            <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-sm">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if($form->error)
                    <div class="mb-4 font-medium text-sm text-red-600">
                        {{ $form->error }}
                    </div>
                @endif

                <form wire:submit="login" class="space-y-6">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Email</label>
                        <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Password</label>
                        <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember" class="inline-flex items-center">
                            <input wire:model="form.remember" id="remember" type="checkbox" 
                                   class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                            <span class="ms-2 text-sm text-gray-600 uppercase tracking-wider">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" wire:navigate 
                               class="text-sm text-gray-600 hover:text-black transition-colors duration-200 uppercase tracking-wider">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-col space-y-4 pt-4">
                        <button type="submit" 
                                class="w-full px-6 py-2 bg-black text-white text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors duration-200">
                            Log in
                        </button>

                        <div class="text-center">
                            <span class="text-sm text-gray-600">Don't have an account?</span>
                            <a href="{{ route('register') }}" wire:navigate 
                               class="text-sm text-gray-900 hover:text-black transition-colors duration-200 uppercase tracking-wider ml-2">
                                Register Now
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('livewire.layout.footer')
    </div>
</div>
