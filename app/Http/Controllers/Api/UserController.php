<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 4:11 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\CardCard;
use App\Models\CardCollection;
use App\Models\CardInfo;
use App\Models\CardUser;
use App\Models\Api\CardUser as UserModel;//小程序用户模型
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 * @remark 个人信息类
 */
class UserController extends BaseController
{
    /**
     * 用户自动登录
     * @return array
     */
    public function login(Request $request)
    {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $model = new UserModel();
        $user_id = $model->login($request->post());
        $token = $model->getToken();
        $returnData['data'] = compact('user_id', 'token');
        return response()->json($returnData);
    }

    /**
     * @author WEIYIZHENG
     * @remark 获取本人的信息
     * @param Request $request
     * @param openid string
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        // 当前用户信息
        if (!$token = $request->get('token')) {
            throw response()->json(['code' => -1, 'msg' => '缺少必要的参数：token']);
        }
        if (!$userOpenId = UserModel::getUserOpenId($token)) {
            throw response()->json(['code' => -1, 'msg' => '没有找到用户信息']);
        }

//        $openId = $request->get('openid', '');//获取请求参数openid
        if (empty($userOpenId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'openid is empty';
            return response()->json($returnData);
        }
        $userInfo = CardUser::where('openid', $userOpenId)->first();
        if (strtotime($userOpenId['vip_end'] <= time())) {
            $userInfo->is_vip = 'false';
            $userInfo->save();
        }
        $returnData['data']['userinfo'] = $userInfo;
        return response()->json($returnData);
    }

    /**
     * @author  WEIYIZHENG
     * @param Request $request
     * @param id
     * @param formData  编辑的数据包
     * @remark 编辑个人信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserInfo(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'Successful editing',
            'data' => []
        ];
        $id = $request->get('id', 0);
        if (empty($id) || !is_numeric($id) || strpos($id, '.')) {
            $returnData['error'] = 102;
            $returnData['msg'] = 'id is empty';
            return response()->json($returnData);
        }
        $formData = $request->get('formData', []);
        if (empty($formData)) {
            $returnData['error'] = 103;
            $returnData['msg'] = 'formData is empty';
            return response()->json($returnData);
        }
//        $cUser = CardUser::findOrFail($id);
//        if ($cUser->update($formData)) {
        if (CardUser::where('id', $id)->update($formData)) {
            return response()->json($returnData);
        } else {
            $returnData['error'] = 104;
            $returnData['msg'] = 'update is error';
            return response()->json($returnData);
        }
    }

    /**
     * @author WEIYIZHENG
     * @param Request $request
     * @param uid
     * @remark 获取个人的名片
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCard(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $id = $request->get('uid', 0);
        if (empty($id) || $id == 0) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }
        $cardInfo = CardCard::with('cardInfo')->where('uid', $id)->first();
        $returnData['data']['cardInfo'] = $cardInfo;
        return response()->json($returnData);

    }

    /**
     * @author WEIYIZHENG
     * @param cardid
     * @param formData
     * @remark 编辑个人名片信息
     * @return $returnData json
     */
    public function updateUserCard(Request $request) {
        /*{
        "cardid":"",
        "uid":"",
	"card":{
		"name":"名字",
		"company":"公司",
		"position":"行业",
        "industry_id":"3",
        "pic":"url"
	},
	"info":{
		"mobile":"手机",
		"wechat":"微信",
		"email":"",
		"address":"",
		"intro":"简介"
	},
        "images":{
            0:"url",
            1:"url"
        }

}*/
        $returnData = [
            'error' => 0,
            'msg' => 'Successful editing',
            'data' => []
        ];
        $cardDataR = $request->get('cardData', []);
        $cardid = $cardDataR['cardid'];
        $uid = $cardDataR['uid'];
        $cardData = $cardDataR['card'];
        $infoData = $cardDataR['info'];
        if (empty($cardData) || empty($infoData)) {
            $returnData['error'] = 103;
            $returnData['msg'] = 'card or info is empty';
            return response()->json($returnData);
        }
//        $cUser = CardUser::findOrFail($id);
//        if ($cUser->update($formData)) {
        if (!empty($cardid)) {
            if (CardCard::where('id', $cardid)->update($cardData)) {
                CardInfo::where('card_id', $cardid)->update($infoData);
                return response()->json($returnData);
            } else {
                $returnData['error'] = 104;
                $returnData['msg'] = 'update is error';
                return response()->json($returnData);
            }
        } elseif (!empty($uid)) {
            $cardData['uid'] = $uid;
//            $formData['style_group_id'] = $uid;
            if ($card = CardCard::create($cardData)) {
                $infoData['card_id'] = $card->id;
                $infoData['uid'] = $uid;
                CardInfo::create($infoData);
                $returnData['insertId'] = $card->id;
                $returnData['msg'] = 'Successful inserting';
                return response()->json($returnData);
            } else {
                $returnData['error'] = 104;
                $returnData['msg'] = 'insert is error';
                return response()->json($returnData);
            }
        } else {
            $returnData['error'] = 101;
            $returnData['msg'] = 'id/uid is empty';
            return response()->json($returnData);
        }

    }


    /**
     * @author WEIYIZHENG
     * @remark 添加收藏
     * $param $rid int 人脉或者项目的ID
     * @param $rType int 类型 1 是人脉 2 是项目
     */
    public function saveCollection(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $uid = $request->get('uid');
        $rid = $request->get('rid');
        $rType = $request->get('rType');
        if (empty($uid)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }
        if (empty($rid)) {
            $returnData['error'] = 102;
            $returnData['msg'] = 'rid is empty';
            return response()->json($returnData);
        }
        if (empty($rType)) {
            $returnData['error'] = 103;
            $returnData['msg'] = 'rType is empty';
            return response()->json($returnData);
        }
        $collection = new CardCollection();
        $collection->rid = $rid;
        $collection->uid = $uid;
        $collection->rType = $rType;
        if ($insertId = $collection->save()) {
            $returnData['id'] = $collection->id;
            return response()->json($returnData);
        }

    }
    /**
     * @author WEIYIZHENG
     * @remark 人脉收藏列表接口
     * @param $uid int
     * @return $returnData json
     */
    public function getPeoList(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $uid = $request->get('uid');//获取用户的ID
        if (empty($uid)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }

        $collection = CardCollection::select('rid')->where(['rType' => 1, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//人脉

        $returnData['data'] = $collection;
        return response()->json($returnData);
    }

    /**
     * @author WEIYIZHENG
     * @remark 项目收藏列表接口
     * @param $request -> uid int 用户的ID
     * @return $returnData json
     */
    public function getProList(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $uid = $request->get('uid');//获取用户的ID
        if (empty($uid)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }

        $collection = CardCollection::select('rid')->where(['rType' => 2, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//项目

        $returnData['data'] = $collection;
        return response()->json($returnData);
    }
}