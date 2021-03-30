<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerPoint;
use App\EngineerRedeem;
use App\Http\Requests\EngineerRedeemRequest;
use App\RedeemItem;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class RedeemController extends Controller
{
    public function getInstaller(Request $request)
    {
        // $line_uid = 'u12354654654'; //get line user id

        $line_uid = $request->line_uid;

        $engineer = Engineer::where('line_uid', $line_uid)->first();

        if (empty($engineer)) {
            $registered = false;
            $hasId = false;
        } else {
            $registered = true;
            $hasId = empty($engineer->installer_id) ? false : true;
        }

        return [
            'registered' => $registered,
            'hasId' => $hasId
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {

        // $line_uid = 'u12354654654'; //get line user id TEMPORARY

        $line_uid = $request->line_uid;

        $engineer = Engineer::where('line_uid', $line_uid)->with([
            'points' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
        ])->get()->first();

        if (empty($engineer))
            return redirect('/register');

        if (empty($engineer->installer_id))
            return view('frontend.error')->with('message', 'โปรดรอยืนยันการลงทะเบียน');


        $redeemItems = RedeemItem::all();

        return view('frontend.redeem', compact('engineer', 'redeemItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Engineer $engineer, RedeemItem $item, $name)
    {
        if ($engineer->total >= $item->redeem_point)
            return view('frontend.redeem-item', compact('item', 'engineer'));

        return redirect()->route('redeem');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EngineerRedeemRequest $request)
    {
        $request->validated();
        $engineer_redeem_id = EngineerRedeem::create($request->all())->id;
        $log_point = $request->all();
        $log_point['engineer_redeem_id'] = $engineer_redeem_id;
        EngineerPoint::create($log_point);

        return redirect()->route('redeem');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
