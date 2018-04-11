@extends('layouts.layout_admin')
@section('content')
        <!--面包屑配置项 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
</div>
<!--面包屑配置项 结束-->

<!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项列表</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <!--快捷配置项 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/web_config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/web_config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
        <!--快捷配置项 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <form action="{{url('admin/web_config/change_content')}}" method="post">
                {{csrf_field()}}
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th>标题</th>
                    <th>变量名称</th>
                    <th>内容</th>
                    <th>操作</th>
                </tr>

                @foreach($data as $v)
                <tr>
                    <td class="tc">
                        <input type="text" onchange="changeOrder(this,{{$v->id}})" value="{{$v->order}}">
                    </td>
                    <td class="tc">{{$v->id}}</td>
                    <td>
                        <a href="#">{{$v->title}}</a>
                    </td>
                    <td>{{$v->var_name}}</td>
                    <td>
                        <input type="hidden" name="id[]" value="{{$v->id}}">
                        {!! $v->_html !!}
                    </td>
                    <td>
                        <a href="{{url('admin/web_config/'.$v->id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delItem({{$v->id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="btn_group">
                <p>tips：在内容项修改后需进行提交</p>
                <input type="submit" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回" >
            </div>
            </form>
        </div>
    </div>
<!--搜索结果页面 列表 结束-->
        <script>
            //ajx方式修改排序
            function changeOrder(obj,id) {
                var neworder = $(obj).val();
                $.post("{{url('admin/web_config/changeorder')}}",                     //注意用双引号
                    {'_token':'{{csrf_token()}}', 'id':id,'order':neworder},
                    function(datas) {
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            if (datas.status == 0) {
                                layer.msg(datas.msg, {icon: 6});
                            }else {
                                layer.msg(datas.msg, {icon: 5});
                            }
                        });
                    });

            }

            function delItem(id) {
                layui.use('layer',function () {
                    var layer  = layui.layer;
                    layer.confirm('您确定要删除这个配置项吗?',{
                        btn:['确定','取消']
                    },function () {
                        $.post("{{url('admin/web_config/')}}/"+id,{'_method':'delete',
                                '_token':'{{csrf_token()}}'},
                            function (data) {
                                if (data.status == 0) {
                                    location.href = location.href;//刷新界面
                                    layer.msg(data.msg,{icon:6});
                                }else {
                                    layer.msg(data.msg,{icon:5});
                                }
                            })
                    },function () {

                    })
                })
            }
        </script>

@endsection
