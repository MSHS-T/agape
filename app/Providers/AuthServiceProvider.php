<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\ProjectCallType;
use App\Models\User;
use App\Policies\ProjectCallTypePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ProjectCallType::class => ProjectCallTypePolicy::class,
        User::class            => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if (App::isLocal() && !App::runningInConsole()) {
            // $this->app['auth']->setUser(User::role('administrator')->first());
            // $this->app['auth']->setUser(User::role('applicant')->first());
            // $this->app['auth']->setUser(User::role('expert')->first());
        }
    }
}
