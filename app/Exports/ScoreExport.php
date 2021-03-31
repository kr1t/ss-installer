<?php

namespace App\Exports;

use App\Engineer;
use App\EngineerAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ScoreExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $request = request();
        ($request->level == 'silver' ? $exam_type = 1 : $exam_type = 2);
        if ($request->dates) {
            $dateExplode = explode('-', $request->dates);
            $start = Carbon::parse($dateExplode[0])->format('Y-m-d 00:00');
            $end = Carbon::parse($dateExplode[1])->format('Y-m-d 23:59');
            $scores = EngineerAnswer::whereBetween('created_at', [$start, $end])
                ->where('exam_type', $exam_type)
                ->with([
                    'engineerInfo' => function($q) {
                        $q->select('id', 'installer_id');
                    }
                ])
                ->get();

            return view('exports.score', compact('scores'));
        }
        return view('exports.score', [
            'scores' => Engineer::all()
                ->with([
                    'engineerInfo' => function($q) {
                        $q->select('installer_id');
                    }
                ])
        ]);
    }
}
