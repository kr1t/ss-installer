<?php

namespace App\Exports;

use App\Engineer;
use App\EngineerAnswer;
use App\EngineerRedeem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class RedeemExport implements FromView
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
            $redeems = EngineerRedeem::whereBetween('created_at', [$start, $end])
                ->with([
                    'engineerInfo' => function($q) {
                        $q->select('id', 'installer_id');
                    },
                    'redeemItem' => function($q) {
                        $q->select('id', 'name');
                    },
                ])
                ->get();

            return view('exports.redeem', compact('redeems'));
        }
        return view('exports.redeem', [
            'scores' => EngineerRedeem::all()
                ->with([
                    'engineerInfo' => function($q) {
                        $q->select('id', 'installer_id');
                    },
                    'redeemItem' => function($q) {
                        $q->select('id', 'name');
                    },
                ])
        ]);
    }
}
