<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/19
 * Time: 5:27 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common\Wechat\WxPay;
use App\Models\CardRecharge;
use Illuminate\Http\Request;

class PayController extends BaseController
{
    public $recharge = [
        '1' => ['price' => 9.9, 'time' => 30*24*60*60],
        '2' => ['price' => 29, 'time' => 3*30*24*60*60],
        '3' => ['price' => 59, 'time' => 6*30*24*60*60],
        '4' => ['price' => 118, 'time' => 12*30*24*60*60],
    ];
    /**
     * @author WEIYIZHENG
     * @param $request -> token 用户登陆凭证 price 金额 rechargeType 充值档位
     * @remark 微信支付
     */
    public function pay(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []

        ];
        if (empty($request->price)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'price is empty';
            return response()->json($returnData);
        }
        if (empty($request->rechargeType)) {
            $returnData['error'] = 102;
            $returnData['msg'] = 'rechargeType is empty';
            return response()->json($returnData);
        }
        if ($request->price != $this->recharge[$request->rechargeType]['price']) {
            $returnData['error'] = 103;
            $returnData['msg'] = 'The amount does not match and may be changed';
            return response()->json($returnData);
        }
        $userApi = new UserController();
        $userInfo = json_decode($userApi->getUserInfo($request)->getContent(),true);
        if (empty($userInfo['data']) || $userInfo['error'] != 0) {
            $returnData['error'] = 104;
            $returnData['msg'] = 'userinfo is empty';
            return response()->json($returnData);
        }
        $cardRecharge = new CardRecharge();
        $cardRecharge->uid = $userInfo['data']['userinfo']['id'];
        $cardRecharge->totalFee = $request->price*100;
        $cardRecharge->totalFeeR = 0;
        $cardRecharge->status = 0;
        $cardRecharge->totalTime = $this->recharge[$request->rechargeType]['time'];
        $cardRecharge->payType = 'wechat';
        $cardRecharge->transactionId = '';
        if ($cardRecharge->save()) {
            $rechargeId = $cardRecharge['id'];
        } else {
            $returnData['error'] = 105;
            $returnData['msg'] = 'insert recharge is error';
            return response()->json($returnData);
        }
        // 发起微信支付
        $WxPay = new WxPay();
        $wxParams = $WxPay->unifiedorder($rechargeId, $userInfo['data']['userinfo']['openid'], $request->price, $request);
        return $wxParams;
    }


    /**
     * 微信回调
     */
    public function notify() {
//        $cardRecharge = new CardRecharge();
//        $recharge = $cardRecharge->payDetail(13);
//        $recharge->updatePayStatus('adf123123asdf','123124123');
//        return response()->json($recharge);
        $WxPay = new WxPay();
        $WxPay->notify(new CardRecharge());
    }
}