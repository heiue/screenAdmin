@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新规格名称</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.product.attrname_update',['attrname'=>$attrname])}}" method="post">
                <input type="hidden" name="id" value="{{$attrname->id}}">
                {{method_field('put')}}
                @include('admin.product.attrname_form')
            </form>
        </div>
    </div>
@endsection


