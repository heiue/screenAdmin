<?php

namespace App\Http\Controllers\Common\Wechat;

use Illuminate\Support\Facades\Cache;


/**
 * 微信小程序用户管理类
 * Class WxUser
 * @package App\Http\Common\Wechat
 */
class WxUser
{
    public $appId;
    public $appSecret;

    private $error;

    /**
     * 构造方法
     * WxUser constructor.
     * @param $appId
     * @param $appSecret
     */
    public function __construct()
    {
        $this->appId = config('pay.wechat.app_id');
        $this->appSecret = config('pay.wechat.app_secret');
    }

    /**
     * 获取session_key
     * @param $code
     * @return array|mixed
     */
    public function sessionKey($code)
    {
        /**
         * code 换取 session_key
         * ​这是一个 HTTPS 接口，开发者服务器使用登录凭证 code 获取 session_key 和 openid。
         * 其中 session_key 是对用户数据进行加密签名的密钥。为了自身应用安全，session_key 不应该在网络上传输。
         */
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $result = json_decode(curl($url, [
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'grant_type' => 'authorization_code',
            'js_code' => $code
        ]), true);
        if (isset($result['errcode'])) {
            $this->error = $result['errmsg'];
            return false;
        }
        return $result;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * getAccessToken
     */
    public function getAccessToken() {
        if ($accessToken = Cache::get('accessToken')) {
            return $accessToken;
        } else {
            $api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret;
            $accessToken = curl($api);
            Cache::put('accessToken', $accessToken, 120);
            return $accessToken;
        }

    }

}