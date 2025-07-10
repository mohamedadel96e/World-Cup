<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Weapon;
use App\Policies\WeaponPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Register the WeaponPolicy
        Weapon::class => WeaponPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        // --- Define General Gates ---

        /*
         * Gate to check if a user can perform any CRUD action.
         * This is explicitly for the 'admin' role.
         */
        Gate::define('manage-all', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('use-emails', function (User $user) {
            return $user->isAdmin() || $user->isCountryUser() || $user->isGeneral();
        });
    }
}
