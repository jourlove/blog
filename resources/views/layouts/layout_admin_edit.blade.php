<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('resources/views/admin/style/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('resources/views/admin/style/font/css/font-awesome.min.css')}}">

	<script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>
	<script type="text/javascript" src="{{asset('resources/views/admin/style/js/ch-ui.admin.js')}}"></script>

	<link rel="stylesheet" href="{{asset('resources/org/layui/css/layui.css')}}">
	<script src="{{asset('resources/org/layui/layui.js')}}"></script>

	<!-- 配置文件 -->
	<script type="text/javascript" src="{{asset('resources/org/editor/ueditor.config.js')}}"></script>
	<!-- 编辑器源码文件 -->
	<script type="text/javascript" src="{{asset('resources/org/editor/ueditor.all.js')}}"></script>

	<style>
		a {
			color: #436EEE;
		}
	</style>
</head>
@yield('content')
</html>