<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Cotizacione;
use App\Policies\CotizacionePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Cotizacione::class => CotizacionePolicy::class,
    ];
    
        /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
