<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SolicitudesCompra;
use App\Traits\VerNivelesPermiso;

class SolicitudesCompraPolicy
{
    use VerNivelesPermiso;
    /**
     * Create a new policy instance.
     */
    public function view(User $user, solicitudesCompra $solicitudesCompra): bool
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Lógica para verificar si el usuario tiene acceso a la cotización
        return collect($solicitudesCompra->solicitudesElemento)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
