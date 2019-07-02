<style>
    .layui-upload-box li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    .layui-upload-box li img{
        width: 100%;
    }
    .layui-upload-box li p{
        width: 100%;
        height: 22px;
        font-size: 12px;
        position: absolute;
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    .layui-upload-box li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }
</style>
<script>
    layui.use(['upload'],function () {
        var upload = layui.upload

        //普通图片上传
        var uploadCover = upload.render({
            elem: '#uploadCoverPic'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                obj.preview(function(index, file, result){
                    $('#layui-upload-box-cover').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#thumb-cover").val(res.url);
                    $('#layui-upload-box-cover li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });

        //多图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            ,url: '{{ route("uploadImg") }}'
            ,exts:'JPG|JPEG|PNG|GIF'
            ,multiple: false
            ,auto:false
            ,bindAction:'#begin_up'
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                if ($('#layui-upload-box li').length >= 3) {
                    console.log('上传最多3张')
                    layer.msg('上传最多3张')
                    return false
                }
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>上传成功</p></li>')
                 });
                /*obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });*/

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#thumb").append('<span><input type="hidden" name="img[]" value="'+res.url+'"><input type="hidden" name="size[]" value="'+res.size+'"><input type="hidden" name="ext[]" value="'+res.ext+'"></span>');
                    // $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        
        //删除项目图集图片
        $('.delete_project_img').on('click', function () {
            var annexId = $(this).attr('imgId')
            var This = $(this)
            $.post("{{ route('admin.annex') }}",{'ids':annexId},function (result) {
                if (result.code==0){
                    layer.msg('已删除');
                    This.parents('li').remove();
                }
                layer.msg(result.msg,)
            });
        });


        //多文件列表示例
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: '{{ route("uploadFile") }}'
            ,accept: 'file'
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,choose: function(obj){
                if (demoListView.children('tr').length >= 3) {
                    layer.msg('文件最多选择三个');return false;
                }
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                    //单个重传
                    tr.find('.demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span><input type=hidden name="files[]" value="'+res.url+'" /><input type="hidden" name="fsize[]" value="'+res.size+'"><input type="hidden" name="fext[]" value="'+res.ext+'">');
                    tds.eq(3).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(res, index, upload);
            }
            ,error: function(res, index, upload){
                layer.msg(res.msg)
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                // tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });

        //删除项目文件
        $('.script-file-delete').on('click', function () {
            var annexId = $(this).attr('fileId')
            var This = $(this)
            $.post("{{ route('admin.annex') }}",{'ids':annexId},function (result) {
                if (result.code==0){
                    layer.msg('已删除');
                    This.parents('tr').remove();
                }
                layer.msg(result.msg,)
            });
        });
    })
</script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
</script>