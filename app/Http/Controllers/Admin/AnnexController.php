<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/26
 * Time: 7:11 PM
 */

/**
 * @remark 附件表控制器
 */
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CardAnnex;
use Illuminate\Http\Request;

class AnnexController extends Controller
{
    /**
     * @remark 删除附件  图片，文件等
     */
    public function destroy(Request $request) {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (CardAnnex::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}