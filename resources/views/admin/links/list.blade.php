@extends('layouts.layout_admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-refresh"></i>全部友情链接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th class="tc">链接</th>
                        <th class="tc">操作</th>
                    </tr>

                    @foreach($datas as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="order" onchange="changeOrder(this,{{$v['id']}})" value={{$v['order']}} >
                        </td>
                        <td class="tc">{{$v['id']}}</td>
                        <td>
                            <a href="#">{{$v['name']}}</a>
                        </td>
                        <td>{{$v['title']}}</td>
                        <td class="tc">{{$v['url']}}</td>
                        <td class="tc">
                            <a href="{{url('admin/links/'.$v['id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delItem({{$v['id']}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>

    <style>
        .result_content ul li span {
            font-size:15px;
            padding:6px 12px;
        }
    </style>

</body>

    <script>
        //ajx方式修改排序
        function changeOrder(obj,id) {
            var neworder = $(obj).val();
            $.post("{{url('admin/links/changeorder')}}",                     //注意用双引号
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
                layer.confirm('您确定要删除这个分类吗?',{
                    btn:['确定','取消']
                },function () {
                    $.post("{{url('admin/links/')}}/"+id,{'_method':'delete',
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