<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/22
 * Time: 11:10 AM
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Common\Wechat\WxUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Class WechatController
 * @package App\Http\Controllers\Api
 * @remark 微信开发
 */
class WechatController extends BaseController
{

    /**
     * @remark 进来先验证token
     */
    public function token(Request $request) {
        $echoStr = $request->get('echostr', '');
        if (!empty($echoStr) && $this->checkSignature()) {
            echo $echoStr;exit;
        } else {
//            $input = file_get_contents('php://input');
            fopen(storage_path().'/logs/wechat.log');

            file_put_contents(storage_path().'/logs/wechat.log', '123123123123123123'.PHP_EOL, FILE_APPEND);
        }
    }

    //检查签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "gojbcs";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;

        }else{
            return false;
        }
    }

    /**
     * getAccessToken
     */
    public function getAccessToken() {
        return json_decode((new WxUser)->getAccessToken(),true)['access_token'];
    }

    /**
     * 模板消息
     */
    /**
     * {
    "touser": "OPENID",
    "template_id": "TEMPLATE_ID",
    "page": "index",
    "form_id": "FORMID",
    "data": {
    "keyword1": {
    "value": "339208499"
    },
    "keyword2": {
    "value": "2015年01月05日 12:30"
    },
    "keyword3": {
    "value": "腾讯微信总部"
    },
    "keyword4": {
    "value": "广州市海珠区新港中路397号"
    }
    },
    "emphasis_keyword": "keyword1.DATA"
    }
     */
    public function send() {
        $sendData = array();
        $data = array();
        $data['keyword1'] = '1';
        $data['keyword2'] = '2';
        $data['keyword3'] = '3';
        $data['keyword4'] = '4';

        $sendData['touser'] = 'o0xo65NU_Y_tUvRhTAKRZDXcIniQ';
        $sendData['template_id'] = 'FYmZRjlisH64aLY5Jg7vW58Cg0m-EfQpVt7LRa9RR9o';
        $sendData['page'] = 'index';
        $sendData['form_id'] = '';
        $sendData['emphasis_keyword'] = '';
        $sendData['data'] = $data;

        $api = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->getAccessToken();
        $res = curl_post($api, json_encode($sendData));
        echo $res;
    }
}