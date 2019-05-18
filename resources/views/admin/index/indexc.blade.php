@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15" id="LAY-flow-demo">
        <style>
            #LAY-flow-demo .flow-default{height: 400px; overflow: auto; font-size: 0;}
            #LAY-flow-demo .flow-default li{display: inline-block; margin: 0 5px; font-size: 14px; width: 30%;  margin-bottom: 10px; text-align: center; background-color: #eee;}
            #LAY-flow-demo .flow-default img{width: 100%; height: 100%;}
            #LAY-flow-demo .site-demo-flow{width: 600px; height: 300px; overflow: auto; text-align: center;}
            #LAY-flow-demo .site-demo-flow img{width: 40%; height: 200px; margin: 0 2px 5px 0; border: none;}

            @media screen and (max-width: 768px) {
                #LAY-flow-demo .flow-default,
                #LAY-flow-demo .site-demo-flow{width: 100%;}
                #LAY-flow-demo .flow-default li{width: 45%}
                #LAY-flow-demo .site-demo-flow img{height: 150px;}
            }
        </style>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header layuiadmin-card-header-auto">
                    <div class="layui-btn-group">
                        @can('product.attrvalue.create')
                            <a class="layui-btn layui-btn-sm" id="banner_add" href="javascirpt:;">添 加 图 片</a>
                        @endcan
                        <button class="layui-btn layui-btn-sm" id="searchBtn">切 换</button>
                    </div>
                    <div class="layui-form" >
                        <div class="layui-input-inline">
                            <select name="name_id" lay-verify="required" id="name_id">
                                <option value="">请选择规格名称</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-card-header">轮播图</div>
                <div class="layui-card-body">
                    <ul class="flow-default" style="height: 1000px;" id="test-flow-manual">
                    </ul>
                    {{--<ul id="demo">
                    <li>1</li>
                    <li>2</li>
                    <li>6</li>
                    </ul>--}}
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div class="layui-carousel" id="test-carousel-normal">
                        <div carousel-item>
                            <div>条目1</div>
                            <div>条目2</div>
                            <div>条目3</div>
                            <div>条目4</div>
                            <div>条目5</div>
                        </div>
                    </div>
                    {{--<div class="layui-carousel" id="test-carousel-normal-2" style="margin-top: 15px; width: 600px; height: 120px;" lay-anim="fade" lay-indicator="inside" lay-arrow="hover">
                        <div carousel-item="">
                            <div class="layui-this">条目1</div>
                            <div class="">条目2</div>
                        </div>
                        <div class="layui-carousel-ind"><ul><li class="layui-this"></li><li class=""></li></ul></div><button class="layui-icon layui-carousel-arrow" lay-type="sub"></button><button class="layui-icon layui-carousel-arrow" lay-type="add"></button></div>--}}
                </div>
            </div>
        </div>

    </div>
    <div class="layui-layer-move" style="cursor: move; display: none;"></div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'carousel', 'sample'], function () {
            var carousel = layui.carousel;

            //常规轮播
            carousel.render({
                elem: '#test-carousel-normal',
                anim: 'fade',
                width: '100%',
                height: '300px'
            });

            /*//改变下时间间隔、动画类型、高度
            carousel.render({
                elem: '#test-carousel-normal-2'
                ,interval: 1800
                ,anim: 'fade'
                ,height: '120px'
            });*/

            $('#banner_add').on('click', function(){
                var index = layer.open({
                    type: 2,
                    content: 'http://baidu.com',
                    area: ['300px', '300px'],
                    maxmin: true
                });
                layer.full(index);
            });


        });

        layui.use(['flow'], function () {

            var flow = layui.flow;
            flow.load({
                elem: '#test-flow-manual' //流加载容器
                ,scrollElem: '#test-flow-manual'
                ,isAuto: false
                ,isLazyimg: true
                ,done: function(page, next){ //加载下一页
                    //模拟插入
                    setTimeout(function(){
                        var lis = [];
                        for(var i = 0; i < 6; i++){
                            lis.push('<li><div class="layui-card-header"><button class="layui-btn layui-btn-sm layui-btn-danger listDelete" style="width:100%">删 除</button></div><img lay-src="http://s17.mogucdn.com/p2/161011/upload_279h87jbc9l0hkl54djjjh42dc7i1_800x480.jpg?v='+ ( (page-1)*6 + i + 1 ) +'"></li>')
                        }
                        next(lis.join(''), page < 6); //假设总页数为 6
                    }, 500);
                }
            });

            /*flow.load({
                elem: '#demo',
                done: function (page, next) {
                    var lis = []
                    $.get('/api/list?page='+page, function(res){
        //假设你的列表返回在data集合中
        layui.each(res.data, function(index, item){
          lis.push('<li>'+ item.title +'</li>');
        });

        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
        next(lis.join(''), page < res.pages);
      });
                }
            });*/

            $("#test-flow-manual").on('click', '.listDelete', function () {
                alert()
            });

        });

    </script>
@endsection