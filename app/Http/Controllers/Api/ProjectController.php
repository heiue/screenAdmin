<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/30
 * Time: 7:44 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\CardAnnex;
use App\Models\CardProject;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    protected $typeData = [];
    /**
     * @remark 项目接口列表
     * @param Request $request
     * @param page 页码
     * @param limit 条数
     * @param type 项目分类 （先写死）
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $where = [];
        $typeId = $request->get('type');
        if (!empty($typeId)) {
            $where['type'] = $typeId;
        }
        $screenwriterData = CardProject::select('projectTitle','isPublic', 'isTop', 'isFine', 'projectType', 'created_at')->where($where)->orderBy('isTop','desc')->paginate($request->get('limit',10))->toArray();

        $returnData['data'] = $screenwriterData;

        return response()->json($screenwriterData);
    }


    /**
     * @remark 项目详情
     * @param projectId 项目ID
     */
    public function projectDetail(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $projectId = $request->get('projectId');
        if (empty($projectId)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'projectId is empty';
            return response()->json($returnData);
        }
        $project = CardProject::findOrFail($projectId);
        if ($project) {
            $img = CardAnnex::select('path')->where(['aboutId' => $projectId,'aboutType' => 'project', 'type' => 'img'])->get()->toArray();
            $project['img'] = $img;
        }
        $returnData['data'] = $project;
        return response()->json($returnData);
    }
}