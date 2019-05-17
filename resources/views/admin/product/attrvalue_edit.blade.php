@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>更新属性值</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.product.attrvalue_update',['attrvalue'=>$attrvalue])}}" method="post">
            <input type="hidden" name="id" value="{{$attrvalue->id}}">
            {{method_field('put')}}
            @include('admin.product.attrvalue_form')
        </form>
    </div>
</div>
@endsection

@section('script')
    @include('admin.product.attrvalue_js')
@endsection
