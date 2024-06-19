<?php

namespace App\Imports;

use App\Models\LineasGasto;
use Maatwebsite\Excel\Concerns\ToModel;

class lineasGastoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LineasGasto([
            'codigo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
