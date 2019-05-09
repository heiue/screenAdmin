{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">规格名称</label>
    <div class="layui-input-inline">
        <input type="text" name="title" value="{{ $attrname->title ?? old('title') }}" lay-verify="required" placeholder="请输入规格名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.product.attrname')}}" >返 回</a>
    </div>
</div>