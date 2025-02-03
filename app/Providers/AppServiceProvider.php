<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\SearchProducts;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        // $loader->alias('User', 'App\Models\User');
        // $loader->alias('Admin', 'App\Models\Admin');
        // $loader->alias 
        Livewire::component('search-products', SearchProducts::class);
    }
}
