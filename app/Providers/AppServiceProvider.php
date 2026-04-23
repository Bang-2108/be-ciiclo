<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
       public function register(): void
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository(new User());
        });

        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService($app->make(UserRepository::class));
        });
    }
    public function boot(): void
    {
        //
    }
}