<?php

namespace App\Exports;

use App\Engineer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EngineerExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */



    public function view(): View
    {
        return view('exports.engineer', [
            'enginneers' => Engineer::all()
        ]);
    }
}
