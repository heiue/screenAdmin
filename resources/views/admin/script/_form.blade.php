{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本名字</label>
    <div class="layui-input-block">
        <input type="text" name="scriptTitle" value="{{ $script->scriptTitle ?? old('title') }}" lay-verify="required" placeholder="请输入剧本名字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本封面</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($script->cover))
                        <li><img src="{{ $script->cover }}" /></li>
                    @endif
                </ul>
                <input type="hidden" name="cover" id="thumb" value="{{ $script->cover??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本类型</label>
    <div class="layui-input-block">
        <select name="scriptType" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($script->scriptType) && $script->scriptType == 1) selected @endif>小说</option>
            <option value="2" @if(isset($script->scriptType) && $script->scriptType == 2) selected @endif>网剧</option>
            <option value="3" @if(isset($script->scriptType) && $script->scriptType == 3) selected @endif>综艺</option>
            <option value="4" @if(isset($script->scriptType) && $script->scriptType == 4) selected @endif>电视剧</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本题材</label>
    <div class="layui-input-block">
        <select name="scriptTheme" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($script->scriptTheme) && $script->scriptTheme == 1) selected @endif>都市</option>
            <option value="2" @if(isset($script->scriptTheme) && $script->scriptTheme == 2) selected @endif>剧情</option>
            <option value="3" @if(isset($script->scriptTheme) && $script->scriptTheme == 3) selected @endif>民国</option>
            <option value="4" @if(isset($script->scriptTheme) && $script->scriptTheme == 4) selected @endif>犯罪</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keyword" value="{{ $script->keyword ?? old('title') }}" lay-verify="required" placeholder="关键词" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本文件</label>
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
                    @if(isset($script->file))
                        @foreach($script->file as $key => $value)
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
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.script.index')}}" >返 回</a>
    </div>
</div>