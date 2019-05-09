@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑剧本</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.script.update',['id'=>$script->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.script._form')
            </form>
        </div>
    </div>
@endsection