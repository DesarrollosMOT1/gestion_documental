<?php

namespace App\Providers;

use App\Policies\AgrupacionesConsolidacionePolicy;
use App\Policies\OrdenesCompraPolicy;
use App\Policies\SolicitudesCompraPolicy;
use App\Policies\SolicitudesOfertaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Cotizacione;
use App\Models\OrdenesCompra;
use App\Models\SolicitudesCompra;
use App\Models\AgrupacionesConsolidacione;
use App\Models\SolicitudesOferta;
use App\Policies\CotizacionePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Cotizacione::class => CotizacionePolicy::class,
        OrdenesCompra::class => OrdenesCompraPolicy::class,
        SolicitudesOferta::class => SolicitudesOfertaPolicy::class,
        AgrupacionesConsolidacione::class => AgrupacionesConsolidacionePolicy::class,
        SolicitudesCompra::class => SolicitudesCompraPolicy::class,
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
