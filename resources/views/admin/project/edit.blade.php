@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑项目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.project.update',['id'=>$project->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.project._form')
            </form>
        </div>
    </div>
@endsection