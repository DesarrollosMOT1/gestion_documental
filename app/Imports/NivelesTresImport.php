<?php

namespace App\Imports;

use App\Models\NivelesTres;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NivelesTresImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $rows = $collection->skip(1);

        foreach ($rows as $row) {
            NivelesTres::updateOrCreate(
                ['nombre' => $row[1]], 
                [
                    
                    'id_niveles_dos' => (int) $row[2],
                    'id_referencias_gastos' => $row[3],
                    'inventario' => (int) $row[4]
                ]
            );
        }
    }
}