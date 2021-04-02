<?php

namespace App\Exports;

use App\Engineer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class EngineerExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */



    public function view(): View
    {

        $request = request();
        if ($request->dates) {
            $dateExplode = explode('-', $request->dates);
            $start = Carbon::parse($dateExplode[0])->format('Y-m-d 00:00');
            $end = Carbon::parse($dateExplode[1])->format('Y-m-d 23:59');
            $type = $request->type;

            return view('exports.engineer', [
                'enginneers' => Engineer::where(function ($q) use ($type) {
                    switch ($type) {
                        case '1':
                            $q->where('notification_count', '<', 1);
                            break;
                        case '2':
                            $q->where('notification_count', '>', 0);
                            break;
                    }
                })->whereBetween('created_at', [$start, $end])->get()
            ]);
        }
        return view('exports.engineer', [
            'enginneers' => Engineer::where('notification_count')->all()
        ]);
    }
}
