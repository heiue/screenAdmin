@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新招聘信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.recruitment.update',['id'=>$recruitment->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.task._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.task._js')
@endsection
