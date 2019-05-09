<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 21:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Script;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    /**
     * @author WEIYIZHENG
     * @remark 剧本展示页
     */
    public function index() {
        return view('admin.script.index');
    }

    /**
     * @author WEIYIZHENG
     * @remark 剧本页列表
     * @param Request $request
     * @return object json
     */
    public function data(Request $request) {
        $res = Script::paginate($request->get('limit',30))->toArray();
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
     * @remark 添加剧本
     */
    public function create() {
        return view('admin.script.create');
    }

    /**
     * @author WEIYIZHENG
     * @remark 添加剧本保存数据
     */
    public function save(Request $request) {
        $this->validate($request,[
            'scriptTitle'  => 'required|string',
            'scriptType'  => 'required',
            'scriptTheme'  => 'required',
        ]);
//        dump($request->all());exit;
        if (Script::create($request->all())){
            return redirect(route('admin.script.index'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.script.create'))->with(['status'=>'系统错误']);
    }

    /**
     * @author WEIYIZHENG
     * @remark 编辑剧本
     */
    public function edit($id) {
        $screenwriter = Script::findOrFail($id);
        return view('admin.script.edit',compact('script'));
    }

    /**
     * @author WEIYIZHENG
     * @remark 编辑剧本保存
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        $this->validate($request,[
            'scriptTitle'  => 'required|string',
            'scriptType'  => 'required',
            'scriptTheme'  => 'required',
        ]);
        $scr = Script::findOrFail($id);
        if ($scr->update($request->only(null))){
            return redirect(route('admin.script.index'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.script.index'))->withErrors(['status'=>'系统错误']);
    }


    /**
     * @author WEIYIZHENG
     * @remark 删除剧本
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Script::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}