{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">上级分类</label>
    <div class="layui-input-block">
        <select name="pid" lay-search  lay-filter="pid">
            <option value="0">一级分类</option>
            @foreach($cates as $first)
                <option value="{{ $first['id'] }}" @if(isset($cate->pid)&&$cate->pid==$first['id']) selected @endif>{{ $first['title'] }}</option>
                @if(isset($first['_child']))
                    @foreach($first['_child'] as $second)
                        <option value="{{$second['id']}}" {{ isset($cate->id) && $cate->pid==$second['id'] ? 'selected' : '' }} >&nbsp;&nbsp;┗━━{{$second['title']}}</option>
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{ $cate->title ?? old('title') }}" lay-verify="required" placeholder="请输入名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-block">
        <input type="text" name="ord" value="{{ $cate->ord ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.product.cates')}}" >返 回</a>
    </div>
</div>