<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/5
 * Time: 2:04 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardElite;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    /**
     * @remark 精英养成首页
     */
    public function index_elite() {
        return view('admin.knowledge.elite.index');
    }

    /**
     * @remark 文章列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data_elite(Request $request)
    {

        $model = CardElite::query();
        if ($request->get('category_id')){
            $model = $model->where('category_id',$request->get('category_id'));
        } else {
            $model = $model->where('category_id',1);
        }
        $res = $model->orderBy('created_at','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * @remark 添加文章
     */
    public function create_elite() {
        return view('admin.knowledge.elite.create');
    }

    /**
     * @remark 保存文章
     */
    public function save_elite(Request $request) {
        $data = $request->all();
        $elite = CardElite::create($data);

        return redirect(route('admin.elite.index'))->with(['status'=>'添加成功']);
    }

    /**
     * @remark 编辑文章
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_elite($id) {
        $elite = CardElite::findOrFail($id);
        return view('admin.knowledge.elite.edit', compact('elite'));
    }

    /**
     * @remark 保存编辑文章
     */
    public function update_elite(Request $request, $id) {
        $elite = CardElite::findOrFail($id);
        $data = $request->all();
        if ($elite->update($data)){
            return redirect(route('admin.elite.index'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.elite.index'))->withErrors(['status'=>'系统错误']);
    }


    /**
     * @author WEIYIZHENG
     * @remark 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy_elite(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (CardElite::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}