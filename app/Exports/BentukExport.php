<?php

namespace App\Exports;

use App\Models\Bentuk;
use Maatwebsite\Excel\Concerns\FromCollection;

class BentukExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bentuk::all();
    }
}
