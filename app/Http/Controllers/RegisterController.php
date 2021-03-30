<?php

namespace App\Http\Controllers;

use App\Engineer;
use Illuminate\Http\Request;
use App\Exports\EngineerExport;
use App\Imports\EngineerImport;

use Maatwebsite\Excel\Facades\Excel;
use PA\ProvinceTh\Factory;
use Carbon\Carbon;
use Helpers\LineBot;
use Illuminate\Support\Arr;

class RegisterController extends Controller
{


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

        $userImports = Excel::toArray(new EngineerImport, request()->file('file'));

        $emails = Arr::pluck($userImports[0], 'email');
        $engineers = Engineer::whereIn('email', $emails)->get();


        foreach ($engineers  as $engineer) {
            $engineer->import = Arr::last($userImports[0], function ($value, $key) use ($engineer) {
                return $engineer->email == $value['email'];
            });
        }

        return view('admin.engineer.import', compact('engineers'));
    }

    public function importSubmit(Request $request)
    {
        $engineers = json_decode($request->engineers, true);
        $import = $request->import;

        $push = [];

        foreach ($import as $key => $i) {
            $find = Arr::last($engineers, function ($value) use ($key) {
                return $key == $value['id'];
            });
            array_push($push, $find);
        }


        $success = [];
        $fail = [];
        foreach ($push as $p) {
            $importData = $p['import'];
            $engineer = Engineer::where('id', $p['id'])->first();

            $engineer->update([
                'installer_id' => $importData['installer_id'],
                'point' => $importData['point']
            ]);

            $bot = new LineBot(env('LINE_TOKEN', ''));

            try {

                $pushText = "ยินดีต้อนรับ คุณ {$engineer->first_name_th} {$engineer->last_name_th} สู่ครอบครัวชมรมช่างแอร์ซัมซุง 🔧
คุณสามารถเข้าใช้งานแอพพลิเคชั่น SWAT ได้แล้ว 📱

(Android) ดาวน์โหลดได้ที่ : https://box.byigroup.com/swat/swat_2-17_pro.apk
คู่มือการใช้งาน : https://bit.ly/2NZM9wc
ชื่อผู้ใช้ : {$engineer->installer_id}

โดยเมื่อเข้าสู่ระบบครั้งแรก ให้พี่ๆ ช่างแอร์ตั้งรหัสผ่านใหม่ โดยทำตามขั้นตอนต่อไปนี้
1) กดลืมรหัสผ่าน
2) กรอกอีเมลที่ใช้สมัคร
3) ตรวจสอบกล่องขาเข้าอีเมล คลิกที่ลิ้งก์เพื่อตั้งรหัสผ่านใหม่
4) กรอกชื่อผู้ใช้ที่ได้รับด้านบนและรหัสผ่านเพื่อเข้าสู่ระบบ
เพียงเท่านี้ก็เข้าร่วมกิจกรรมเพื่อรับสิทธิพิเศษดีๆ กับชมรมช่างแอร์ซัมซุงได้แล้ว

หากไม่สามารถดาวน์โหลดได้เมื่อเปิดผ่านไลน์ ให้ทำตามขั้นตอนดังนี้
1. กดที่ปุ่มรูปจุดสามจุดตรงมุมบนขวา
2. เลือกเปิดบนบราวเซอร์อื่น หรือบราวเซอร์เริ่มต้น
3. เมื่อเปิดบนบราวเซอร์อื่นแล้วจะขึ้นป็อปอัพให้ดาวน์โหลดไฟล์ คลิกดาวน์โหลดและติดตั้ง
";

                $pushAPI = $bot->setUser($engineer->line_uid)->addText($pushText)->push();

                if (isset($pushAPI['message'])) {
                    array_push($fail, $engineer);
                } else {
                    $engineer->increment('notification_count');
                    array_push($success, $engineer);
                }
            } catch (\Exception $e) {
                array_push($fail, $engineer);
            }
        }


        return redirect(url('admin/installer/import'))->with('success', $success)->with('fail', $fail);
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

        try {
            $del = Engineer::where('line_user_id', $request->line_uid)->get();

            if (count($del)) {
                foreach ($del as $d) {
                    $d->delete();
                }
            }
        } catch (\Exception $e) {
        }


        $engineer = Engineer::create($request->all());

        if (!$engineer) {
            return redirect()->back()->withInput()->withErrors(['any' => 'มีบางอย่างผิดพลาด']);
        } else {
            return redirect(url('/thankyou'));
        }
    }
}
