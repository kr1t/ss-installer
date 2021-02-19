<?php

namespace App\Http\Controllers;

use App\Engineer;
use Illuminate\Http\Request;

class EngineerController extends Controller
{
    public function export()
    {
        return view('admin.engineer.export');
    }
    public function import()
    {
        return view('admin.engineer.import');
    }
}
