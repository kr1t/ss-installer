<?php

namespace App\Imports;

use App\EngineerPoint;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PointsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//        $engineer_id = (Engineer::where('installer_id', $row['Engineer_Code'])->first(['id']))->id;

        return new EngineerPoint([
            'engineer_id' => $row['Engineer_Code'],
            'point' => $row['Point'],
            'created_at' => $row['Job_Source_Create'],
            'updated_at' => $row['Job_Source_Update'],
        ]);
    }
}
