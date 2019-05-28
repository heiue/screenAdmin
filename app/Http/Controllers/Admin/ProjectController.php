<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 8:24 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardAnnex;
use App\Models\CardProject;
use App\Models\CardProjectTrack;
use Illuminate\Http\Request;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Admin
 * @remark 项目管理
 */
class ProjectController extends Controller
{
    /**
     * @author WEIYIZHENG
     * @remark 项目展示页
     *
     */
    public function index() {
        return view('admin.project.index');
    }

    /**
     * @author WEIYIZHENG
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request) {
        $res = CardProject::paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }


    /**
     * @author WEIYIZHENG
     * @remark 项目添加
     *
     */
    public function create() {
        return view('admin.project.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request) {
        $this->validate($request, [
            'projectTitle' => 'required',
            'projectType' => 'required',
        ]);
        $insertId = CardProject::create($request->all())->id;
        if ($insertId) {
            $annex = new CardAnnex();
            //判断图集 添加图片附件
            $img = $request->get('img');
            $size = $request->get('size', []);
            $ext = $request->get('ext', []);
            if (!empty($img)) {
                $imgData = array();
                foreach ($img as $key => $value) {
                    $imgData[] = [
                        'type' => 'img',
                        'path' => $value,
                        'size' => $size[$key]?$size[$key]:0,
                        'format' => $ext[$key]?$ext[$key]:'',
                        'aboutId' => $insertId,
                        'aboutType' => 'project',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($imgData);
            }
            return redirect(route('admin.project.index'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.project.create'))->with(['status'=>'系统错误']);
    }

    /**
     * @author WEIYIZHENG
     * @remark 项目编辑
     * @param $id int
     * @return string
     */
    public function edit($id) {
        $project = CardProject::findOrFail($id);
        $imgData = CardAnnex::select('id','path')->where(['aboutId' => $project->id, 'type' => 'img', 'aboutType' => 'project'])->get();
        $project->img = $imgData;
        $project->imgCount = count($imgData);
        return view('admin.project.edit',compact('project'));
    }

    /**
     * @author WEIYIZHENG
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id) {
        $this->validate($request,[
            'projectTitle'  => 'required',
            'projectType'  => 'required',
        ]);
        if (empty($request->get('isPublic'))) {
            $request->offsetSet('isPublic', 0);
        };
        $pro = CardProject::findOrFail($id);
        if (!empty($pro)) {
            $annex = new CardAnnex();
            //判断图集 添加图片附件
            $img = $request->get('img');
            $size = $request->get('size', []);
            $ext = $request->get('ext', []);
            if (!empty($img)) {
                $imgData = array();
                foreach ($img as $key => $value) {
                    $imgData[] = [
                        'type' => 'img',
                        'path' => $value,
                        'size' => $size[$key]?$size[$key]:0,
                        'format' => $ext[$key]?$ext[$key]:'',
                        'aboutId' => $id,
                        'aboutType' => 'project',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($imgData);
            }
        }
        if ($pro->update($request->only(null))){
            return redirect(route('admin.project.index'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.project.index'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * @remark 项目删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (CardProject::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * @remark 更新项目公开不公开  置不置顶  加不加精
     *
     */
    public function updateIsPublic(Request $request) {
        $ids = $request->get('ids', '0');
        $isPublic = $request->get('isPublic', 0);
        $field = $request->get('field', '');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'ids is empty']);
        }
        if (empty($field)) {
            return response()->json(['code'=>1,'msg'=>'field is empty']);
        }
        $cardProject = CardProject::findOrFail($ids);
        if (empty($cardProject)) {
            return response()->json(['code'=>1,'msg'=>'this cardPorject is empty']);
        }
        switch ($field) {
            case 'public':
                $cardProject->isPublic = $isPublic;
                break;
            case 'top':
                $cardProject->isTop = $isPublic;
                break;
            case 'fine':
                $cardProject->isFine = $isPublic;
                break;
            default:
                return response()->json(['code'=>1,'msg'=>'Field is not specified']);
        }
        if ($cardProject->save()){
            return response()->json(['code'=>0,'msg'=>'success']);
        }
        return response()->json(['code'=>1,'msg'=>'error']);
    }

    /**
     * @remark 项目跟踪
     */
    public function track($id) {
        $project = CardProject::findOrFail($id);
        $track = CardProjectTrack::where(['projectId' => $id])->orderBy('created_at','desc')->get()->toArray();
        return view('admin.project.track', compact('project', 'track'));
    }
    /**
     * @remark 添加项目跟踪记录
     */
    public function track_add(Request $request) {
//        dump($request->get('trackContent'));
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $proId = $request->get('proId');
        $trackContent = $request->get('trackContent');
        if (empty($trackContent)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'trackContent is empty';
            return response()->json($returnData);
        }
        $track = new CardProjectTrack();
        $track->projectId = $proId;
        $track->trackContent = htmlspecialchars($trackContent);
        $insertId = $track->save();
        return back();
    }
}