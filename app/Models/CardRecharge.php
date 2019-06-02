<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/19
 * Time: 8:42 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardRecharge extends Model
{
    /**
     * @remark 获取充值记录
     */
    public function payDetail($id) {
        return self::where(['id' => $id, 'status' => 0])->first();
    }

    /**
     * @remark 更新充值状态
     */
    public function updatePayStatus($xml, $transactionId) {
        // todo 加时长
        $cardUser = CardUser::findOrFail($this->uid);
        $cardUser->is_vip = 'true';
        if (strtotime($cardUser['vip_end']) <= time()) {
            $cardUser->vip_end = date('Y-m-d H:i:s', time()+$this->totalTime);
        } else {
            $cardUser->vip_end = date('Y-m-d H:i:s', $cardUser['vip_end']+$this->totalTime);
        }
        $cardUser->save();

        $this->status = 1;
        $this->wxPayResultJson = $xml;
        $this->transactionId = $transactionId;
        return $this->save();
//        return self::where(['id' => $this->id])->update(['wxPayResultJson' => $xml, 'transactionId' => $transactionId]);
    }
}