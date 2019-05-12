{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目名字</label>
    <div class="layui-input-block">
        <input type="text" name="projectTitle" value="{{ $project->projectTitle ?? old('projectTitle') }}" lay-verify="required" placeholder="请输入项目名字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目类型</label>
    <div class="layui-input-block">
        <select name="projectType" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($project->projectType) && $project->projectType == 1) selected @endif>小说</option>
            <option value="2" @if(isset($project->projectType) && $project->projectType == 2) selected @endif>网剧</option>
            <option value="3" @if(isset($project->projectType) && $project->projectType == 3) selected @endif>综艺</option>
            <option value="4" @if(isset($project->projectType) && $project->projectType == 4) selected @endif>电视剧</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目简介</label>
    <div class="layui-input-block">
        <textarea name="introduction" placeholder="请输入简介" class="layui-textarea">{{$project->introduction??old('introduction')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.project.index')}}" >返 回</a>
    </div>
</div>