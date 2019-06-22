<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return 123456;
});
/*-------------------------------以上无效------------------------------------*/
Route::group(['namespace' => 'Api'], function () {

    //测试
    Route::match(['get','post'], '/wechat/token', 'WechatController@token');
    //模版消息测试
    Route::match(['get','post'], '/wechat/send', 'WechatController@send');





    //微信开发
    Route::match(['get','post'], '/wechat', 'WechatController@token');

    //小程序用户登陆验证和自动注册
    Route::match(['post'], '/user/login', 'UserController@login');
    //小程序支付
    Route::match(['post'], '/pay', 'PayController@pay');
    Route::match(['get', 'post'], '/pay/notice', 'PayController@notify');

    //即时通讯
    Route::match(['get'], '/user/im', 'UserController@im');


    //个人信息路由组
    Route::group([], function () {
        //获取本人的信息
        Route::match(['get', 'post'], '/user/getuserinfo', 'UserController@getUserInfo');
        //编辑本人的信息
        Route::match(['post'], '/user/updateuser', 'UserController@updateUserInfo');
        //获取个人名片信息
        Route::match(['get', 'post'], '/user/getusercard', 'UserController@getUserCard');
        //编辑个人名片信息
        Route::match(['post'], '/user/updateusercard', 'UserController@updateUserCard');


        /*收藏*/
        Route::match(['get'], '/collection/peolist', 'UserController@getPeoList');//人脉收藏
        Route::match(['get'], '/collection/prolist', 'UserController@getProList');//项目收藏
        Route::match(['get'], '/collection/scriptlist', 'UserController@getScriptList');//剧本收藏
        Route::match(['get'], '/collection/screenlist', 'UserController@getScreenList');//编剧收藏
        Route::match(['post'], '/collection/save', 'UserController@saveCollection');//添加收藏

    });

    //编剧列表
    Route::match(['get','post'], '/screenwriter/list', 'ScreenwriterController@list');
    //编剧详情
    Route::match(['get', 'post'], '/screenwriter/detail', 'ScreenwriterController@detail');
    //大家都在看文章列表
    Route::match(['get'], '/article/list', 'ArticleController@list');
    //文章详情
    Route::match(['get'], '/article/detail', 'ArticleController@detail');

    //todo 任务广场 招聘列表
    Route::match(['get'], '/task/recruitment/list', 'ScreenwriterController@recruitment_list');
    Route::match(['get'], '/task/recruitment/detail', 'ScreenwriterController@recruitment_detail');

    //剧本列表
    Route::match(['get','post'], '/script/list', 'ScriptController@list');
    //剧本详情
    Route::match(['get', 'post'], '/script/detail', 'ScriptController@detail');


    //项目分类列表
    Route::match(['get'], '/project/class', 'ProjectController@classList');
    //项目列表
    Route::match(['get', 'post'], '/project/list', 'ProjectController@list');
    //项目详情
    Route::match(['get', 'post'], '/project/detail', 'ProjectController@projectDetail');


    //人脉圈分类
    Route::match(['get'], '/card/class', 'CardController@classList');
    //人脉圈列表
    Route::match(['get'], '/card/list', 'CardController@list');
    //人脉圈详情
    Route::match(['get'], '/card/detail', 'CardController@detail');

    //帮推
    Route::match(['get'], '/card/help', 'CardController@helpPush');

    //搜索接口
    Route::match(['get'], '/search', 'IndexController@search');


    //todo 知识付费
    //精英养成列表
    Route::match(['get'], '/knowledge/elite/list', 'KnowledgeController@list_elite');
    //精英养成详情
    Route::match(['get'], '/knowledge/elite/detail', 'KnowledgeController@detail_elite');

});