<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends AdminBaseController
{
    //
    public function index()
    {
        $datas = Article::orderBy('id','desc')->paginate(5);
//        dd($datas->links());
        return view('admin.article.list', compact('datas'));
    }

    public function create()
    {
        $datas = (new Category())->getDataAsTree();
        return view('admin.article.add', compact("datas"));
    }

    // post url: /article
    // 保存提交
    public function store()
    {
        $input = Input::except('_token','file');
        $rules = [
            'title'=>'required|between:1,100',
            'content'=>'required'
        ];
        $messages = [
            'title.required'=>'标题不能为空',
            'title.between' =>'标题长度必须在1-100',
            'content.required'=>'内容不能为空',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            $input['create_time'] = time();
            $ret = Article::create($input);
            if ($ret) {
                return redirect('admin/article');
            }else {
                return back()->withErrors($validator);
            }
        }else {
            return back()->withErrors($validator);
        }
    }
    public function show()
    {
        echo 'show';
    }

    // url: /article/{id}/edit
    //编辑文章
    public function edit($id)
    {
        $datas = (new Category())->getDataAsTree();
        $field = Article::find($id);
//        dd($field);
        return view('admin.article.edit',compact('datas','field'));
    }

    //PUT url: article/{id}
    //编辑后提交,$id为修改对象id
    public function update($id)
    {
        $input = Input::except('_method','_token','file');
        $item = Article::find($id);
        //修改时做了改变，才需要删除
        if ($item->thumb != $input['thumb']) {
            $toDelete = $item->thumb;
        }
        $ret = $item->update($input);
        if($ret) {
            if (!empty($toDelete)) {
                $this->deleteUploadFile($toDelete);
            }
            return redirect('admin/article');
        }else {
            return back()->withErrors(['提交失败，请稍后重试！']);
        }
    }

    //DELETE	/article/{id}
    // 删除文章
    public function destroy($id)
    {
        $ret = Article::where('id',$id)->delete();
        if ($ret) {
            $data = [
                'status'=>  0,
                'msg' => '更新成功！'
            ];
        }else {
            $date = [
                'status'=>  1,
                'msg' => '更新失败！'
            ];
        }
        return $data;
    }
}
