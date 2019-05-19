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
        $model = new UserModel;
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
            $returnData['msg'] = 'id is empty';
            return response()->json($returnData);
        }
        $cardInfo = CardCard::where('uid', $id)->first();
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
        $returnData = [
            'error' => 0,
            'msg' => 'Successful editing',
            'data' => []
        ];
        $id = $request->get('cardid', 0);
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
        if (CardCard::where('id', $id)->update($formData)) {
            return response()->json($returnData);
        } else {
            $returnData['error'] = 104;
            $returnData['msg'] = 'update is error';
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