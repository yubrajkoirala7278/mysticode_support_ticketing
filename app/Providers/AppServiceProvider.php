<?php

namespace App\Providers;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(RoleRepositoryInterface::class,RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
