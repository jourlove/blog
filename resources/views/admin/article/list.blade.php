@extends('layouts.layout_admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-refresh"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>作者</th>
                        <th class="tc">发布时间</th>
                        <th class="tc">查看数</th>
                        <th class="tc">操作</th>
                    </tr>

                    @foreach($datas as $v)
                    <tr>
                        <td class="tc">{{$v['id']}}</td>
                        <td>
                            <a href="#">{{$v['title']}}</a>
                        </td>
                        <td>{{$v['author']}}</td>
                        <td>{{date('Y-m-d',$v['create_time'])}}</td>
                        <td>{{$v['view_count']}}</td>
                        <td class="tc">
                            <a href="{{url('admin/article/'.$v['id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArticle({{$v['id']}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$datas->links()}}
                </div>
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

    <script>
        function delArticle(id) {
            layui.use('layer',function () {
                var layer = layui.layer;
                layer.confirm('您确定要删除这篇文章吗？',{
                    btn:['确定','取消']
                },
                function () {
                    $.post("{{url('admin/article')}}/"+ id,
                        {'_method':'delete', '_token':'{{csrf_token()}}'},
                        function (data) {
                            if (data.status == 0) {
                                location.href = location.href;
                                layer.msg(data.msg,{icon:6});
                            }else {
                                layer.msg(data.msg,{icon:5});
                            }
                        })
                },
                function () {
                    
                })
            });
        }
    </script>
</body>
@endsection