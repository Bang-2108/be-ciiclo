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

        $this->app->singleton(\App\Repositories\ProfileRepository::class, function ($app) {
            return new \App\Repositories\ProfileRepository(new \App\Models\Profile());
        });
        $this->app->singleton(\App\Services\ProfileService::class, function ($app) {
            return new \App\Services\ProfileService($app->make(\App\Repositories\ProfileRepository::class));
        });

        $this->app->singleton(\App\Repositories\SkillRepository::class, function ($app) {
            return new \App\Repositories\SkillRepository(new \App\Models\Skill());
        });
        $this->app->singleton(\App\Services\SkillService::class, function ($app) {
            return new \App\Services\SkillService($app->make(\App\Repositories\SkillRepository::class));
        });
    }
    public function boot(): void
    {
        //
    }
}
