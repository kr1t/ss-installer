<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Engineer;
use Illuminate\Support\Facades\DB;


Auth::routes();

Route::resource('/register', 'RegisterController');
Route::get('/thankyou', 'RegisterController@thankyou');
Route::get('/registered', 'RegisterController@registered');

Route::get('/installer/export', 'RegisterController@export')->middleware('auth');
Route::post('/installer/import', 'RegisterController@import')->name('import')->middleware('auth');
Route::get('/installer/import', function () {
    return redirect('admin/installer/import');
})->middleware('auth');

Route::post('/point/import', 'EngineerController@importPoint')->name('importPoint')->middleware('auth');
Route::get('/point/import', function () {
    return redirect('admin/point/import');
})->middleware('auth');

Route::get('/home', function () {
    return redirect('admin/installer/import');
});

Route::get('/clean-data-engineers', function () {

    $engineers = Engineer::all();
    $usersUnique = $engineers->unique('line_uid');
    $usersDupes = $engineers->diff($usersUnique);

    foreach ($usersDupes as $dup) {
        $dup->delete();
    }
    // dd($engineers, $usersUnique, $usersDupes);


    return 'success';
    // foreach ($duplicateRecords as $index => $record) {
    //     if ($index > 0) {
    //         $record->delete();
    //     }
    // }
});


Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect(url('/admin/installer/export'));
    })->middleware('auth');

    Route::prefix('installer')->group(function () {
        Route::get('/export', 'EngineerController@export')->middleware('auth');
        Route::get('/import', 'EngineerController@import')->middleware('auth');
        Route::post('/import', 'RegisterController@importSubmit')->middleware('auth');
    });
    Route::prefix('point')->group(function () {
        Route::get('/import', function (){
            $points = [];
            return view('admin.point.import', compact('points'));
        })->middleware('auth');
        Route::post('/import', 'EngineerController@importPointSubmit')->middleware('auth');
    });
});

Route::get('/checkRegister', 'RegisterController@checkRegister');

Route::get('/migrate', function () {
    \Artisan::call('migrate');
})->middleware('auth');

Route::get('/redeem', 'RedeemController@index')->name('redeem');
Route::get('/redeem/check', 'RedeemController@getInstaller')->name('redeem.check');

Route::get('/call/redeem', function () {
    return view('frontend.call-redeem');
});

Route::get('/call/silver-exam', function () {
    return view('frontend.call-exam-silver');
});

Route::get('/call/gold-exam', function () {
    return view('frontend.call-exam-gold');
});


Route::get('/redeem/{engineer}{item}-{name}', 'RedeemController@create')->name('create.redeem');
Route::post('redeem', 'RedeemController@store')->name('store.redeem');
Route::get('/{type}-exam', 'ExamController@exam');
Route::post('submit-answer', 'ExamController@store')->name('store.answer');
