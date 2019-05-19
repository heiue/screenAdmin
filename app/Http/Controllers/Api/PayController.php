<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/19
 * Time: 5:27 PM
 */

namespace App\Http\Controllers\Api;


use app\common\library\wechat\WxPay;

class PayController extends BaseController
{
    /**
     * 微信支付
     */
    public function pay() {
        // 发起微信支付
        $WxPay = new WxPay();
        $wxParams = $WxPay->unifiedorder('123123123', $this->user['open_id'], 99);
    }


    /**
     * 微信回调
     */
    public function notify() {
        $WxPay = new WxPay();
        $WxPay->notify(new OrderModel);
    }
}