<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2019/1/28
 * Time: 11:08
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Attrname;
use App\Models\Attrvalue;
use App\Models\Cates;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /******************************规格名称*****************************
     * */
    public function attrname() {
        return view('admin.product.attrname');
    }

    /*
     * 显示资源列表
     * */
    public function attrname_data(Request $request) {
        $res = Attrname::paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /*
     * 规格名称-添加
     * */
    public function attrname_create() {
        return view('admin.product.attrname_create');
    }
    /*
     * 添加保存
     * */
    public function attrname_save(Request $request)
    {
        $this->validate($request,[
            'title'  => 'required|string',
        ]);
//        dump($request->all());exit;
        if (Attrname::create($request->all())){
            return redirect(route('admin.product.attrname'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.attrname'))->with(['status'=>'系统错误']);
    }

    /*
     * 规格名称-编辑
     * */
    public function attrname_edit($id) {
        $attrname = Attrname::findOrFail($id);
        return view('admin.product.attrname_edit',compact('attrname'));
    }

    /*
     * 编辑保存
     * */
    public function attrname_update(Request $request, $id)
    {
        $this->validate($request,[
            'title'  => 'required|string',
        ]);
        $tag = Attrname::findOrFail($id);
        if ($tag->update($request->only(['title']))){
            return redirect(route('admin.product.attrname'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.product.attrname'))->withErrors(['status'=>'系统错误']);
    }



    /*
     * 规格名称-删除
     * */
    public function attrname_destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Attrname::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /*
     * ******************************规格名称end********************************/

    /********************************规格属性值*********************************
     * */
    public function attrvalue() {
        $attrname = Attrname::get();
        return view('admin.product.attrvalue',compact('attrname'));
    }

    public function attrvalue_data(Request $request) {
        $model = Attrvalue::query();
        if ($request->get('name_id')) {
            $model = $model->where('name_id',$request->get('name_id'));
        }
        if ($request->get('value')) {
            $model = $model->where('value','like','%'.$request->get('value').'%');
        }
        $res = $model->with(['attrname'])->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    public function attrvalue_create() {
        $attrname = Attrname::get();
        return view('admin.product.attrvalue_create',compact('attrname'));
    }
    /*
     * 添加保存
     * */
    public function attrvalue_save(Request $request)
    {
        $this->validate($request,[
            'value'  => 'required|string',
            'name_id' => 'required|int',
        ]);
//        dump($request->all());exit;
        if (Attrvalue::create($request->all())){
            return redirect(route('admin.product.attrvalue'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.attrvalue'))->with(['status'=>'系统错误']);
    }

    /*
     * 属性值-编辑
     * */
    public function attrvalue_edit($id) {
        $attrvalue = Attrvalue::findOrFail($id);
        $attrname = Attrname::get();
        return view('admin.product.attrvalue_edit',compact('attrvalue','attrname'));
    }
    /*
     * 编辑保存
     * */
    public function attrvalue_update(Request $request, $id)
    {
        $this->validate($request,[
            'value'  => 'required|string',
            'name_id' => 'required|int'
        ]);
        $tag = Attrvalue::findOrFail($id);
        if ($tag->update($request->only(['value','name_id','img']))){
            return redirect(route('admin.product.attrvalue'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.product.attrvalue'))->withErrors(['status'=>'系统错误']);
    }


    /*
     * 属性值-删除
     * */
    public function attrvalue_destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Attrvalue::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
    /*
     * ******************************规格属性值end******************************/

    /********************************商品分类**********************************
     * */
    public function cates() {
        return view('admin.product.cates.cates');
    }

    public function cates_data(Request $request) {
        $model = Cates::query();

        $res = $model->where('pid',$request->get('parent_id',0))->orderBy('id','desc')->orderBy('ord','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    //添加
    public function cates_create() {
        $cates = Cates::get()->toArray();
        if (!empty($cates)) {
            $cates = $this->tree(Cates::get()->toArray(),'id','pid');
        }
        return view('admin.product.cates.create',compact('cates'));
    }
    public function cates_save(Request $request)
    {
        $this->validate($request,[
            'title'  => 'required|string',
            'ord'  => 'required|numeric',
            'pid' => 'required|numeric'
        ]);
        if (Cates::create($request->all())){
            return redirect(route('admin.product.cates'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.product.cates'))->with(['status'=>'系统错误']);
    }


    //编辑
    public function cates_edit($id) {
        $cate = Cates::findOrFail($id);
        $cates = Cates::get()->toArray();
        if (!empty($cates)) {
            $cates = $this->tree(Cates::get()->toArray(),'id','pid');
        }
        return view('admin.product.cates.edit',compact('cate','cates'));
    }
    public function cates_update(Request $request, $id) {
        $this->validate($request,[
            'title'  => 'required|string',
            'ord'  => 'required|numeric',
            'pid' => 'required|numeric'
        ]);
        $cate = Cates::findOrFail($id);
        if ($cate->update($request->all())) {
            return redirect(route('admin.product.cates'))->with(['status'=>'更新成功']);
        } else {
            return redirect(route('admin.product.cates'))->with(['status'=>'系统错误']);
        }
    }

    //删除
    public function cates_destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $cates = Cates::with(['childs'])->find($ids);

        if (!$cates){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (!$cates->childs->isEmpty()){
            return response()->json(['code'=>1,'msg'=>'该分类下有子分类，不能删除']);
        }
        if ($cates->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }


    /*
     * ******************************商品分类end********************************/
}