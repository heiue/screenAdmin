{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">职位名称</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$recruitment->position??old('position')}}" lay-verify="required" placeholder="请输入职位" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公司地址</label>
    <div class="layui-input-block">
        <input type="text" name="address" value="{{$recruitment->address??old('address')}}" lay-verify="required" placeholder="请输入公司地址" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">学历</label>
    <div class="layui-input-block">
        <input type="text" name="education" value="{{$recruitment->education??old('education')}}" lay-verify="required" placeholder="请输入学历" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">经验</label>
    <div class="layui-input-block">
        <input type="text" name="experience" value="{{$recruitment->experience??old('experience')}}" lay-verify="required" placeholder="请输入经验" class="layui-input" >
    </div>
</div>

@include('UEditor::head')
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司介绍</label>
    <div class="layui-input-block">
        <script id="container" name="introduction" type="text/plain">
            {!! $recruitment->introduction??old('introduction') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">职位要求</label>
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