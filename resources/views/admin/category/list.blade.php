@extends('layouts.layout_admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="4%"><input type="checkbox" name=""></th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th class="tc">查看数</th>
                        <th class="tc">操作</th>
                    </tr>

                    @foreach($datas as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                        <td class="tc">
                            <input type="text" name="cate_order" onchange="changeOrder(this,{{$v['id']}})" value={{$v['order']}} >
                        </td>
                        <td class="tc">{{$v['id']}}</td>
                        <td>
                            <a href="#">{{$v['name']}}</a>
                        </td>
                        <td>{{$v['title']}}</td>
                        <td class="tc">{{$v['view_count']}}</td>
                        <td class="tc">
                            <a href="{{url('admin/category/'.$v['id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate({{$v['id']}})">删除</a>
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
        a {
            color: #436EEE;
        }
    </style>

</body>

    <script>
        //ajx方式修改排序
        function changeOrder(obj,cate_id) {
            var cate_order = $(obj).val();
            $.post("{{url('admin/category/changeorder')}}",                     //注意用双引号
                {'_token':'{{csrf_token()}}', 'id':cate_id,'order':cate_order},
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

        function delCate(cate_id) {
            layui.use('layer',function () {
                var layer  = layui.layer;
                layer.confirm('您确定要删除这个分类吗?',{
                    btn:['确定','取消']
                },function () {
                    $.post("{{url('admin/category/')}}/"+cate_id,{'_method':'delete',
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