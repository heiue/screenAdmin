{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">属性值</label>
    <div class="layui-input-inline">
        <input type="text" name="value" value="{{ $attrvalue->value ?? old('value') }}" lay-verify="required" placeholder="请输入属性值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">规格名称</label>
    <div class="layui-input-inline">
        <select name="name_id" lay-verify="required">
            <option value=""></option>
            @foreach($attrname as $attr)
                <option value="{{ $attr->id }}" @if(isset($attrvalue->name_id) && $attrvalue->name_id == $attr->id)selected @endif >{{ $attr->title }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($attrvalue->img))
                        <li><img src="{{ $attrvalue->img }}" /></li>
                    @endif
                </ul>
                <input type="hidden" name="img" id="thumb" value="{{ $attrvalue->img??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.product.attrvalue')}}" >返 回</a>
    </div>
</div>