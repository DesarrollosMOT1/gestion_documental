<?php

namespace App\Imports;

use App\Models\NivelesDos;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NivelesDosImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1);

        foreach ($rows as $row) {
            NivelesDos::updateOrCreate(
                ['id' => $row[0]], // Buscar por ID
                [
                    'nombre' => $row[1], 
                    'id_niveles_uno' => (int) $row[2], // Ajusta según la relación con niveles uno
                    'inventario' => (int) $row[3]
                ]
            );
        }
    }
}
