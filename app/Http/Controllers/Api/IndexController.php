<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/11
 * Time: 12:47 AM
 */

namespace App\Http\Controllers\Api;

use App\Models\CardCard;
use App\Models\CardProject;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index() {
        echo json_encode(['error' => 0,'msg' => 'success', 'data' => ['a' => 1]]);exit;
    }

    /**
     * @搜索
     */
    public function search(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $keyWord = $request->get('keyword');
        if (empty($keyWord)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'keyword is empty';
            return response()->json($returnData);
        }
        //搜索项目
        $project = CardProject::where('name', 'like', "%{$keyWord}%")->limit($request->get('limit', 10))->get()->toArray();

        //搜索人脉
        $card = CardCard::where('', 'like', "%{$keyWord}%")->limit($request->get('limit', 10))->get()->toArray();

        $returnData['data']['project'] = $project;
        $returnData['data']['card'] = $card;

        return response()->json($returnData);
    }
}