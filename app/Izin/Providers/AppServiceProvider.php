<?php

namespace App\Izin\Providers;

use App\Izin\View\Components\AppLayout;
use App\Izin\View\Components\GuestLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::component('guest-layout', GuestLayout::class);
        Blade::component('app-layout', AppLayout::class);
    }
}
