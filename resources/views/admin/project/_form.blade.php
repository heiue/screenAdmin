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
    <label for="" class="layui-form-label">项目简介</label>
    <div class="layui-input-block">
        <textarea name="remark" placeholder="请输入备注" class="layui-textarea">{{$project->remark??old('remark')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目图集</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <button type="button" class="layui-btn" id="begin_up">开始上传</button>
            <span></span>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($project->img))
                        @foreach($project->img as $value)
                        <li><img src="{{ $value->path }}" /><p><button class="layui-btn layui-btn-xs layui-btn-fluid delete_project_img" type="button" imgId="{{$value->id}}"><i class="layui-icon"></i></button></p></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="upload_url_list" id="thumb">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">设置</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="isPublic" lay-skin="switch" value="1" lay-text="公开|不公开" @if(!isset($project) || $project->isPublic != 0) checked @endif>
    </div>
    <div class="layui-form-mid layui-word-aux">不公开其他用户将看不到该项目的信息</div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.project.index')}}" >返 回</a>
    </div>
</div>