<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('AdminAccess', function ($user) {
            return (in_array($user->user_role_id, [1, 2, 3]) AND $user->is_ban == 0);
        });

        Gate::define('NormalAdminAcess', function ($user) {
            return (in_array($user->user_role_id, [1, 2]) AND $user->is_ban == 0);
        });

        Gate::define('SuperAdminAccess', function ($user) {
            return (in_array($user->user_role_id, [1]) AND $user->is_ban == 0);
        });
    }
}
