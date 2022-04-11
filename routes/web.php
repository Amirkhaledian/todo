<?php

use App\Http\Services\Jwt;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setToken', function () {
    $jwt= new Jwt();
    $jwt->setName("amir");
    return $jwt->generate_jwt();
});

Route::get('/checkToken/{value}', function ($value) {
    $jwt= new Jwt();
    return $jwt->is_jwt_valid($value);
});


Route::get('test', function () {

    $user = [
        'name' => 'Harsukh Makwana',
        'info' => 'Laravel & Python Devloper'
    ];


    //Mail::to("amir@info.com")
        //->send(new NotificationMail($user));
        Mail::to("amir@gmail.comm")->send(new NotificationMail(1,"close","2022-01-25 21:21:37"));

    dd("success");

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
