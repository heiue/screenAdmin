<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 3:24 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\Screenwriter;
use Illuminate\Http\Request;

/**
 * Class ScreenwriterController
 * @package App\Http\Controllers\Api
 * @remark 编剧类接口
 */
class ScreenwriterController extends BaseController
{
    /**
     * @remark 编剧列表
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
        $position = $request->get('position', 0);
        $where = ['isPublic' => 1];
        switch ($position) {
            case 0:

                break;
            case 1:
                $where = ['isHot' => 0];

                break;
            case 2:
                $where = ['isHot' => 1];
                break;
        }
        $screenwriterData = Screenwriter::select('id', 'name', 'rating', 'residence','isPublic','avatar')->where($where)->paginate($request->get('limit',5))->toArray();

        $returnData['data'] = $screenwriterData['data'];

        return response()->json($returnData);
    }

    /**
     * @remark 编剧详情
     */
    public function detail(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $id = $request->get('sid'); //todo 编剧ID
        if (empty($id)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'screenwriter id is empty';
            return response()->json($returnData);
        }
        $screenwriter = Screenwriter::findOrFail($id);
        $returnData['data'] = $screenwriter;
        return response()->json($returnData);
    }
}