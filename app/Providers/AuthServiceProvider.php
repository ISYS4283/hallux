<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Connection;
use App\Policies\ConnectionPolicy;
use App\Query;
use App\Policies\QueryPolicy;
use App\Quiz;
use App\Policies\QuizPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Connection::class => ConnectionPolicy::class,
        Query::class => QueryPolicy::class,
        Quiz::class => QuizPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
