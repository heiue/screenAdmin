@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新文章</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.elite.update',['id'=>$elite->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.knowledge.elite._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.knowledge.elite._js')
@endsection
