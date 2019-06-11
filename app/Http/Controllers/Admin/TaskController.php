<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/10
 * Time: 12:24 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardRecruitment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @remark 招聘管理首页
     */
    public function index_recruitment() {
        return view('admin.task.index');
    }

    /**
     * @remark 招聘管理列表
     */
    public function data_recruitment(Request $request) {
        $res = CardRecruitment::orderBy('id','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * @remark 招聘添加
     */
    public function create_recruitment() {
        return view('admin.task.create');
    }

    /**
     * @remark 添加保存
     */
    public function save_recruitment(Request $request) {
        $this->validate($request,[
            'position'  => 'required|string'
        ]);
        if (CardRecruitment::create($request->all())){
            return redirect(route('admin.recruitment.index'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.recruitment.index'))->with(['status'=>'系统错误']);
    }

    /**
     * @remark 编辑
     */
    public function edit_recruitment($id) {
        $recruitment = CardRecruitment::findOrFail($id);
        return view('admin.task.edit',compact('recruitment'));
    }

    /**
     * @remark 编辑保存
     */
    public function update_recruitment(Request $request, $id) {
        $this->validate($request,[
            'position'  => 'required|string'
        ]);
        $tag = CardRecruitment::findOrFail($id);
        if ($tag->update($request->all())){
            return redirect(route('admin.recruitment.index'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.recruitment.index'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     * @remark 删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_recruitment(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (CardRecruitment::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

}