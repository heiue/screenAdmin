@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('script.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                @endcan
                @can('script.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.project.create') }}">添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('script.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="track">跟踪</a>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('script.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/html" id="switchTpl">
        <input type="checkbox" name="isPublic" value="@{{d.isPublic}}" lay-skin="switch" lay-text="公开|不公开" lay-filter="isPublicDemo" @{{ d.isPublic == 1 ? 'checked' : '' }}>
    </script>
    @can('script.index')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.project.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'projectTitle', title: '项目名字'}
                        ,{field: 'project_type_name', title: '项目类型'}
                        ,{field: 'introduction', title: '项目简介'}
                        // ,{field:'isPublic', title:'设置', width:100, templet: '#switchTpl', unresize: true}
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
                            $.post("{{ route('admin.project.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/project/'+data.id+'/edit';
                    } else if (layEvent === 'track') {
                        //跟踪
                        var index = layer.open({
                            title:'项目跟踪',
                            type: 2,
                            content: '/admin/project/'+data.id+'/track',
                            area: ['300px', '300px'],
                            maxmin: true,
                            /*cancel: function(index){
                                if(confirm('确定要关闭么')){
                                    layer.close(index)
                                }
                                return false;
                            }*/
                        });
                        layer.full(index);
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
                            $.post("{{ route('admin.project.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                    layer.tips(obj.elem.checked, obj.othis);
                });

            })
        </script>
    @endcan
@endsection