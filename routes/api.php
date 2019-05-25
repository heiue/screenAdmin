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



    //个人信息路由组
    Route::group([], function () {
        //获取本人的信息
        Route::match(['get', 'post'], '/user/getuserinfo', 'UserController@getUserInfo');
        //编辑本人的信息
        Route::match(['post'], '/user/updateuser', 'UserController@updateUserInfo');
        //获取个人名片信息
        Route::match(['get'], '/user/getusercard', 'UserController@getUserCard');
        //编辑个人名片信息
        Route::match(['post'], '/user/updateusercard', 'UserController@updateUserCard');


        /*收藏*/
        Route::match(['get'], '/collection/peolist', '/UserController@getPeoList');//人脉收藏
        Route::match(['get'], '/collection/prolist', '/UserController@getProList');//项目收藏
        Route::match(['post'], '/collection/create', '/UserController@addCollection');//添加收藏

    });

    //编剧列表
    Route::match(['get','post'], '/screenwriter/list', 'ScreenwriterController@list');



});