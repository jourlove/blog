<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BaseHomeController
{
    //
    public function index()
    {
        //点击量最高的6篇文章（站长推荐）
        $pics = Article::select('id','title','thumb')->orderBy('view_count','desc')->take(6)->get();
        //图文列表5篇（带分页）
        $data = Article::select('id','title','description','author','create_time','thumb')->orderBy('create_time','desc')->paginate(5);
        //友情链接
        $links = Links::orderBy('order','asc')->get();
        return view('home.index',compact('pics','data','links'));
    }

    //文章详情
    public function article($id)
    {
        //查看次数自增
        Article::where('id',$id)->increment('view_count');

        //链接分类表，获得cate_id,cate_name  TODO 数据库有待优化
//        $field = Article::Join('category','article.category_id','=','category.id')->where('id',$id)->first();  //字段名称冲突

        $field = Category::select('*','name as category_name')->Join('article','category.id','=','article.category_id')->where('article.id',$id)->first();


        $pre_next['pre'] = Article::select('id','title')->where('id','<',$id)->orderBy('id','desc')->first();;
        $pre_next['next'] = Article::select('id','title')->where('id','>',$id)->orderBy('id','asc')->first();
        $otherArticles = Article::select('id','title')->where('category_id',$field->category_id)->orderBy('id','desc')->take(6)->get();;
        return view('home.article',compact('field','otherArticles','pre_next'));
    }

    //显示分类为category的文字列表
    public function articleList($categoryId)
    {
        //查看次数自增
        Category::where('id',$categoryId)->increment('view_count');

        //图文列表4篇（带分页）
        $data = Article::select('id','title','description','author','create_time','thumb')->where('category_id',$categoryId)->orderBy('create_time','desc')->paginate(4);
        $cur_category = Category::find($categoryId);
        //当前分类的子分类
        $sub_category = Category::where('pid',$categoryId)->get();
        //友情链接
        $links = Links::orderBy('order','asc')->get();

        return view('home.list',compact('data','cur_category','sub_category','links'));
    }
}
