<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends AdminBaseController
{
    public function login()
    {
        $_SESSION['t'] = 'tttt';
        dd($_SESSION['t']);
        
        $input = Input::All();
        if (!empty($input)) {
            if (empty($input['username'])) {
                return back()->with('msg','请输入用户名');
            }
            if (empty($input['password'])) {
                return back()->with('msg','请输入密码');
            }
            if (empty($input['code'])) {
                return back()->with('msg','请输入验证码');
            }
            $realCode = new \Code;
            $codeValue = $realCode->get();
            if (strtoupper($input['code']) != strtoupper($codeValue)) {
                //session(['msg'=>'验证码错误']);
                return back()->with('msg','验证码错误');
            }

            $userinfo = User::where('name',$input['username'])->first();
            if (empty($userinfo)) {
                return back()->with('msg','用户名或密码错误');
            }
            $realpass = Crypt::decrypt($userinfo->__get('password'));
            $inputpass = $input['password'];
            if ($realpass != $inputpass) {
                return back()->with('msg','用户名或密码错误');
            }

            session(['user'=>$userinfo]);
            return redirect()->route('admin');
        }else {
            return view('admin/login');
        }
    }

    /**
     *
     */
    public function code()
    {
        $code = new \Code;
        return $code->make();
    }

    public function crypt()
    {
        $str = '123456';
        echo Crypt::encrypt($str);
    }
}
