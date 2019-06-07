<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/2
 * Time: 9:41 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\Script;
use Illuminate\Http\Request;

class ScriptController extends BaseController
{
    /**
     * @remark 剧本列表
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
        $scriptData = Script::select()->paginate($request->get('limit',5))->toArray();

        $returnData['data'] = $scriptData['data'];

        return response()->json($returnData);
    }

    /**
     * @remark 剧本详情
     */
    public function detail(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $id = $request->get('sid'); //todo 剧本ID
        if (empty($id)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'screenwriter id is empty';
            return response()->json($returnData);
        }
        $script = Script::findOrFail($id);
        $returnData['data'] = $script;
        return response()->json($returnData);
    }
}