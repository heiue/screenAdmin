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
        if ($accessToken = Cache::get('accessToken3')) {
            if (Cache::get('expires_in') < time()) {
                $api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret;
                $accessToken = curl($api);
                Cache::put('accessToken3', $accessToken, 7000);
                Cache::put('expires_in', time()+7000, 7000);
            }
            return $accessToken;
        } else {
            $api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret;
            $accessToken = curl($api);
            Cache::put('accessToken3', $accessToken, 50);
            Cache::put('expires_in', time()+7000, 7000);
            return $accessToken;
        }

    }

    /**
     * @remark 服务通知--新客户访问提醒
     * @throws \Exception
     */
    /*{
    "touser":"OPENID",
    "weapp_template_msg":{
        "template_id":"TEMPLATE_ID",
        "page":"page/page/index",
        "form_id":"FORMID",
        "data":{
            "keyword1":{
                "value":"339208499"
            },
            "keyword2":{
                "value":"2015年01月05日 12:30"
            },
            "keyword3":{
                "value":"腾讯微信总部"
            },
            "keyword4":{
                "value":"广州市海珠区新港中路397号"
            }
        },
        "emphasis_keyword":"keyword1.DATA"
    },
    "mp_template_msg":{
        "appid":"APPID ",
        "template_id":"TEMPLATE_ID",
        "url":"http://weixin.qq.com/download",
        "miniprogram":{
            "appid":"xiaochengxuappid12345",
            "pagepath":"index?foo=bar"
        },
        "data":{
            "first":{
                "value":"恭喜你购买成功！",
                "color":"#173177"
            },
            "keyword1":{
                "value":"巧克力",
                "color":"#173177"
            },
            "keyword2":{
                "value":"39.8元",
                "color":"#173177"
            },
            "keyword3":{
                "value":"2014年9月22日",
                "color":"#173177"
            },
            "remark":{
                "value":"欢迎再次购买！",
                "color":"#173177"
            }
        }
    }
}
*/
    public function newCustomerService($formId, $openId,$cardName) {
        //todo 获取access_token$accessToken
        $accessToken = json_decode($this->getAccessToken(),true);
        if (empty($accessToken['access_token'])) {
            throw new \Exception('access_token获取失败', 101);
        }
        $api = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token='.$accessToken['access_token'];
        $postData = [
            'touser' => $openId,
            'weapp_template_msg' => [
                'template_id' => 'mm_bKV5GSHlvRlBimTHcbcDaaH0xgKd8H5JNJDo2WCg',
                'page' => 'page/index/index',
                'form_id' => $formId,
                'data' => [
                    'keyword1' => [
                        'value' => $cardName
                    ],
                    'keyword2' => [
                        'value' => '有人查看了您的名片，快去看看TA是谁吧'
                    ]
                ],
                'emphasis_keyword' => ''
            ]
        ];
        $result = curl_post($api, json_encode($postData));
        return $result;
    }

}