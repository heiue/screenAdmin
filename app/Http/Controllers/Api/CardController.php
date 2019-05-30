<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/30
 * Time: 10:43 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\CardCard;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    /**
     * @remark 人脉圈接口列表
     * @param Request $request
     * @param page 页码
     * @param limit 条数
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $where = [];
        $cardData = CardCard::with(['cardInfo'])->select('id', 'name','company')->orderBy('id', 'desc')->where($where)->paginate($request->get('limit',10))->toArray();

        $returnData['data'] = $cardData;

        return response()->json($returnData);
    }
}