<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends AdminBaseController
{

    public function index()
    {
        $datas = Navs::orderBy('order','asc')->get();
        return view('admin.navs.list',compact('datas'));
    }
//GET	/navs/create	添加
    public function create()
    {
        return view('admin.navs.add');
    }

    //POST	/photo	store	photo.store
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'name'=>'required | between:1,20',
            'url'=>'required',
        ];
        $messages = [
            'name.required'=>'名称不能为空',
            'name.between'=>'名称长度必须在1-20',
            'url.required'=>'url不能为空',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            $ret = Navs::create($input);
            if ($ret) {
                return redirect('admin/navs');
            }else {
                return back()->withErrors($validator);
            }
        }else {
            return back()->withErrors($validator);
        }
    }

    //GET	/navs/{id}/edit
    public function edit($id)
    {
        $field = Navs::find($id);
        return view('admin.navs.edit',compact("field"));
    }
    //PUT/PATCH	/navs/{id}	update	photo.update
    public function update($id)
    {
        $input = Input::except('_method','_token');
        $cate = Navs::find($id);
        $ret = $cate->update($input);
        if($ret) {
            return redirect('admin/navs');
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
        $item = Navs::find($input['id']);
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
    //  /navs/{id}
    public function destroy($id)
    {
        $ret = Navs::where('id',$id)->delete();
        if ($ret) {
            $data = [
                'status'=>  0,
                'msg' => '删除成功！'
            ];
        }else {
            $date = [
                'status'=>  1,
                'msg' => '删除失败！'
            ];
        }
        return $data;
    }
}
