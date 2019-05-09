{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本名字</label>
    <div class="layui-input-block">
        <input type="text" name="scriptTitle" value="{{ $screenwriter->scriptTitle ?? old('title') }}" lay-verify="required" placeholder="请输入剧本名字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本类型</label>
    <div class="layui-input-block">
        {{--<input type="text" name="rating" value="{{ $screenwriter->rating ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >--}}
        <select name="scriptType" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1">小说</option>
            <option value="2">网剧</option>
            <option value="3">综艺</option>
            <option value="4">电视剧</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本题材</label>
    <div class="layui-input-block">
        <select name="scriptTheme" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1">都市</option>
            <option value="2">剧情</option>
            <option value="3">民国</option>
            <option value="4">犯罪</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keyword" value="{{ $screenwriter->keyword ?? old('title') }}" lay-verify="required" placeholder="关键词" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.screen.writer')}}" >返 回</a>
    </div>
</div>