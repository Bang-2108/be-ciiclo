<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\SkillRepository;
use App\Services\AuthService;
use App\Services\ProfileService;
use App\Services\SkillService;
use App\Services\StorageService;

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

        $this->app->singleton(SkillRepository::class, function ($app) {
            return new SkillRepository(new Skill());
        });
        $this->app->singleton(SkillService::class, function ($app) {
            return new SkillService(
                $app->make(SkillRepository::class),
                $app->make(ProfileRepository::class)
            );
        });

         $this->app->singleton(ProfileRepository::class, function ($app) {
            return new ProfileRepository(new Profile());
        });
        $this->app->singleton(ProfileService::class, function ($app) {
            return new ProfileService(
                $app->make(ProfileRepository::class),
                $app->make(StorageService::class) 
            );
        });

        $this->app->singleton(StorageService::class, function ($app) {
            return new StorageService();
        });
    }
    public function boot(): void
    {
        //
    }
}