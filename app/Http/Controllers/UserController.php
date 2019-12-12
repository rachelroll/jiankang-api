<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Notifications\VerificationCode;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redis;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;
use Overtrue\EasySms\PhoneNumber;

class UserController extends BaseController
{
    // 注册登录
    public function login()
    {
        $code = request('code');

        //配置appid
        $appid = config('app.appid');
        //配置appscret
        $secret = config('app.secret');

        //api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

        $res = Utils::curl($api);

        $res = json_decode($res);

        $openid = $res->openid;
        $session_key = $res->session_key;

        $openid = 111111111;

        // 根据 openid 查用户表里是否有这个用户
        $user = User::firstOrCreate([
            'open_id' => $openid,
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return $this->success([
            'token' => $token,
            'is_bind' => $user->is_bind
        ]);
    }


    // 手机号绑定
    public function phoneRegister()
    {
        $phone = request('phone');
        $smscode = rand(1000, 9999);

        session([$phone => $smscode]);

        Notification::route(EasySmsChannel::class, new PhoneNumber($phone, 86))->notify(new VerificationCode($smscode));
    }

    public function create(Request $request)
    {
        $sms_code = $request->sms_code;
        $phone = $request->phone;

    }
}
