<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/31
 * Time: 1:51 PM
 */

namespace App\Http\Controllers\Api;


use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    /**
     * @remark 大家都在看文章列表
     */
    public function list(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];

        $article = Article::orderBy('id', 'desc')->paginate($request->get('limit',10))->toArray();

        $returnData['data'] = $article;

        return response()->json($returnData);
    }

    /**
     * @remark 文章详情
     */
    public function detail(Request $request) {
        $returnData = [
            'error' => 0,
            'msg' => 'success',
            'data' => []
        ];
        $aid = $request->get('aid');
        if (empty($aid)) {
            $returnData['error'] = 101;
            $returnData['msg'] = 'aid is empty';
            return response()->json($returnData);
        }
        $article = Article::findOrFail($aid);

        $returnData['data'] = $article;
        return response()->json($returnData);
    }
}