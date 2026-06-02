<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Contact;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\SkillRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ContactRepository;
use App\Services\AuthService;
use App\Services\ProfileService;
use App\Services\SkillService;
use App\Services\ProjectService;
use App\Services\ContactService;
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

        $this->app->singleton(ProjectRepository::class, function ($app) {
            return new ProjectRepository(new Project());
        });

        $this->app->singleton(ProjectService::class, function ($app) {
            return new ProjectService(
                $app->make(ProjectRepository::class),
                $app->make(ProfileRepository::class),
                $app->make(StorageService::class)
            );
        });
        $this->app->singleton(ContactRepository::class, function ($app) {
            return new ContactRepository(new Contact());
        });
        $this->app->singleton(ContactService::class, function ($app) {
            return new ContactService(
                $app->make(ContactRepository::class)
            );
        });
    }
    public function boot(): void
    {
        //
    }
}
