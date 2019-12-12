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
Route::namespace('Api')->prefix('v1')->group(function () {
    // 通过微信注册登录
    Route::post('/auth/login', 'AuthController@login')->name('api.auth.login');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/test', 'TestController@index');

        // 手机号验证码
        Route::post('user/sms-code', 'UserController@smsCode')->name('api.user.sms-code');
        // 绑定手机号
        Route::post('user/phone-bind', 'UserController@phoneBind')->name('api.user.phone-bind');
        // 保存用户信息
        Route::post('user/user-info-store', 'UserController@userInfoStore')->name('api.user.user-info-store');

    });
});
