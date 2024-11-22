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
    public function view(User $user, SolicitudesCompra $solicitudesCompra): bool
    {
        // Si la solicitud pertenece al usuario autenticado, permitir acceso
        if ($solicitudesCompra->id_users === $user->id) {
            return true;
        }

        // Obtener los niveles uno permitidos para el usuario
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Verificar si hay elementos de la solicitud que coincidan con los niveles permitidos
        return collect($solicitudesCompra->solicitudesElemento)->contains(function ($elemento) use ($nivelesUnoIds) {
            return in_array($elemento->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
