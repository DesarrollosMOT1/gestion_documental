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
        // Verificar si el usuario tiene el permiso 'ver_solicitudes_usuario_autentificado'
        if ($user->hasPermissionTo('ver_solicitudes_usuario_autentificado')) {
            // Retorna verdadero si el id_users de la solicitud coincide con el ID del usuario autenticado
            return $solicitudesCompra->id_users === $user->id;
        }

        // Obtener los niveles uno permitidos según los permisos del usuario
        $nivelesUnoIds = $this->obtenerNivelesPermitidos();

        // Verificar si la solicitud de compra tiene elementos relacionados con los niveles uno permitidos
        return collect($solicitudesCompra->solicitudesElemento)->contains(function($solicitud) use ($nivelesUnoIds) {
            return in_array($solicitud->nivelesTres->nivelesDos->nivelesUno->id, $nivelesUnoIds);
        });
    }
}
