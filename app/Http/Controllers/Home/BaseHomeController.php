<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BaseHomeController extends Controller
{
    //
    public function __construct()
    {
        //点击量最高的5篇文章
        $hot = Article::select('id','title')->orderBy('view_count','desc')->take(5)->get();

        //最新发布文章8篇
        $new = Article::select('id','title')->orderBy('create_time','desc')->take(8)->get();

        $navs = Navs::all();

        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
