@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.product.cates_update',['id'=>$cate->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.product.cates._form')
            </form>
        </div>
    </div>
@endsection