<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/27
 * Time: 19:48
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardAnnex;
use App\Models\Screenwriter;
use Illuminate\Http\Request;

class ScreenwriterController extends Controller
{
    /**
     * @author WEIYIZHENG
     * @remark 编剧列表页
     * */
    public function index() {
        return view('admin.screenwriter.index');
    }

    /**
     * @author WEIYIZHENG
     * @remark 显示编剧列表
     * @param $request //搜索条件
     * @return object
     * */
    public function data(Request $request) {
        $res = Screenwriter::paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }


    //编剧添加
    public function create() {
        $rating = [
            '1' => '金牌编剧',
            '2' => '著名编剧',
            '3' => '知名编剧',
            '4' => '新锐编剧',
        ];
        return view('admin.screenwriter.create');
    }
    //添加保存
    public function save(Request $request)
    {
        $this->validate($request,[
            'name'  => 'required|string',
            'rating'  => 'required',
            'residence'  => 'required',
            'avatar'    => 'required',
            'phone' => 'required|max:15'
        ]);
//        dump($request->all());exit;
        if ($insertId = Screenwriter::create($request->all())->id){
            $annex = new CardAnnex();
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
                        'aboutType' => 'screenwriter',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($fileData);
            }
            return redirect(route('admin.screen.writer'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.screenwriter.create'))->with(['status'=>'系统错误']);
    }

    //编辑编剧
    public function edit($id) {
        $screenwriter = Screenwriter::findOrFail($id);
        $fileData = CardAnnex::select('id','path','size')->where(['aboutId' => $screenwriter->id, 'type' => 'file', 'aboutType' => 'screenwriter'])->get();
        $screenwriter->file = $fileData;
        $screenwriter->fileCount = count($fileData);
        return view('admin.screenwriter.edit',compact('screenwriter'));
    }
    //保存编辑的编剧
    public function update(Request $request, $id) {
        $this->validate($request,[
            'name'  => 'required|string',
            'rating'  => 'required',
            'residence'  => 'required',
            'phone' => 'required|max:15'
        ]);
        $scr = Screenwriter::findOrFail($id);
        if ($scr->update($request->only(null))){
            $annex = new CardAnnex();
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
                        'aboutType' => 'screenwriter',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $annex->addAll($fileData);
            }
            return redirect(route('admin.screen.writer'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.screen.writer'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * @author WEIYIZHENG
     * @remark 删除编剧
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Screenwriter::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * @remark 更新编剧公开不公开
     *
     */
    public function updateIsPublic(Request $request) {
        $ids = $request->get('ids', '0');
        $isPublic = $request->get('isPublic', 0);
        $field = $request->get('field', '');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'ids is empty']);
        }
        $screenWriter = Screenwriter::findOrFail($ids);
        if (empty($screenWriter)) {
            return response()->json(['code'=>1,'msg'=>'this screenWriter is empty']);
        }
        switch ($field) {
            case 'public':
                $screenWriter->isPublic = $isPublic;
                break;
            case 'hot':
                $screenWriter->isHot = $isPublic;
                break;
            default:
                return response()->json(['code'=>1,'msg'=>'Field is not specified']);
        }
        if ($screenWriter->save()){
            return response()->json(['code'=>0,'msg'=>'success']);
        }
        return response()->json(['code'=>1,'msg'=>'error']);
    }

}