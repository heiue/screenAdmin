<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/30
 * Time: 7:44 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\CardAnnex;
use App\Models\CardCollection;
use App\Models\CardProject;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    protected static $typeData = [
        '0' => '全部',
        '1' => '院线电影',
        '2' => '电视剧',
        '3' => '网络大电影',
        '4' => '网络剧',
        '5' => '央6',
        '6' => '舞台剧',
        '7' => '短视频',
        '8' => '小说'
    ];

    protected static $type2Data = [
        '1' => '言情类',
        '2' => '武侠类',
    ];

    /**
     * @remark 项目分类列表
     */
    public function classList() {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $returnData['data'] = self::$typeData;
        return response()->json($returnData);
    }
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
        $where = ['isPublic' => 1];
        $typeId = $request->get('type');
        if (!empty($typeId)) {
            $where['projectType'] = $typeId;
        }
        $projectData = CardProject::with(['cardAnnexImg' => function($query){
            $query->select('aboutId', 'path')->where(['aboutType' => 'project', 'type' => 'img']);
        }])->select('id', 'projectTitle','isPublic', 'isTop', 'isFine', 'projectType', 'created_at', 'financing', 'browseCount')->where($where)->orderBy('isTop','desc')->paginate($request->get('limit',10))->toArray();

        $returnData['data'] = $projectData['data'];

        return response()->json($returnData);
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
        $uid = $request->get('uid');
        $projectId = $request->get('projectId');
        if (empty($uid)) {
            $returnData['error'] = 102;
            $returnData['msg'] = 'uid is empty';
            return response()->json($returnData);
        }
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
        // todo 是否收藏过
        $where['rid'] = $projectId;
        $where['uid'] = $uid;
        $where['rType'] = 2;
        if (CardCollection::where($where)->first()) {
            $project['isCollection'] = 1;
        } else {
            $project['isCollection'] = 0;
        }
        $returnData['data'] = $project;
        return response()->json($returnData);
    }
}