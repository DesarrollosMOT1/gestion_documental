<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cotizacione;
use App\Traits\VerNivelesPermiso;

class CotizacionePolicy
{
    use VerNivelesPermiso;

    /**
     * Determine whether the user can view the cotizacione.
     */
    public function view(User $user, Cotizacione $cotizacione): bool
    {
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Lógica para verificar si el usuario tiene acceso a la cotización
        return collect($cotizacione->solicitudesCotizaciones)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->solicitudesElemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
