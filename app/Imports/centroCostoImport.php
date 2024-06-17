<?php

namespace App\Imports;

use App\Models\CentroCosto;
use Maatwebsite\Excel\Concerns\ToModel;

class centroCostoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CentroCosto([
            'codigo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
