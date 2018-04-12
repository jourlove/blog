@extends('layouts.home')
@section('info')
    <title>{{$field->title}} - {{$web_config['web_title']}}</title>
    <meta name="keywords" content="{{$field->keywords}}" />
    <meta name="description" content="{{$field->description}}" />
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="{{url('category/'.$field->category_id)}}">{{$field->category_name}}</a></span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('category/'.$field->category_id)}}" class="n2">{{$field->category_name}}</a></h1>
        <div class="index_about">
            <h2 class="c_titile">{{$field->title}}</h2>
            <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$field->create_time)}}</span><span>编辑：{{$field->author}}</span><span>查看次数：{{$field->view_count}}</span></p>
            <ul class="infos">
                {!! $field->content !!}
            </ul>
            <div class="keybq">
                <p><span>关键字词</span>：{{$field->keywords}}</p>
            </div>
            <div class="ad"> </div>
            <div class="nextinfo">
                <p>上一篇：
                    @if($pre_next['pre'])
                        <a href="{{url('a/'.$pre_next['pre']->id)}}">{{$pre_next['pre']->title}}</a>
                    @else
                        <span>没有上一篇了</span>
                    @endif
                </p>
                <p>下一篇：
                    @if($pre_next['next'])
                        <a href="{{url('a/'.$pre_next['next']->id)}}">{{$pre_next['next']->title}}</a>
                    @else
                        <span>没有下一篇了</span>
                    @endif
                </p>
            </div>
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($otherArticles as $d)
                    <li><a href="{{url('a/'.$d->id)}}" title="{{$d->title}}">{{$d->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <aside class="right">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="blank"></div>
            <div class="news">
                @parent
            </div>
        </aside>
    </article>
@endsection