<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 21:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardAnnex;
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
        if ($insertId = Script::create($request->all())->id){
            $annex = new CardAnnex();
            //todo 判断图集 添加图片附件
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
                        'aboutType' => 'script',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($imgData);
            }

            $file = $request->get('files');
            $fsize = $request->get('fsize', []);
            $fext = $request->get('fext', []);
            if (!empty($file)) {
                $fileData = array();
                foreach ($file as $key => $value) {
                    $fileData[] = [
                        'type' => 'file',
                        'path' => $value,
                        'size' => $fsize[$key]?$fsize[$key]:0,
                        'format' => $fext[$key]?$fext[$key]:'',
                        'aboutId' => $insertId,
                        'aboutType' => 'script',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($fileData);
            }
            return redirect(route('admin.script.index'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.script.create'))->with(['status'=>'系统错误']);
    }

    /**
     * @author WEIYIZHENG
     * @remark 编辑剧本
     */
    public function edit($id) {
        $script = Script::findOrFail($id);
        $imgData = CardAnnex::select('id','path')->where(['aboutId' => $script->id, 'type' => 'img', 'aboutType' => 'script'])->get();
        $fileData = CardAnnex::select('id','path','size')->where(['aboutId' => $script->id, 'type' => 'file', 'aboutType' => 'script'])->get();
        $script->img = $imgData;
        $script->imgCount = count($imgData);
        $script->file = $fileData;
        $script->fileCount = count($fileData);
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
            $annex = new CardAnnex();
            //todo 判断图集 添加图片附件
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
                        'aboutType' => 'script',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($imgData);
            }

            $file = $request->get('files');
            $fsize = $request->get('fsize', []);
            $fext = $request->get('fext', []);
            if (!empty($file)) {
                $fileData = array();
                foreach ($file as $key => $value) {
                    $fileData[] = [
                        'type' => 'file',
                        'path' => $value,
                        'size' => $fsize[$key]?$fsize[$key]:0,
                        'format' => $fext[$key]?$fext[$key]:'',
                        'aboutId' => $id,
                        'aboutType' => 'script',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($fileData);
            }
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