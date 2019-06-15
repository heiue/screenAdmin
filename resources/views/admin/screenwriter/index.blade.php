@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('screen.writer.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                @endcan
                @can('screen.writer.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.screen.writer.create') }}">添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('screen.writer.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('screen.writer.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/html" id="switchTpl_Hot">
        <input type="checkbox" name="isTop" value="@{{d.isHot}}" lay-skin="switch" lay-text="ON|OFF"  proid="@{{ d.id }}" lay-filter="isHotDemo" @{{ d.isHot == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="switchTpl">
        <input type="checkbox" name="isPublic" value="@{{d.isPublic}}" lay-skin="switch" lay-text="公开|不公开" proid="@{{ d.id }}" lay-filter="isPublicDemo" @{{ d.isPublic == 1 ? 'checked' : '' }}>
    </script>
    @can('screen.writer.index')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.screen.writer.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'name', title: '编剧名'}
                        ,{field: 'rating_name', title: '编剧评级'}
                        ,{field: 'residence', title: '常住地'}
                        ,{field: 'works', title: '代表作品'}
                        ,{field:'isPublic', title:'设置', width:100, templet: '#switchTpl', unresize: true}
                        ,{field:'isTop', title:'热门', width:100, templet: '#switchTpl_Hot', unresize: true}
                        ,{field: 'created_at', title: '创建时间'}
                        ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.screen.writer.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/screenwriter/'+data.id+'/edit';
                    }
                });

                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.screen.writer.destroy') }}",{_method:'delete',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg,)
                            });
                        })
                    }else {
                        layer.msg('请选择删除项')
                    }
                })

                //监听设置操作 公开不公开
                form.on('switch(isPublicDemo)', function(obj){
                    if (obj.value == 1) {
                        $(this).val(0)
                        var isPublic = 0;
                    } else if (obj.value == 0) {
                        $(this).val(1)
                        var isPublic = 1;
                    }
                    var proid = $(this).attr('proid')
                    $.post("{{ route('admin.screenwriter.updateIsPublic') }}",{_method:'post',ids:proid,isPublic:isPublic,field:"public"},function (result) {
                        if (result.code==0){
                            layer.tips('已更新', obj.othis);
                        }
                        layer.msg(result.msg,)
                    });
                });

                //监听置顶
                form.on('switch(isHotDemo)', function(obj){
                    if (obj.value == 1) {
                        $(this).val(0)
                        var isHot = 0;
                    } else if (obj.value == 0) {
                        $(this).val(1)
                        var isHot = 1;
                    }
                    var proid = $(this).attr('proid')
                    $.post("{{ route('admin.screenwriter.updateIsPublic') }}",{_method:'post',ids:proid,isPublic:isHot, field:"hot"},function (result) {
                        if (result.code==0){
                            layer.tips('已更新', obj.othis);
                        }
                        layer.msg(result.msg,)
                    });
                });
            })
        </script>
    @endcan
@endsection