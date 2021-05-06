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
            'engineer_id' => $row['engineer_code'],
            'point' => $row['point'],
            'created_at' => $row['job_source_create'],
            'updated_at' => $row['job_source_update'],
        ]);
    }

    public function rules(): array
    {
        return [
            'engineer_code' => 'required',
        ];
    }


}
