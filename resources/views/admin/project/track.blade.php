@extends('admin.base')

@section('content')
    {{--<div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-collapse" lay-accordion>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">杜甫</h2>
                    <div class="layui-colla-content layui-show">内容区域</div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">李清照</h2>
                    <div class="layui-colla-content">内容区域</div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">鲁迅</h2>
                    <div class="layui-colla-content">内容区域</div>
                </div>
            </div>
        </div>
    </div>--}}
    <fieldset class="layui-elem-field layui-field-title">
        <legend>项目名称</legend>
        <div class="layui-field-box">
            {{ $project->projectTitle }}
        </div>
    </fieldset>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>跟踪记录</legend>
        <button class="layui-btn layui-btn-fluid" id="track_add_one">添加一条跟踪记录</button>
        <div class="layui-field-box">
            <div class="layui-collapse" lay-accordion>
                @foreach($track as $key => $value)
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">{{ $value['created_at'] }}</h2>
                    <div class="layui-colla-content @if($key == 0) layui-show @endif">{{ $value['trackContent'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </fieldset>
@endsection

@section('script')
    <script>
        //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
        layui.use(['element', 'form'], function(){
            var proId = '{{ $project->id }}'
            var element = layui.element;
            var form = layui.form

            $('#track_add_one').on('click',function () {
                layer.open({
                    type: 1,
                    title:'添加跟踪',
                    content: '<div class="layui-card" id="track_add_layer"><form class="layui-form layui-form-pane" action="{{ route('admin.project.track_add') }}" method="get" ><input type="hidden" name="proId" value="'+proId+'"/><div class="layui-form-item layui-form-text">\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <textarea placeholder="请输入内容" class="layui-textarea" name="trackContent" lay-verify="required" ></textarea>\n' +
                    '    </div>\n' +
                    '  </div>' +
                    '<div class="layui-form-item layui-hide">\n' +
                    '      <input type="button" lay-submit="" lay-filter="layuiadmin-app-form-submit" id="layuiadmin-track-form-submit" value="确认添加">\n' +
                    '    </div></form></div>',
                    maxmin: true,
                    area: ['550px', '200px'],
                    btn: ['确定', '取消'],
                    yes: function (index, layero) {
                        var form = layero.find('#track_add_layer form')
                        var trackContent = form.find("textarea").val()
                        if (trackContent == '') {
                            alert('请填写记录')
                            return false
                        }
                        form.submit()
                        layer.close(index)
                    }
                });
            })
        });
    </script>
@endsection