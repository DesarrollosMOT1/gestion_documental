<?php

namespace App\Imports;

use App\Models\Tercero;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TercerosImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1); // Ignorar la primera fila

        foreach ($rows as $row) {
            Tercero::updateOrCreate(
                ['nit' => $row[0]], // Buscar por id
                [
                    'tipo_factura' => $row[1],
                    'nombre' => $row[2]
                ]
            );
        }
    }
}
