@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加剧本</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.script.save')}}" method="post">
                @include('admin.script._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.script._js')
@endsection