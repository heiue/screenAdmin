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
            <option value="1" @if(isset($script->scriptType) && $script->scriptType == 1) selected @endif>院线电影</option>
            <option value="2" @if(isset($script->scriptType) && $script->scriptType == 2) selected @endif>电视剧</option>
            <option value="3" @if(isset($script->scriptType) && $script->scriptType == 3) selected @endif>网络大电影</option>
            <option value="4" @if(isset($script->scriptType) && $script->scriptType == 4) selected @endif>网络剧</option>
            <option value="5" @if(isset($script->scriptType) && $script->scriptType == 5) selected @endif>央6</option>
            <option value="6" @if(isset($script->scriptType) && $script->scriptType == 6) selected @endif>舞台剧</option>
            <option value="7" @if(isset($script->scriptType) && $script->scriptType == 7) selected @endif>短视频</option>
            <option value="8" @if(isset($script->scriptType) && $script->scriptType == 8) selected @endif>小说</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本题材</label>
    <div class="layui-input-block">
        <select name="scriptTheme" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($script->scriptTheme) && $script->scriptTheme == 1) selected @endif>犯罪</option>
            <option value="2" @if(isset($script->scriptTheme) && $script->scriptTheme == 2) selected @endif>悲剧</option>
            <option value="3" @if(isset($script->scriptTheme) && $script->scriptTheme == 3) selected @endif>喜剧 </option>
            <option value="4" @if(isset($script->scriptTheme) && $script->scriptTheme == 4) selected @endif>爱情 </option>
            <option value="5" @if(isset($script->scriptTheme) && $script->scriptTheme == 5) selected @endif>动作  </option>
            <option value="6" @if(isset($script->scriptTheme) && $script->scriptTheme == 6) selected @endif>枪战  </option>
            <option value="7" @if(isset($script->scriptTheme) && $script->scriptTheme == 7) selected @endif>惊悚 </option>
            <option value="8" @if(isset($script->scriptTheme) && $script->scriptTheme == 8) selected @endif>恐怖  </option>
            <option value="9" @if(isset($script->scriptTheme) && $script->scriptTheme == 9) selected @endif>悬疑 </option>
            <option value="10" @if(isset($script->scriptTheme) && $script->scriptTheme == 10) selected @endif>动画 </option>
            <option value="11" @if(isset($script->scriptTheme) && $script->scriptTheme == 11) selected @endif>奇幻  </option>
            <option value="12" @if(isset($script->scriptTheme) && $script->scriptTheme == 12) selected @endif>魔幻 </option>
            <option value="13" @if(isset($script->scriptTheme) && $script->scriptTheme == 13) selected @endif>科幻 </option>
            <option value="14" @if(isset($script->scriptTheme) && $script->scriptTheme == 14) sselected @endif>战争 </option>
            <option value="15" @if(isset($script->scriptTheme) && $script->scriptTheme == 15) selected @endif>剧情片</option>
            <option value="16" @if(isset($script->scriptTheme) && $script->scriptTheme == 16) selected @endif>伦理片</option>
            <option value="17" @if(isset($script->scriptTheme) && $script->scriptTheme == 17) selected @endif>传记片</option>
            <option value="18" @if(isset($script->scriptTheme) && $script->scriptTheme == 18) selected @endif>青春</option>
            <option value="19" @if(isset($script->scriptTheme) && $script->scriptTheme == 19) selected @endif>歌舞</option>
            <option value="20" @if(isset($script->scriptTheme) && $script->scriptTheme == 20) selected @endif>热血</option>
            <option value="21" @if(isset($script->scriptTheme) && $script->scriptTheme == 21) selected @endif>冒险</option>
            <option value="22" @if(isset($script->scriptTheme) && $script->scriptTheme == 22) selected @endif>校园</option>
            <option value="23" @if(isset($script->scriptTheme) && $script->scriptTheme == 23) selected @endif>运动</option>
            <option value="24" @if(isset($script->scriptTheme) && $script->scriptTheme == 24) selected @endif>历史</option>
            <option value="25" @if(isset($script->scriptTheme) && $script->scriptTheme == 25) selected @endif>励志</option>
            <option value="26" @if(isset($script->scriptTheme) && $script->scriptTheme == 26) selected @endif>古装</option>
            <option value="27" @if(isset($script->scriptTheme) && $script->scriptTheme == 27) selected @endif>言情</option>
            <option value="28" @if(isset($script->scriptTheme) && $script->scriptTheme == 28) selected @endif>军事</option>
            <option value="29" @if(isset($script->scriptTheme) && $script->scriptTheme == 29) selected @endif>警匪</option>
            <option value="30" @if(isset($script->scriptTheme) && $script->scriptTheme == 30) selected @endif>武侠</option>
            <option value="31" @if(isset($script->scriptTheme) && $script->scriptTheme == 31) selected @endif>农村</option>
            <option value="32" @if(isset($script->scriptTheme) && $script->scriptTheme == 32) selected @endif>都市</option>
            <option value="33" @if(isset($script->scriptTheme) && $script->scriptTheme == 33) selected @endif>神话</option>
            <option value="34" @if(isset($script->scriptTheme) && $script->scriptTheme == 34) selected @endif>玄幻</option>
            <option value="35" @if(isset($script->scriptTheme) && $script->scriptTheme == 35) selected @endif>谍战</option>
            <option value="36" @if(isset($script->scriptTheme) && $script->scriptTheme == 36) selected @endif>年代</option>
            <option value="37" @if(isset($script->scriptTheme) && $script->scriptTheme == 37) selected @endif>儿童</option>
            <option value="38" @if(isset($script->scriptTheme) && $script->scriptTheme == 38) selected @endif>音乐</option>
            <option value="39" @if(isset($script->scriptTheme) && $script->scriptTheme == 39) selected @endif>西部</option>
            <option value="40" @if(isset($script->scriptTheme) && $script->scriptTheme == 40) selected @endif>治愈</option>
            <option value="41" @if(isset($script->scriptTheme) && $script->scriptTheme == 41) selected @endif>史诗</option>
            <option value="42" @if(isset($script->scriptTheme) && $script->scriptTheme == 42) selected @endif>主旋律</option>
            <option value="43" @if(isset($script->scriptTheme) && $script->scriptTheme == 43) selected @endif>军旅</option>
            <option value="44" @if(isset($script->scriptTheme) && $script->scriptTheme == 44) selected @endif>抗战</option>
            <option value="45" @if(isset($script->scriptTheme) && $script->scriptTheme == 45) selected @endif>江湖</option>
            <option value="46" @if(isset($script->scriptTheme) && $script->scriptTheme == 46) selected @endif>现代</option>
            <option value="47" @if(isset($script->scriptTheme) && $script->scriptTheme == 47) selected @endif>公路</option>
            <option value="48" @if(isset($script->scriptTheme) && $script->scriptTheme == 48) selected @endif>商战</option>
            <option value="49" @if(isset($script->scriptTheme) && $script->scriptTheme == 49) selected @endif>民国</option>
            <option value="50" @if(isset($script->scriptTheme) && $script->scriptTheme == 50) selected @endif>仙侠</option>
            <option value="51" @if(isset($script->scriptTheme) && $script->scriptTheme == 51) selected @endif>宫廷</option>
            <option value="52" @if(isset($script->scriptTheme) && $script->scriptTheme == 52) selected @endif>穿越</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keyword" value="{{ $script->keyword ?? old('keyword') }}" lay-verify="required" placeholder="关键词" class="layui-input" >
    </div>
</div>
@include('UEditor::head')
<div class="layui-form-item">
    <label for="" class="layui-form-label">剧本描述</label>
    <div class="layui-input-block">
        <script id="container" name="introduction" type="text/plain">
            {!! $script->introduction??old('introduction') !!}
        </script>
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