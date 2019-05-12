<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/11
 * Time: 12:47 AM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index() {
        echo json_encode(['error' => 0,'msg' => 'success', 'data' => ['a' => 1]]);exit;
    }
}