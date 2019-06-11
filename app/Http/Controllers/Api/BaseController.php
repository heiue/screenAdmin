<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/17
 * Time: 11:38 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $aboutType = [
        '1' => '人脉',
        '2' => '项目',
        '3' => '剧本',
        '4' => '编剧',
        '5' => '精英'
    ];
}