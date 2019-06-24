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
     * @remark 即时通讯im信息
     */
    public function im(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $identifier = $request->get('identifier');
        $model = new UserModel();
        //todo 即时通讯
        $imResult = $model->userSigIm($identifier);
        $returnData['data']['usersig'] = $imResult;
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
            return response()->json(['code' => -1, 'msg' => '缺少必要的参数：token']);
        }
        if (!$userOpenId = UserModel::getUserOpenId($token)) {
            return response()->json(['code' => -1, 'msg' => '没有找到用户信息']);
        }

//        $openId = $request->get('openid', '');//获取请求参数openid
        if (empty($userOpenId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'openid is empty';
            return response()->json($returnData);
        }
        $userInfo = CardUser::where('openid', $userOpenId)->first();
        if (strtotime($userInfo['vip_end']) <= time()) {
            $userInfo->is_vip = 'false';
            $userInfo->save();
        }
        $identifier_prefix = 'ju';
        $model = new UserModel();
        //todo 即时通讯
        $imResult = $model->userSigIm($identifier_prefix.$userInfo['id'],$userInfo['name'], $userInfo['pic']);
        $userInfo['identifier'] = $identifier_prefix.$userInfo['id'];
        $userInfo['usersig'] = $imResult;

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
        $cardInfo['identifier'] = 'ju'.$cardInfo['uid'];
        $returnData['data']['cardInfo'] = $cardInfo;
        $returnData['data']['_token'] = csrf_token();
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
        "pic":"url",
        "is_aut":"false"  //判断是不是公开隐私信息
	},
	"info":{
		"mobile":"手机",
		"wechat":"微信",
		"email":"",
		"address":"",
		"intro":"简介"
        "top_pic":""
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
        $cardid = !empty($cardDataR['cardid']) ? $cardDataR['cardid'] : '';
        $uid = !empty($cardDataR['uid']) ? $cardDataR['uid'] : '';
        $cardData = $cardDataR['card'];
        $infoData = $cardDataR['info'];
//        if (empty($cardData) || empty($cardData['name']) || empty($cardData['company']) || empty($cardData['position']) || empty($cardData['industry_id']) || empty($cardData['pic']) || empty($infoData) || empty($infoData['mobile']) || empty($infoData['wechat']) || empty($infoData['email']) || empty($infoData['address']) || empty($infoData['intro'])) {
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
            $cardCard = CardCard::select()->where(['uid' => $uid])->first();
            if (!empty($cardCard)) {
                if (CardCard::where('uid', $uid)->update($cardData)) {
                    CardInfo::where('card_id', $cardCard['id'])->update($infoData);
                    return response()->json($returnData);
                } else {
                    $returnData['error'] = 104;
                    $returnData['msg'] = 'update is error';
                    return response()->json($returnData);
                }
            } else {
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
     * @param $rType int 类型 1 是人脉 2 是项目 3是剧本 4是编剧
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
        $collection = CardCollection::select()->where(['rid' => $rid, 'uid' => $uid, 'rType' => $rType])->first();
        if (!$collection) {
            $collectionI = new CardCollection();
            $collectionI->rid = $rid;
            $collectionI->uid = $uid;
            $collectionI->rType = $rType;
            if ($insertId = $collectionI->save()) {
                $returnData['id'] = $collectionI->id;
                $returnData['success'] = true;
                $returnData['msg'] = '已关注或收藏';
                return response()->json($returnData);
            }
        } else {
            CardCollection::destroy($collection['id']);
            $returnData['error'] = 0;
            $returnData['success'] = false;
            $returnData['msg'] = '已取消关注或收藏';
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

        $collection = CardCollection::select('rid','rType')->where(['rType' => 1, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//人脉

        $returnData['data'] = $collection['data'];
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

        $collection = CardCollection::select('rid','rType')->where(['rType' => 2, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//项目

        $returnData['data'] = $collection['data'];
        return response()->json($returnData);
    }
    /**
     * @author WEIYIZHENG
     * @remark 剧本收藏列表接口
     * @param $request -> uid int 用户的ID
     * @return $returnData json
     */
    public function getScriptList(Request $request) {
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

        $collection = CardCollection::select('rid','rType')->where(['rType' => 3, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//剧本

        $returnData['data'] = $collection['data'];
        return response()->json($returnData);
    }

    /**
     * @author WEIYIZHENG
     * @remark 编剧收藏列表接口
     * @param $request -> uid int 用户的ID
     * @return $returnData json
     */
    public function getScreenList(Request $request) {
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

        $collection = CardCollection::select('rid','rType')->where(['rType' => 4, 'uid' => $uid])->paginate($request->get('limit',10))->toArray();//编剧

        $returnData['data'] = $collection['data'];
        return response()->json($returnData);
    }
}