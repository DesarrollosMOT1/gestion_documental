<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrdenesCompra;
use App\Traits\VerNivelesPermiso;

class OrdenesCompraPolicy
{
    use VerNivelesPermiso;
    /**
     * Create a new policy instance.
     */
    public function view(User $user, OrdenesCompra $ordenesCompra): bool
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Lógica para verificar si el usuario tiene acceso a la cotización
        return collect($ordenesCompra->ordenesCompraCotizaciones)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->solicitudesElemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
