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

                // using this to override Illuminate\Auth\EloquentUserProvider
        \Illuminate\Support\Facades\Auth::provider('accountuserprovider', function($app, array $config) {
            return new Custom\EloquentUserProvider($app['hash'], $config['model']);
        });

    }
}
