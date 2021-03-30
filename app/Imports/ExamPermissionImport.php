<?php

namespace App\Imports;

use App\ExamPermission;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamPermissionImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExamPermission([
            'engineer_id' => $row['engineer_code'],
            'level' => $row['level'],
        ]);
    }
}
