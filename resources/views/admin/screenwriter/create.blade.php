@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加编剧</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.screen.writer.save')}}" method="post">
                @include('admin.screenwriter._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.screenwriter._js')
@endsection