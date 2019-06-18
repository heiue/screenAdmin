{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">需求名称</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$recruitment->position??old('position')}}" lay-verify="required" placeholder="请输入需求名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公司名称</label>
    <div class="layui-input-block">
        <input type="text" name="company" value="{{$recruitment->company??old('company')}}" lay-verify="required" placeholder="请输入公司地址" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公司地址</label>
    <div class="layui-input-block">
        <input type="text" name="address" value="{{$recruitment->address??old('address')}}" lay-verify="required" placeholder="请输入公司地址" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">职务</label>
    <div class="layui-input-block">
        <input type="text" name="education" value="{{$recruitment->education??old('education')}}" lay-verify="required" placeholder="请输入职务" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">关键字</label>
    <div class="layui-input-block">
        <input type="text" name="experience" value="{{$recruitment->experience??old('experience')}}" lay-verify="required" placeholder="请输入关键字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">金额</label>
    <div class="layui-input-block">
        <input type="text" name="price" value="{{$recruitment->price??old('price')}}" lay-verify="required" placeholder="请输入金额" class="layui-input" >
    </div>
</div>

@include('UEditor::head')
<div class="layui-form-item">
    <label for="" class="layui-form-label">需求方介绍</label>
    <div class="layui-input-block">
        <script id="container" name="introduction" type="text/plain">
            {!! $recruitment->introduction??old('introduction') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">任务详情</label>
    <div class="layui-input-block">
        <script id="container-1" name="positionClaim" type="text/plain">
            {!! $recruitment->positionClaim??old('positionClaim') !!}
        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.recruitment.index')}}" >返 回</a>
    </div>
</div>