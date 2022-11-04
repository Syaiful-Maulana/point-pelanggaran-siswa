<?php

namespace App\Imports;

use App\Models\Bentuk;
use Maatwebsite\Excel\Concerns\ToModel;

class BentukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Bentuk([
            'kategori' => $row[1],
            'bentuk' => $row[2],
            'bobot' => $row[3]
        ]);
    }
}
