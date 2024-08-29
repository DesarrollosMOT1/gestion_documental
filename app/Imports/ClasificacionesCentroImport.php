<?php

namespace App\Imports;

use App\Models\ClasificacionesCentro;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClasificacionesCentroImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1);  // Saltar la primera fila (cabecera)

        foreach ($rows as $row) {
            ClasificacionesCentro::updateOrCreate(
                ['nombre' => $row[0]],  // Actualizar o crear por nombre
                [
                    'id_areas' => $row[1]
                ]
            );
        }
    }
}
