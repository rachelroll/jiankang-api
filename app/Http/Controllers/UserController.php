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
    private $user;

    public function __construct()
    {
        $this->user = request()->user();
    }
    // 手机号绑定
    public function smsCode()
    {
        $phone = request('phone');
        $smscode = rand(1000, 9999);

        session([$phone => $smscode]);

        $bool = Notification::route(EasySmsChannel::class, new PhoneNumber($phone, 86))->notify(new VerificationCode($smscode));

        if ($bool) {
            return $this->success([
                'msg' => '已发送'
            ]);
        }else {
            return $this->failed([
                'msg' => '发送失败, 请重试'
            ]);
        }

    }

    public function phoneBind()
    {
        $sms_code = request('sms_code');
        $phone = request('phone');

        if (session($phone) == $sms_code) {
            $this->user->phone = $phone;

            return $this->success([
                'msg' => '手机号绑定成功',
            ]);
        } else{
            return $this->failed([
                'msg' => '手机号验证失败',
            ]);
        };
    }

    // 保存用户信息
    public function userInfoStore()
    {
        $encryptedData = request('encryptedData');
        $iv = request('iv');
        // 前端需先确认 session_key 是否过期, 如果过期, 需要重新执行登录流程
        $session_key = $this->user->session_key;

        if (strlen($session_key) != 24) {
            return $this->failed([
                'msg' => 'session_key 无效',
                'err_code' => '-41001'
            ]);
        }
        $aesKey=base64_decode($session_key);

        if (strlen($iv) != 24) {
            return $this->failed([
                'msg' => 'iv 无效',
                'err_code' => '-41002'
            ]);
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return $this->failed([
                'msg' => '为获取到大数据, 有可能是 session_key  过期',
                'err_code' => '-41003',
            ]);
        }
        if( $dataObj->watermark->appid != config('app.appid') )
        {
            return $this->failed([
                'msg' => 'appid 错误',
                'err_code' => '-41003',
            ]);
        }

        $bool = $this->user->update([
            'nickname' => $dataObj->nickName,
            'avatar' => $dataObj->avatarUrl,
            'gender' => $dataObj->gender,
            'province' => $dataObj->province,
            'city' => $dataObj->city,
            'country' => $dataObj->country,
            'unionid' => $dataObj->unionId,
        ]);

        if ($bool) {
            return $this->success([
                'msg' => '用户信息保存成功'
            ]);
        } else {
            return $this->failed([
                'msg' => '保存失败'
            ]);
        }
    }
}
