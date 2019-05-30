@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑编剧</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.screen.writer.update',['id'=>$screenwriter->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.screenwriter._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.screenwriter._js')
@endsection