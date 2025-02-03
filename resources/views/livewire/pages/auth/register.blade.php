<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="bg-gray-50 min-h-screen">
        <!-- Page Header -->
        <div class="bg-black text-white py-12">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-light text-center tracking-wider">CREATE AN ACCOUNT</h1>
                <p class="text-center text-gray-400 mt-4">Join Vintilux & Co. for an exclusive shopping experience</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16">
            <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-sm">
                <form wire:submit="register" class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Name</label>
                        <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Email</label>
                        <input wire:model="email" id="email" type="email" name="email" required autocomplete="username"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Password</label>
                        <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Confirm Password</label>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('login') }}" wire:navigate 
                           class="text-sm text-gray-600 hover:text-black transition-colors duration-200 uppercase tracking-wider">
                            Already registered?
                        </a>

                        <button type="submit" 
                                class="px-6 py-2 bg-black text-white text-sm uppercase tracking-wider hover:bg-gray-800 transition-colors duration-200">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @include('livewire.layout.footer')
    </div>
</div>
