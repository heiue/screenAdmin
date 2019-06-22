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
        '0' => '全部',
        '1' => '犯罪',
        '2' => '悲剧',
        '3' => '喜剧',
        '4' => '爱情',
        '5' => '动作',
        '6' => '枪战',
        '7' => '惊悚',
        '8' => '恐怖',
        '9' => '悬疑',
        '10' => '动画',
        '11' => '奇幻',
        '12' => '魔幻',
        '13' => '科幻',
        '14' => '战争',
        '15' => '剧情片',
        '16' => '伦理片',
        '17' => '传记片',
        '18' => '青春',
        '19' => '歌舞',
        '20' => '热血',
        '21' => '冒险',
        '22' => '校园',
        '23' => '运动',
        '24' => '历史',
        '25' => '励志',
        '26' => '古装',
        '27' => '言情',
        '28' => '军事',
        '29' => '警匪',
        '30' => '武侠',
        '31' => '农村',
        '32' => '都市',
        '33' => '神话',
        '34' => '玄幻',
        '35' => '谍战',
        '36' => '年代',
        '37' => '儿童',
        '38' => '音乐',
        '39' => '西部',
        '40' => '治愈',
        '41' => '史诗',
        '42' => '主旋律',
        '43' => '军旅',
        '44' => '抗战',
        '45' => '江湖',
        '46' => '现代',
        '47' => '公路',
        '48' => '商战',
        '49' => '民国',
        '50' => '仙侠',
        '51' => '宫廷',
        '52' => '穿越',
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
        $returnData['data']['type1'] = self::$typeData;
        $returnData['data']['type2'] = self::$type2Data;
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
        $type2Id = $request->get('type2');
        if (!empty($typeId)) {
            $where['projectType'] = $typeId;
        }
        if (!empty($type2Id)) {
            $where['projectType2'] = $type2Id;
        }
        $projectData = CardProject::with(['cardAnnexImg' => function($query){
            $query->select('aboutId', 'path')->where(['aboutType' => 'project', 'type' => 'img']);
        }])->select()->where($where)->orderBy('isTop','desc')->paginate($request->get('limit',10))->toArray();

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
            //todo 增加浏览量
            CardProject::where('id', $projectId)->increment('browseCount');

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