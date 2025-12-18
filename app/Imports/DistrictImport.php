<?php

namespace App\Imports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;

class DistrictImport implements ToModel
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
        $city_id = $array[1];
        $name = $array[2];

        District::insert([
            'id' => $id,
            'city_id' => $city_id,
            'name' => $name,
            'created_by' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
