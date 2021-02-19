<?php

namespace App\Http\Controllers;

use App\Engineer;
use Illuminate\Http\Request;
use App\Exports\EngineerExport;
use App\Imports\EngineerImport;

use Maatwebsite\Excel\Facades\Excel;
use PA\ProvinceTh\Factory;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces  = Factory::province();
        $provinceArray = $provinces->toArray();

        return view('register', compact('provinceArray'));
    }

    public function thankyou()
    {
        return view('thankyou');
    }
    public function registered()
    {
        return view('registered');
    }


    public function export(Request $request)
    {
        return Excel::download(new EngineerExport, 'installer' . time() . '.xlsx');
    }
    public function import()
    {

        Excel::import(new EngineerImport, request()->file('file'));

        return back();
    }


    public function checkRegister(Request $request)
    {
        $count = Engineer::where('line_uid', $request->line_uid)->count();

        return [
            "status" =>
            $count ? true : false
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'first_name_th' => "required|regex:(^[ก-๏\s]+$)|max:255",
                'last_name_th' => "required|regex:(^[ก-๏\s]+$)|max:255",
                'first_name_en' => "required|alpha|max:255",
                'last_name_en' => "required|alpha|max:255",
                'email' => "required|email|unique:users",
                'tel' => "required|min:9|max:13",
                'type_of_work' => "required",
                'province' => "required|max:255",
                'history_install' => "required|max:255",
                'month' => "required|max:255"
            ],
            [
                "first_name_th.regex" => "รูปแบบชื่อ (ภาษาไทย) ไม่ถูกต้อง",
                "last_name_th.regex" => "รูปแบบนามสกุล (ภาษาไทย) ไม่ถูกต้อง",
                "first_name_en.alpha" => "รูปแบบชื่อ (ภาษาอังกฤษ) ไม่ถูกต้อง",
                "last_name_en.alpha" => "รูปแบบชื่อ (ภาษาอังกฤษ) ไม่ถูกต้อง",
                "first_name_th.required" => "กรุณากรอกชื่อจริงภาษาไทย",
                "last_name_th.required" => "กรุณากรอกนามสกุลภาษาไทย",
                "first_name_en.required" => "กรุณากรอกชื่อจริงภาษาอังกฤษ",
                "last_name_en.required" => "กรุณากรอกนามสกุลภาษาอังกฤษ",
                "first_name_th.max" => "กรุณากรอกชื่อจริงภาษาไทย ไม่เกิน 255 ตัวอักษร",
                "last_name_th.max" => "กรุณากรอกนามสกุลภาษาไทย  ไม่เกิน 255 ตัวอักษร",
                "first_name_en.max" => "กรุณากรอกนามสกุลภาษาอังกฤษ  ไม่เกิน 255 ตัวอักษร",
                "last_name_en.max" => "กรุณากรอกชื่อจริงภาษาอังกฤษ  ไม่เกิน 255 ตัวอักษร",
                "email.required" => 'กรุณากรอกอีเมล',
                "email.required" => 'กรุณากรอกอีเมล',
                "email.unique" => 'อีเมลถูกใช้แล้ว',
                "tel.required" => 'กรุณากรอกเบอร์โทรศัพท์',
                "tel.max" => 'รูปแบบเบอร์โทรไม่ถูกต้อง',
                "tel.min" => 'รูปแบบเบอร์โทรไม่ถูกต้อง',
                "type_of_work.required" => 'กรุณาระบุรูปแบบงานที่ทำ',
                "province.required" => 'กรุณากรอกจังหวัด',
                "history_install.required" => 'กรุณากรอก ปี ประวัติการติดตั้งแอร์',
                "month.required" => 'กรุณากรอก เครื่อง / เดือน',

            ]
        );



        $engineer = Engineer::create($request->all());

        if (!$engineer) {
            return redirect()->back()->withInput()->withErrors(['any' => 'มีบางอย่างผิดพลาด']);
        } else {
            return redirect(url('/thankyou'));
        }
    }
}
