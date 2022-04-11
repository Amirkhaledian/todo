<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/create-task',[TaskController::class,'create']);
    Route::get('/edit-task/{task}',[TaskController::class,'update']);
    Route::get('/status-task/{task}',[TaskController::class,'status']);
    Route::get('/all-task',[TaskController::class,'index']);
    Route::get('/specify-task/{id}',[TaskController::class,'show']);

    Route::get('/create-label/{task}',[LabelController::class,'create']);
    Route::get('/all-label',[LabelController::class,'index']);
});

// Route::middleware('JwtAuthorization')->group(function(){
//     Route::get('/test',function(){
//         return 'access';
//     });
// });
