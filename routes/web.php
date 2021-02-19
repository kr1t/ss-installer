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
Auth::routes();

Route::resource('/register', 'RegisterController');
Route::get('/thankyou', 'RegisterController@thankyou');
Route::get('/registered', 'RegisterController@registered');

Route::get('/installer/export', 'RegisterController@export');
Route::post('/installer/import', 'RegisterController@import')->name('import');


Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect(url('/admin/installer/export'));
    });

    Route::prefix('installer')->group(function () {
        Route::get('/export', 'EngineerController@export');
        Route::get('/import', 'EngineerController@import');
    });
});

Route::get('/checkRegister', 'RegisterController@checkRegister');

Route::get('/migrate', function () {
    \Artisan::call('migrate:fresh --seed');
});
