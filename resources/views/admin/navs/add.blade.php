@extends('layouts.layout_admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>&raquo; 添加自定义导航
    </div>
    <!--面包屑导航 结束-->
    <div class="result_wrap">

            @if(count($errors) > 0)
            <div class="result_title">
                <div class="mark">
                    @foreach($errors->all() as $error)
                        <p style="color:red">{{$error}}</p>
                    @endforeach
                </div>
            </div>
            @endif

    </div>
    <div class="result_wrap">
        <form action="{{url("admin/navs")}}" method="post">
            {{csrf_field()}}

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>自定义导航名称\别名：</th>
                        <td>
                            <input type="text" name="name">
                            <input type="text" name="alias" class="sm" value="">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>url：</th>
                        <td>
                            <input type="text" class="lg" name="url">
                        </td>
                    </tr>

                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="order" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
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