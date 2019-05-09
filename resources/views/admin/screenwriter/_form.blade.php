{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">编剧名字</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $screenwriter->name ?? old('name') }}" lay-verify="required" placeholder="请输入编剧名字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">编剧评级</label>
    <div class="layui-input-block">
        {{--<input type="text" name="rating" value="{{ $screenwriter->rating ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >--}}
        <select name="rating" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1">金牌编剧</option>
            <option value="2">著名编剧</option>
            <option value="3">知名编剧</option>
            <option value="4">新锐编剧</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">常住地</label>
    <div class="layui-input-block">
        <input type="text" name="residence" value="{{ $screenwriter->residence ?? '' }}" lay-verify="required" placeholder="请输入常住地" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.screen.writer')}}" >返 回</a>
    </div>
</div>