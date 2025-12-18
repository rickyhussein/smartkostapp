<?php

namespace App\Imports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;

class ProvinceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $array = explode(",", $row[0]);
        $id = $array[0];
        $name = $array[1];

        Province::insert([
            'id' => $id,
            'name' => $name,
            'created_by' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
