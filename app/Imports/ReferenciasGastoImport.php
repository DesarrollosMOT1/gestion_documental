<?php

namespace App\Imports;

use App\Models\ReferenciasGasto;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ReferenciasGastoImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1); // Ignorar la primera fila

        foreach ($rows as $row) {
            ReferenciasGasto::updateOrCreate(
                ['codigo' => $row[0]], // Buscar por código
                [
                    'nombre' => $row[1]
                ]
            );
        }
    }
}