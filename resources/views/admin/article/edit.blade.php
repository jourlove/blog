@extends('layouts.layout_admin_edit')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo; 修改文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->

            @if(count($errors) > 0)
                <div class="result_wrap">
                    <div class="result_title">
                        <div class="mark">
                            @foreach($errors->all() as $error)
                                <p style="color:red">{{$error}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url("admin/article/".$field->id)}}" method="post">
            <input type="hidden" name="_method" value="put" />
            {{csrf_field()}}

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="category_id">
                                @foreach($datas as $v)
                                    <option value="{{$v->id}}"
                                        @if($field->category_id == $v->id) selected @endif
                                    >{{$v->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" name="title" class="lg" value="{{$field->title}}">
                        </td>
                    </tr>
                    <tr>
                        <th>作者：</th>
                        <td>
                            <input type="text" name="author" value="{{$field->author}}">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" class="lg" name="thumb" value="{{$field->thumb}}">
                            <button type="button" class="layui-btn" id="btn_upload">上传图片</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="thumb_img" style="max-width:350px;max-height:100px" src="\{{$field->thumb}}">
                                <p id="thumb_tips"></p>
                            </div>
                            <script>
                                layui.use('upload', function(){
                                    var upload = layui.upload;
                                    //执行实例
                                    var uploadInst = upload.render({
                                        elem: '#btn_upload' //绑定元素
                                        ,url: '{{url('admin/upload')}}' //上传接口
                                        ,accept:'images'
                                        ,auto:true
                                        ,data:{'_token':'{{csrf_token()}}'}
                                        ,before: function(obj){
                                            //预读本地文件示例，不支持ie8
                                            obj.preview(function(index, file, result){
                                                $('#thumb_img').attr('src', result); //图片链接（base64）
                                            });
                                        }
                                        ,done: function(res){
                                            //上传完毕回调
                                            //假设code=0代表上传成功
                                            if(res.code == 0){
                                                //do something （比如将res返回的图片链接保存到表单的隐藏域）
                                                $('input[name=thumb]').val(res.data);
                                            }else {
                                                //文件保存失败
                                                var tipsText = $('#thumb_tips');
                                                tipsText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini thumb-reload">重试</a>');
                                                tipsText.find('.thumb-reload').on('click', function(){
                                                    uploadInst.upload();
                                                });
                                            }
                                        }
                                        ,error: function(){
                                            //请求异常回调
                                            //当上传失败时，你可以生成一个“重新上传”的按钮，点击该按钮时，执行 upload() 方法即可实现重新上传
                                            var tipsText = $('#thumb_tips');
                                            tipsText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini thumb-reload">重试</a>');
                                            tipsText.find('.thumb-reload').on('click', function(){
                                                uploadInst.upload();
                                            });
                                        }
                                    });
                                });
                            </script>

                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" name="keywords" value="{{$field->keywords}}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="description" value="{{$field->description}}"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <th>内容：</th>
                        <td>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain">
                                {!! $field->content !!}
                            </script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container',{
                                    'initialFrameWidth':800
                                });
                            </script>
                            {{--样式冲突矫正--}}
                            <style>
                                .edui-default{line-height:28px;}
                                div.edui-coombox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow:hidden;height:20px;}
                                div.edui-box{overflow:hidden;height:22px;}
                            </style>
                        </td>
                    </tr>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    @endsection