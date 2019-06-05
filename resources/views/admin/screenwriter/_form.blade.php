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
            <option value="1" @if(isset($screenwriter->rating) && $screenwriter->rating == 1) selected @endif>金牌编剧</option>
            <option value="2" @if(isset($screenwriter->rating) && $screenwriter->rating == 2) selected @endif>著名编剧</option>
            <option value="3" @if(isset($screenwriter->rating) && $screenwriter->rating == 3) selected @endif>知名编剧</option>
            <option value="4" @if(isset($screenwriter->rating) && $screenwriter->rating == 4) selected @endif>新锐编剧</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">代表作品</label>
    <div class="layui-input-block">
        <input type="text" name="residence" value="{{ $screenwriter->residence ?? '' }}" lay-verify="required" placeholder="请输入代表作品" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">头像</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($screenwriter->avatar))
                        <li><img src="{{ $screenwriter->avatar }}" /></li>
                    @endif
                </ul>
                <input type="hidden" name="avatar" id="thumb" value="{{ $screenwriter->avatar??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">编剧文件</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-normal" id="testList">选择多文件</button>
            <div class="layui-upload-list">
                <table class="layui-table">
                    <thead>
                    <tr><th>文件名</th>
                        <th>大小</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr></thead>
                    <tbody id="demoList">
                    @if(isset($screenwriter->file))
                        @foreach($screenwriter->file as $key => $value)
                            <tr id="upload-1559319948825-{{$key}}"><td>{{ $value->path }}</td><td>{{ intval($value->size)/1000 }}</td><td>已经上传</td><td>{{--<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>--}}</td></tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <button type="button" class="layui-btn" id="testListAction">开始上传</button>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">设置</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="isPublic" lay-skin="switch" value="1" lay-text="公开|不公开" @if(!isset($screenwriter) || $screenwriter->isPublic != 0) checked @endif>
    </div>
    <div class="layui-form-mid layui-word-aux">不公开其他用户将看不到该编剧的信息</div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.screen.writer')}}" >返 回</a>
    </div>
</div>