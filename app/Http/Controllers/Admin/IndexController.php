<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Validator;

class IndexController extends AdminBaseController
{
    public function index()
    {
        return view('admin/index');
    }
    public function info()
    {
        return view('admin/info');
    }

    public function logout()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function resetPass()
    {
        if ($input = Input::All()) {
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $messages = [
                'password.required'=>'新密码不能为空',
                'password.between' =>'新密码长度必须在6~20位之间',
                'password.confirmed' => '两次密码输入不一样'
            ];
            $validator = Validator::make($input,$rules,$messages);
            if ($validator->passes()) {
                $curuser = session('user');
                if ($input['password_o'] == Crypt::decrypt($curuser->password)) {
                    $curuser->password = Crypt::encrypt($input['password']);
                    $curuser->save();
                    //return redirect("admin/info");
                    return back()->withErrors(['修改成功！']);
                }else {
                    return back()->withErrors(['原密码错误！']);
                }
            }else {
                return back()->withErrors($validator);
                //dd($validator->errors()->all());
            }
        }else {
            return view('admin/resetpass');
        }
    }
}
