<?php

namespace App\Imports;

use App\Engineer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EngineerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return Engineer::where('email', $row['email'])->update([
            "installer_id" => $row['installer_id'],
            "point" => $row['point'],
        ]);
    }
}
