<?php

namespace App\Traits;

trait GenerarPrefijo
{
    public function generatePrefix(): string
    {
        $month = strtoupper(date('M')); // Obtiene las primeras tres letras del mes actual
        $year = date('y'); // Obtiene los últimos dos dígitos del año actual
        return $month . $year;
    }
}
