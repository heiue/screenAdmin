{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目名字</label>
    <div class="layui-input-block">
        <input type="text" name="projectTitle" value="{{ $project->projectTitle ?? old('projectTitle') }}" lay-verify="required" placeholder="请输入项目名字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">发布公司的名称</label>
    <div class="layui-input-block">
        <input type="text" name="fCompany" value="{{ $project->fCompany ?? old('fCompany') }}" lay-verify="required" placeholder="请输入发布公司的名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">封面</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadCoverPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box-cover" class="layui-clear layui-upload-box">
                    @if(isset($project->cover))
                        <li><img src="{{ $project->cover }}" /></li>
                    @endif
                </ul>
                <input type="hidden" name="cover" id="thumb-cover" value="{{ $project->cover??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目类型</label>
    <div class="layui-input-block">
        <select name="projectType" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($project->projectType) && $project->projectType == 1) selected @endif>院线电影</option>
            <option value="2" @if(isset($project->projectType) && $project->projectType == 2) selected @endif>电视剧</option>
            <option value="3" @if(isset($project->projectType) && $project->projectType == 3) selected @endif> 网络大电影</option>
            <option value="4" @if(isset($project->projectType) && $project->projectType == 4) selected @endif>网络剧</option>
            <option value="5" @if(isset($project->projectType) && $project->projectType == 4) selected @endif> 央6</option>
            <option value="6" @if(isset($project->projectType) && $project->projectType == 4) selected @endif>舞台剧</option>
            <option value="7" @if(isset($project->projectType) && $project->projectType == 4) selected @endif> 短视频 </option>
            <option value="8" @if(isset($project->projectType) && $project->projectType == 4) selected @endif> 小说 </option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目类型2</label>
    <div class="layui-input-block">
        <select name="projectType2" lay-search  lay-filter="parent_id">
            <option value="0">请选择</option>
            <option value="1" @if(isset($project->projectType2) && $project->projectType2 == 1) selected @endif>犯罪</option>
            <option value="2" @if(isset($project->projectType2) && $project->projectType2 == 2) selected @endif>悲剧</option>
            <option value="3" @if(isset($project->projectType2) && $project->projectType2 == 3) selected @endif>喜剧 </option>
            <option value="4" @if(isset($project->projectType2) && $project->projectType2 == 4) selected @endif>爱情 </option>
            <option value="5" @if(isset($project->projectType2) && $project->projectType2 == 5) selected @endif>动作  </option>
            <option value="6" @if(isset($project->projectType2) && $project->projectType2 == 6) selected @endif>枪战  </option>
            <option value="7" @if(isset($project->projectType2) && $project->projectType2 == 7) selected @endif>惊悚 </option>
            <option value="8" @if(isset($project->projectType2) && $project->projectType2 == 8) selected @endif>恐怖  </option>
            <option value="9" @if(isset($project->projectType2) && $project->projectType2 == 9) selected @endif>悬疑 </option>
            <option value="10" @if(isset($project->projectType2) && $project->projectType2 == 10) selected @endif>动画 </option>
            <option value="11" @if(isset($project->projectType2) && $project->projectType2 == 11) selected @endif>奇幻  </option>
            <option value="12" @if(isset($project->projectType2) && $project->projectType2 == 12) selected @endif>魔幻 </option>
            <option value="13" @if(isset($project->projectType2) && $project->projectType2 == 13) selected @endif>科幻 </option>
            <option value="14" @if(isset($project->projectType2) && $project->projectType2 == 14) sselected @endif>战争 </option>
            <option value="15" @if(isset($project->projectType2) && $project->projectType2 == 15) selected @endif>剧情片</option>
            <option value="16" @if(isset($project->projectType2) && $project->projectType2 == 16) selected @endif>伦理片</option>
            <option value="17" @if(isset($project->projectType2) && $project->projectType2 == 17) selected @endif>传记片</option>
            <option value="18" @if(isset($project->projectType2) && $project->projectType2 == 18) selected @endif>青春</option>
            <option value="19" @if(isset($project->projectType2) && $project->projectType2 == 19) selected @endif>歌舞</option>
            <option value="20" @if(isset($project->projectType2) && $project->projectType2 == 20) selected @endif>热血</option>
            <option value="21" @if(isset($project->projectType2) && $project->projectType2 == 21) selected @endif>冒险</option>
            <option value="22" @if(isset($project->projectType2) && $project->projectType2 == 22) selected @endif>校园</option>
            <option value="23" @if(isset($project->projectType2) && $project->projectType2 == 23) selected @endif>运动</option>
            <option value="24" @if(isset($project->projectType2) && $project->projectType2 == 24) selected @endif>历史</option>
            <option value="25" @if(isset($project->projectType2) && $project->projectType2 == 25) selected @endif>励志</option>
            <option value="26" @if(isset($project->projectType2) && $project->projectType2 == 26) selected @endif>古装</option>
            <option value="27" @if(isset($project->projectType2) && $project->projectType2 == 27) selected @endif>言情</option>
            <option value="28" @if(isset($project->projectType2) && $project->projectType2 == 28) selected @endif>军事</option>
            <option value="29" @if(isset($project->projectType2) && $project->projectType2 == 29) selected @endif>警匪</option>
            <option value="30" @if(isset($project->projectType2) && $project->projectType2 == 30) selected @endif>武侠</option>
            <option value="31" @if(isset($project->projectType2) && $project->projectType2 == 31) selected @endif>农村</option>
            <option value="32" @if(isset($project->projectType2) && $project->projectType2 == 32) selected @endif>都市</option>
            <option value="33" @if(isset($project->projectType2) && $project->projectType2 == 33) selected @endif>神话</option>
            <option value="34" @if(isset($project->projectType2) && $project->projectType2 == 34) selected @endif>玄幻</option>
            <option value="35" @if(isset($project->projectType2) && $project->projectType2 == 35) selected @endif>谍战</option>
            <option value="36" @if(isset($project->projectType2) && $project->projectType2 == 36) selected @endif>年代</option>
            <option value="37" @if(isset($project->projectType2) && $project->projectType2 == 37) selected @endif>儿童</option>
            <option value="38" @if(isset($project->projectType2) && $project->projectType2 == 38) selected @endif>音乐</option>
            <option value="39" @if(isset($project->projectType2) && $project->projectType2 == 39) selected @endif>西部</option>
            <option value="40" @if(isset($project->projectType2) && $project->projectType2 == 40) selected @endif>治愈</option>
            <option value="41" @if(isset($project->projectType2) && $project->projectType2 == 41) selected @endif>史诗</option>
            <option value="42" @if(isset($project->projectType2) && $project->projectType2 == 42) selected @endif>主旋律</option>
            <option value="43" @if(isset($project->projectType2) && $project->projectType2 == 43) selected @endif>军旅</option>
            <option value="44" @if(isset($project->projectType2) && $project->projectType2 == 44) selected @endif>抗战</option>
            <option value="45" @if(isset($project->projectType2) && $project->projectType2 == 45) selected @endif>江湖</option>
            <option value="46" @if(isset($project->projectType2) && $project->projectType2 == 46) selected @endif>现代</option>
            <option value="47" @if(isset($project->projectType2) && $project->projectType2 == 47) selected @endif>公路</option>
            <option value="48" @if(isset($project->projectType2) && $project->projectType2 == 48) selected @endif>商战</option>
            <option value="49" @if(isset($project->projectType2) && $project->projectType2 == 49) selected @endif>民国</option>
            <option value="50" @if(isset($project->projectType2) && $project->projectType2 == 50) selected @endif>仙侠</option>
            <option value="51" @if(isset($project->projectType2) && $project->projectType2 == 51) selected @endif>宫廷</option>
            <option value="52" @if(isset($project->projectType2) && $project->projectType2 == 52) selected @endif>穿越</option>
        </select>
    </div>
</div>
@include('UEditor::head')
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目简介</label>
    <div class="layui-input-block">
        <textarea name="description" placeholder="请输入简介" class="layui-textarea">{{$project->introduction??old('introduction')}}</textarea>
        {{--<script id="container" name="introduction" type="text/plain">
            {!! $project->introduction??old('introduction') !!}
        </script>--}}
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">卖点分析</label>
    <div class="layui-input-block">
        <textarea name="remark" placeholder="请输入分析" class="layui-textarea">{{$project->remark??old('remark')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">融资</label>
    <div class="layui-input-block">
        <input type="number" name="financing" value="{{ $project->financing ?? old('financing') }}" lay-verify="required" placeholder="请输入融资" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">浏览量</label>
    <div class="layui-input-block">
        <input type="number" name="browseCount" value="{{ $project->browseCount ?? old('browseCount') }}" lay-verify="required" placeholder="请输入浏览量" class="layui-input" >
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
                <ul id="layui-upload-box" class="layui-clear layui-upload-box">
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
    <label for="" class="layui-form-label">项目文件</label>
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
            @if(isset($project->file))
                @foreach($project->file as $key => $value)
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