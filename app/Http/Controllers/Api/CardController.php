<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/30
 * Time: 10:43 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Common\Wechat\WxUser;
use App\Models\CardCard;
use App\Models\CardCollection;
use App\Models\CardIndustry;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    /**
     * @remark 人脉圈分类列表
     */
    public function classList() {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $list = CardIndustry::all();
        $returnData['data'] = $list;
        return response()->json($returnData);
    }
    /**
     * @remark 人脉圈接口列表
     * @param Request $request
     * @param page 页码
     * @param limit 条数
     * @param industry_id 分类ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $industryId = $request->get('industry_id');
        $uid = $request->get('uid');
        $where = [];
        $model = CardCard::query();
        if (!empty($industryId)) {
            $model->whereRaw('FIND_IN_SET('.$industryId.', industry_id)');
//            $where['industry_id'] = $industryId;
        }
        if (!empty($uid)) {
            $model->where('uid', '!=', $uid);
        }
        /*$cardData = CardCard::with(['cardInfo','cardUser' => function($query){
            $query->select('id','is_vip');
        }])->orderBy('id', 'desc')->where($where)->paginate($request->get('limit',10))->toArray();*/
        $cardData = $model->with(['cardInfo','cardUser' => function($query){
            $query->select('id','is_vip');
        }])->orderBy('id', 'desc')->paginate($request->get('limit',10))->toArray();

        $returnData['data'] = $cardData['data'];

        return response()->json($returnData);
    }

    /**
     * @remark 人脉圈详情
     * @param card_id 人脉ID
     */
    public function detail(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $cardId= $request->get('card_id');
        $uid = $request->get('uid'); //todo 用户ID
        if (empty($cardId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'card_id is empty';
            return response()->json($returnData);
        }
        if (empty($uid)) {
            $returnData['error'] = 102;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }
        $card = CardCard::with('cardInfo')->findOrFail($cardId);
        // todo 是否收藏过
        $where['rid'] = $cardId;
        $where['uid'] = $uid;
        $where['rType'] = 1;
        if (CardCollection::where($where)->first()) {
            $card['isCollection'] = 1;
        } else {
            $card['isCollection'] = 0;
        }
        $card['identifier'] = 'ju'.$card['uid'];
        $returnData['data'] = $card;
        return response()->json($returnData);
    }

    /**
     * @remark 帮推 「随机获取一条人脉」
     */
    public function helpPush() {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $card = CardCard::with(['cardInfo', 'cardUser'])->inRandomOrder()->take(1)->get()->toArray();
        $returnData['data'] = $card;
        return response()->json($returnData);
    }
}