<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 8:24 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Project;
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
        $res = Project::paginate($request->get('limit',30))->toArray();
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
        if (Project::create($request->all())) {
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
        $project = Project::findOrFail($id);
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
        $pro = Project::findOrFail($id);
        if ($pro->update($request->only(null))){
            return redirect(route('admin.project.index'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.project.index'))->withErrors(['status'=>'系统错误']);
    }

    public function destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Project::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}