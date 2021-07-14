<?php

namespace App\Imports;

use App\Ubigeo;
use Maatwebsite\Excel\Concerns\ToModel;

class UbigeosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ubigeo=Ubigeo::where('code', $row[0])->first();
        if (!is_null($ubigeo) || ($row[0]=="IDDIST")) {
            return null;
        }

        return new Ubigeo([
            'code' => $row[0],
            'department' => $row[1],
            'province' => $row[2],
            'district' => $row[3],
            'capital' => $row[4]
        ]);
    }
}
