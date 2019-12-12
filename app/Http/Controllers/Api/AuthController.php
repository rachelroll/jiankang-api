<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerificationCode;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;
use Overtrue\EasySms\PhoneNumber;

class AuthController extends BaseController
{
    // 登录注册
    public function login()
    {
        $code = request()->get('code');

        //配置appid
        $appid = config('app.appid');
        //配置appscret
        $secret = config('app.secret');
        //api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

        $res = Utils::curl($api);

        $res = json_decode($res,1);


        $res = [
            'openid'      => 1123123,
            'session_key' => 111111111111111,
        ];

        $openid = $res['openid'];
        $session_key = res['$session_key'];

        // 根据 openid 查用户表里是否有这个用户
        $user = User::firstOrCreate([
            'openid' => $openid,
            'session_key' => $session_key,
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return $this->success([
            'token' => $token,
            'is_bind' => $user->is_bind
        ]);
    }


}
