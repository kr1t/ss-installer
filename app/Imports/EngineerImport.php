<?php

namespace App\Imports;

use App\Engineer;
use App\EngineerDraft;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;


class EngineerImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {

        $enginner = Engineer::where('email', $row['email'])->first();
        if ($enginner) {
            $draft = EngineerDraft::create($enginner);
            $draft->update([
                'installer_id' => $row['installer_id'],
                'point' => $row['point'],
            ]);
            return $enginner;
        } else {
            return [];
        }
    }
}
