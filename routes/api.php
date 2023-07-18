<?php

use App\Http\Controllers\AuthenticationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/v1')->group(function (){
    Route::prefix('/auth')->group(function (){
        Route::post('/register',[AuthenticationController::class, 'register'])->name('api.auth.register');
        Route::post('/login',[AuthenticationController::class, 'login'])->name('api.auth.login');
//        Route::post('/login',function (){
//            return redirect()->route('/token');
//        })->name('api.auth.login');

        Route::group(['namespace' => '\laravel\Passport\Http\Controllers'] , function (){
            Route::post('/token',[AccessTokenController::class, 'issueToken'])->name('api.auth.token');
        });

    });
    Route::get('/test',function (){
        return response()->json(User::avg('phone'));
    })->name('api.test');
});
