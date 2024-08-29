<?php

namespace App\Imports;

use App\Models\NivelesUno;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NivelesUnoImport implements ToCollection
{
    /**
     * @param Collection $collection
     *
     * @return void
     */
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1);

        foreach ($rows as $row) {
            NivelesUno::updateOrCreate(
                ['id' => $row[0]], // Buscar por ID
                [
                    'nombre' => $row[1], 
                    'inventario' => (int) $row[2]
                ]
            );
        }
    }
}
