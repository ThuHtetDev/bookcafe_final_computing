<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(); 

        // Define User is admin
        Gate::define('isAdmin',function($user){
            return $user->type == 'admin';
        });

        // Both Admin & Superadmin Accessment
        Gate::define('manage-administration',function($user){
            if($user->type == 'admin' || $user->type == 'superadmin' ){
                return true;
            }
        });

        // All Accessment
        Gate::define('manage-all',function($user){
            if($user->type == 'admin' || $user->type == 'superadmin' || $user->type == 'member' ){
                return true;
            }
        });

        // Define User is SuperAdmin
        Gate::define('isSuperadmin',function($user){
            return $user->type == 'superadmin';
        });

         // Define User is member
         Gate::define('isMember',function($user){
            return $user->type == 'member';
        });

    }
}
