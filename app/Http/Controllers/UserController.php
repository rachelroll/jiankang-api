<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerificationCode;
use App\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redis;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;
use Overtrue\EasySms\PhoneNumber;

class UserController extends Controller
{

    // 登录
    public function login(Request $request)
    {
        $code = $request->code;

        //配置appid
        $appid = 'wxeec1130bf62eea21';
        //配置appscret
        $secret = '699a9b60a50895537fe89ce2012f5555';
        //api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

        $res = Utils::curl($api);

        $res = json_decode($res);

        $openid = $res->openid;
        $session_key = $res->session_key;

        // 根据 openid 查用户表里是否有这个用户
        $user = User::firstOrCreate([
            'open_id' => $openid,
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return $this->success(['token' => $token]);

        if ($user_id) {
            // 把用户 ID 加密生成 token
            $token = md5($user_id, config('salt'));
            Redis::set($token, $user_id); // 存入 session

            return [
                'code' => 0,
                'data' => [
                    'token' => $token,
                ],
            ];
        } else {
            // 把 session_key 和 openid 存入数据库, 并返回用户 id
            $id = DB::table('users')->insertGetId([
                    'session_key' => $session_key,
                    'openid'      => $openid,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            // 如果用户储存成功
            if ($id) {
                // 把用户 ID 加密生成 token
                $token = md5($id, config('salt'));

                Redis::set($token, $id); // 存入 session

                return $token;
            } else {
                return [
                    'code' => 202,
                    'msg'  => 'error',
                ];
            }
        }
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
