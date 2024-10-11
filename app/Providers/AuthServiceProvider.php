<?php

namespace App\Providers;

use App\Policies\OrdenesCompraPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Cotizacione;
use App\Models\OrdenesCompra;
use App\Policies\CotizacionePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Cotizacione::class => CotizacionePolicy::class,
        OrdenesCompra::class => OrdenesCompraPolicy::class,
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
