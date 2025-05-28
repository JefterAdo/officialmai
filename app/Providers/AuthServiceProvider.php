<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Document;
use App\Models\Communique;
use App\Policies\UserPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\CommuniquePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Document::class => DocumentPolicy::class,
        Communique::class => CommuniquePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        
        // Définir des gates personnalisées
        Gate::define('manage-users', function (User $user) {
            return $user->hasAnyRole(['super-admin', 'admin']);
        });
        
        Gate::define('manage-roles', function (User $user) {
            return $user->hasRole('super-admin');
        });
        
        Gate::define('access-admin', function (User $user) {
            return $user->hasAnyRole(['super-admin', 'admin', 'editor']);
        });
    }
}
