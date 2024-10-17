<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SolicitudesOferta;
use App\Traits\VerNivelesPermiso;

class SolicitudesOfertaPolicy
{
    use VerNivelesPermiso;
    /**
     * Create a new policy instance.
     */
    public function view(User $user, solicitudesOferta $solicitudesOferta): bool
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Lógica para verificar si el usuario tiene acceso a la cotización
        return collect($solicitudesOferta->consolidacionesOfertas)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->solicitudesElemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
