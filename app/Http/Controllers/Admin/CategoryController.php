<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends AdminBaseController
{
//GET	/photo	index	photo.index
    public function index()
    {
        $datas = (new Category())->getDataAsTree();
        return view('admin.category.list')->with('datas',$datas);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['id']);
        $cate->order = $input['order'];
        $ret = $cate->update();
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
//GET	/photo/create	create	photo.create
    public function create()
    {
        $datas = Category::where('pid',0)->get();
        return view('admin/category/add_category',compact('datas',$datas));
    }
//POST	/photo	store	photo.store
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required|between:1,20',
        ];
        $messages = [
            'name.required'=>'分类名称不能为空',
            'name.between' =>'分类名称长度必须在1-20',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            $ret = Category::create($input);
            if ($ret) {
                return redirect('admin/category');
            }else {
                return back()->withErrors($validator);
            }
        }else {
            return back()->withErrors($validator);
        }
    }
//GET	/photo/{photo}	show	photo.show
    public function show()
    {
        
    }

//GET	/photo/{photo}/edit	edit	photo.edit
    public function edit($id)
    {
        $field = Category::find($id);
        $datas = Category::where('pid',0)->get();
        return view('admin.category.edit',compact("field","datas"));
    }
    //PUT/PATCH	/photo/{photo}	update	photo.update
    public function update($id)
    {
        $input = Input::except('_method','_token');
        $cate = Category::find($id);
        $ret = $cate->update($input);
        if($ret) {
            return redirect('admin/category');
        }else {
            return back()->withErrors(['提交失败，请稍后重试！']);
        }
    }

//DELETE	/photo/{photo}	destroy	photo.destroy
    public function destroy($id)
    {
        $ret = Category::where('id',$id)->delete();
        Category::where('pid',$id)->update(['pid'=>0]);
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
