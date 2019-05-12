<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 4:11 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\CardUser;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 * @remark 个人信息类
 */
class UserController extends Controller
{
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
        $openId = $request->get('openid', '');//获取请求参数openid
        if (empty($openId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'openid is empty';
            return response()->json($returnData);
        }
        $userInfo = CardUser::where('openid', $openId)->get();
        $returnData['data']['userinfo'] = $userInfo;
        return response()->json($returnData);
    }

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
}