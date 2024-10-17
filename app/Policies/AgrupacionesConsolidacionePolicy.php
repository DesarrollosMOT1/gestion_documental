<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AgrupacionesConsolidacione;
use App\Traits\VerNivelesPermiso;

class AgrupacionesConsolidacionePolicy
{
    use VerNivelesPermiso;
    /**
     * Create a new policy instance.
     */
    public function view(User $user, agrupacionesConsolidacione $agrupacionesConsolidacione): bool
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Lógica para verificar si el usuario tiene acceso a la cotización
        return collect($agrupacionesConsolidacione->consolidaciones)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->solicitudesElemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
