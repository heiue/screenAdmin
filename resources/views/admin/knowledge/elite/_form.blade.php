{{csrf_field()}}
{{--<input type="hidden" name="category_id" value="2">--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-block">
        <select name="category_id" lay-search  lay-filter="category_id">
            <option value="1">精品课程</option>
            <option value="2">精英养成</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$elite->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keywords" value="{{$elite->keywords??old('keywords')}}" lay-verify="required" placeholder="请输入关键词" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <textarea name="description" placeholder="请输入描述" class="layui-textarea">{{$elite->description??old('description')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($elite->thumb))
                        <li><img src="{{ $elite->thumb }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="thumb" id="thumb" value="{{ $elite->thumb??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">视频</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadVideo"><i class="layui-icon">&#xe67c;</i>上传视频</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box-video" class="layui-clear">
                    @if(isset($elite->video))
                        <li>
                            <video width="200" height="150" src="{{ $elite->video }}"></video>
                        </li>
                    @endif
                </ul>
                <input type="hidden" name="video" id="video" value="{{ $elite->video??'' }}">
            </div>
        </div>
    </div>
</div>

@include('UEditor::head')
<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $elite->content??old('content') !!}
        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.elite.index')}}" >返 回</a>
    </div>
</div>