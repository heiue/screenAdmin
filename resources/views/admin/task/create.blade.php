@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加招聘职位</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.recruitment.save')}}" method="post">
                @include('admin.task._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.task._js')
@endsection
