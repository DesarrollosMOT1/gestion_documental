<?php

namespace App\Imports;

use App\Models\CentrosCosto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CentrosCostosImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1);  // Saltar la primera fila (cabecera)

        foreach ($rows as $row) {
            CentrosCosto::updateOrCreate(
                ['codigo_mekano' => $row[1]], // Buscar por código
                [
                    'nombre' => $row[2],
                    'id_clasificaciones_centros' => $row[3]
                ]
            );
        }
    }
}
