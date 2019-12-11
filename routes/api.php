<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->prefix('v1')->group(function () {
    //注册用户
    Route::post('/auth/register', 'AuthController@register')->name('api.auth.register');
    Route::post('/auth/login', 'AuthController@login')->name('api.auth.login');
    Route::post('/auth/reset', 'AuthController@reset')->name('api.auth.reset');
    Route::post('/auth/sms-login', 'AuthController@smsLogin')->name('api.auth.sms-login');

    Route::get('/user/exists', 'UserController@exists')->name('api.user.check-mobile');
    //验证码
    Route::get('/user/captcha', 'UserController@captcha')->name('api.user.captcha');
    Route::post('/user/sms-code', 'UserController@smsCode')->name('api.user.sms-code');





});


