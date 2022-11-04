<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Siswa([
            'nisn'=> $row[1],
            'password'=> bcrypt($row[2]),
            'nama' => $row[3],
            'tempat' => $row[4],
            'jekel' => $row[5],
            'ttl' => $row[6],
            'kelas_id' => $row[7],
            // 'level' => $row[8],
            'alamat' => $row[8]
        ]);
    }
}
