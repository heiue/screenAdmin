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
        $where = [];
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
        $screenwriterData = Screenwriter::select('name', 'rating', 'residence','isPublic','avatar')->where($where)->paginate($request->get('limit',5))->toArray();

        $returnData['data'] = $screenwriterData;

        return response()->json($screenwriterData);
    }
}