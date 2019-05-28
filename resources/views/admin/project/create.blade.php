@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加项目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.project.save')}}" method="post">
                @include('admin.project._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.project._js')
@endsection