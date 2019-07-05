<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/22
 * Time: 11:10 AM
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Common\Wechat\WxUser;
use App\Models\Api\CardUser;
use App\Models\CardUser as CardUsers;
use App\Models\XcxForm;
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
        return (new WxUser)->getAccessToken();
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
        $result = (new WxUser())->newCustomerService('wed12','wef23', '31fd3');
        dump($result);
    }

    /**
     * @remark 储存form_id
     */
    public function setFormId(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'ok',
            'data' => []
        ];
        $formId = $request->get('form_id');
        $token = $request->get('token');
        $uid = $request->get('uid');

        if (empty($formId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'form_id为空';
            return response()->json($returnData);
        }

        if (empty($uid)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'uid为空';
            return response()->json($returnData);
        }
        if (!empty($token)) {
            $openid = (new CardUser())->getUserOpenId($token);
            if (empty($openid)) {
                $user = CardUsers::find($uid);
                if (!empty($user)) {
                    $openid = $user['openid'];
                } else {
                    $returnData['error'] = 101;
                    $returnData['msg'] = 'uid不正确';
                    return response()->json($returnData);
                }

            }
        } else {
            $returnData['error'] = 101;
            $returnData['msg'] = 'token为空';
            return response()->json($returnData);
        }

        $saveData = [
            'openid' => $openid,
            'form_id' => $formId,
            'expires' => time()+86400*6
        ];
        $xcxForm = XcxForm::where(['form_id' => $formId])->first();
        if (!empty($xcxForm)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'form_id已存在';
            return response()->json($returnData);
        }
        if (!XcxForm::create($saveData)) {
            $returnData['error'] = 101;
            $returnData['msg'] = '添加失败';
            return response()->json($returnData);
        }

        return response()->json($returnData);
    }

}