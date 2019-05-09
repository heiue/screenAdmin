@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header  layuiadmin-card-header-auto">
            <h2>添加分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.product.cates_save')}}" method="post">
                @include('admin.product.cates._form')
            </form>
        </div>
    </div>
@endsection

