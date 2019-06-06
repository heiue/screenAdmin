<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/6
 * Time: 3:30 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\CardElite;
use Illuminate\Http\Request;

class KnowledgeController extends BaseController
{
    /**
     * @remark 精英养成列表
     * @param Request $request
     * @param page 页码
     * @param limit 条数
     * @return \Illuminate\Http\JsonResponse
     */
    public function list_elite(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $eliteData = CardElite::select()->paginate($request->get('limit',5))->toArray();

        $returnData['data'] = $eliteData['data'];

        return response()->json($returnData);
    }


    /**
     * @remark 精英养成详情
     */
    public function detail_elite(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $id = $request->get('eid'); //todo 精英养成ID
        if (empty($id)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'screenwriter id is empty';
            return response()->json($returnData);
        }
        $elite = CardElite::findOrFail($id);
        $returnData['data'] = $elite;
        return response()->json($returnData);
    }


}