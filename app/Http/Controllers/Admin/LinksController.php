<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Links;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends AdminBaseController
{

    public function index()
    {
        $datas = Links::orderBy('order','asc')->get();
        return view('admin.links.list',compact('datas'));
    }
//GET	/links/create	添加
    public function create()
    {
        return view('admin.links.add');
    }

    //POST	/photo	store	photo.store
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required|between:1,20',
            'url'=>'required',
        ];
        $messages = [
            'name.required'=>'名称不能为空',
            'name.between' =>'名称长度必须在1-20',
            'url.required'=>'url不能为空',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            $ret = Links::create($input);
            if ($ret) {
                return redirect('admin/links');
            }else {
                return back()->withErrors($validator);
            }
        }else {
            return back()->withErrors($validator);
        }
    }

    //GET	/links/{id}/edit
    public function edit($id)
    {
        $field = Links::find($id);
        return view('admin.links.edit',compact("field"));
    }
    //PUT/PATCH	/links/{id}	update	photo.update
    public function update($id)
    {
        $input = Input::except('_method','_token');
        $cate = Links::find($id);
        $ret = $cate->update($input);
        if($ret) {
            return redirect('admin/links');
        }else {
            return back()->withErrors(['提交失败，请稍后重试！']);
        }
    }

    public function show()
    {

    }

    public function changeOrder()
    {
        $input = Input::all();
        $item = Links::find($input['id']);
        $item->order = $input['order'];
        $ret = $item->update();
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

    //method DELETE
    //  /links/{id}
    public function destroy($id)
    {
        $ret = Links::where('id',$id)->delete();
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
