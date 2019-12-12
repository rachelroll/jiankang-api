<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;

class AuthController extends BaseController
{

    public function login()
    {
        $code = request()->get('code');

        //配置appid
        $appid = 'wxeec1130bf62eea21';
        //配置appscret
        $secret = '699a9b60a50895537fe89ce2012f5555';
        //api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

        $res = Utils::curl($api);

        $res = json_decode($res,1);


        $res = [
            'openid'      => 1123123,
            'session_key' => 234234,
        ];


        $openid = $res['openid'];
        $session_key = $res['session_key'];

        // 根据 openid 查用户表里是否有这个用户
        $user = User::firstOrCreate([
            'openid' => $openid,
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return $this->success(['token' => $token]);

    }


}
