<?php

namespace App\Imports;

use App\Models\Village;
use Maatwebsite\Excel\Concerns\ToModel;

class VillageImport implements ToModel
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
        $district_id = $array[1];
        $name = $array[2];

        Village::insert([
            'id' => $id,
            'district_id' => $district_id,
            'name' => $name,
            'created_by' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
