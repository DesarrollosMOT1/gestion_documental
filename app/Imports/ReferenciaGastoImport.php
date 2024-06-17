<?php

namespace App\Imports;

use App\Models\ReferenciaGasto;
use Maatwebsite\Excel\Concerns\ToModel;

class ReferenciaGastoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ReferenciaGasto([
            'codigo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
