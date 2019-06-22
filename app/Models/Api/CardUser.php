<?php

namespace App\Models\Api;

use App\Http\Controllers\Common\Im\TLSSigAPI;
use App\Http\Controllers\Common\Wechat\WxUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class CardUser extends Model
{
    private $token;
    private $wxapp_id = 1001;

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'create_time',
        'update_time'
    ];
    protected $wxapp = [
        'app_id' => '',
        'app_secret' => '',
    ];
    protected $im = [
        'sdkappid' => '',
        'identifier' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        $this->wxapp['app_id'] = config('pay.wechat.app_id');
        $this->wxapp['app_secret'] = config('pay.wechat.app_secret');
        $this->im['sdkappid'] = config('pay.im.sdkappid');
        $this->im['identifier'] = config('pay.im.identifier');
    }

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     */
    public static function getUserOpenId($token)
    {
        return Cache::get($token)['openid'];
    }

    /**
     * 用户登录
     * @param array $post
     * @return string
     */
    public function login($post)
    {
        // 微信登录 获取session_key
        $session = $this->wxlogin($post['code']);
        // 自动注册用户
        $userInfo = json_decode(htmlspecialchars_decode($post['user_info']), true);
        $user_id = $this->register($session['openid'], $userInfo);
        // 生成token (session3rd)
        $this->token = $this->token($session['openid']);
        // 记录缓存, 7天
        Cache::put($this->token, $session, 1440 * 7);
        return $user_id;
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     */
    private function wxlogin($code)
    {
        // 微信登录 (获取session_key)
        $WxUser = new WxUser();
        if (empty($WxUser->appId) || empty($WxUser->appSecret)) {
            throw response()->json(['msg' => '填写appid 和 appsecret']);
        }
        if (!$session = $WxUser->sessionKey($code)) {
            throw response()->json(['msg' => $WxUser->getError()]);
        }
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        $wxapp_id = $this->wxapp_id;
        // 生成一个不会重复的随机字符串
        $guid = $this->getGuidV4();
        // 当前时间戳 (精确到毫秒)
        $timeStamp = microtime(true);
        // 自定义一个盐
        $salt = 'token_salt';
        return md5("{$wxapp_id}_{$timeStamp}_{$openid}_{$guid}_{$salt}");
    }

    /**
     * 自动注册用户
     * @param $open_id
     * @param $userInfo
     * @return mixed
     */
    private function register($open_id, $userInfo)
    {
        $userInfoI = array();
        if (!$user = self::where(['openid' => $open_id])->first()) {
            $user = $this;
            $user->openid = $open_id;
        }
        $user->name = preg_replace('/[\xf0-\xf7].{3}/', '', $userInfo['nickName']);
        $user->pic = $userInfo['avatarUrl'];
        if (!$user->save()) {
            throw response()->json(['msg' => '用户注册失败']);
        }
        return $user['id'];
    }

    /**
     * 获取全局唯一标识符
     * @param bool $trim
     * @return string
     */
    public function getGuidV4($trim = true)
    {
        // Windows
        if (function_exists('com_create_guid') === true) {
            $charid = com_create_guid();
            return $trim == true ? trim($charid, '{}') : $charid;
        }
        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }
        // Fallback (PHP 4.2+)
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace .
            substr($charid, 0, 8) . $hyphen .
            substr($charid, 8, 4) . $hyphen .
            substr($charid, 12, 4) . $hyphen .
            substr($charid, 16, 4) . $hyphen .
            substr($charid, 20, 12) .
            $rbrace;
        return $guidv4;
    }

    /**
     * @remark 用户登陆生成usersig
     */
    public function userSigIm($identifier) {
        //todo 获取签名 userSig
        $usersig = 'eJxlj1FPgzAUhd-5FQ2vM9oWisNkD9vY1ASGZEjIXhpGi14ZDLuCGuN-N*ISm3hfv*-knPtpIYTsNNxeFmV57FvN9UcnbXSDbGxf-MGuA8ELzR0l-kH53oGSvKi0VCMkjDGKsemAkK2GCs5GIRpoDXwSNR87fvMuxpTSKWGmAk8jjFbJ8v4uqJ2rBLy3Vb6O3NTPZCJ2wUsZdA6tqiYOB-FIrid*td-MYV5v4tSP3W2v2O3rNFCHxSFceL3e5Vg-T9b7esizZSaihzCZzYxKDY08P*QR4jvUNwcNUp3g2I4CxYQR6uCfs60v6xuXSVwe';

        $model = new TLSSigAPI();
        $model->setAppid($this->im['sdkappid']);
        $private = file_get_contents('./im/keys/private_key.txt');
        $model->SetPrivateKey($private);
        $sig = $model->genSig($identifier);
        //todo 判断用户登陆状态
        /*$querystateApi = "https://console.tim.qq.com/v4/openim/querystate?sdkappid={$this->im['sdkappid']}&identifier={$this->im['identifier']}&usersig={$usersig}&contenttype=json";
        $postData = [
            'To_Account' => [$identifier]
        ];
        $result = json_decode(curl_post($querystateApi, json_encode($postData)),true);
        if ($result['ErrorCode'] == 0) {
            if ($result['QueryResult']['State'] != 'Online') {
                //todo 去登陆

            }
        } else {

        }*/

        return $sig;
    }
}
