<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;

class CityImport implements ToModel
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
        $province_id = $array[1];
        $name = $array[2];

        City::insert([
            'id' => $id,
            'province_id' => $province_id,
            'name' => $name,
            'created_by' => auth()->user() ? auth()->user()->id : 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
