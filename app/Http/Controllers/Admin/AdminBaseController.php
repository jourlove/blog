<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class AdminBaseController extends Controller
{
    /*  返回json
       {
        "code": 0
        ,"msg": ""
        ,"data": {
        "src": "http://cdn.layui.com/123.jpg"
        }

        TODO
         ?? 如果重复上传，还需要删除临时文件
    */
    public function upload()
    {
        $file = Input::file('file');
        if ($file->isValid()) {
            $realPath = $file->getRealPath();//临时文件的绝对路径
            $extention = $file->getClientOriginalExtension();

            $newName = date('ymdhis').mt_rand(1000,9999).'.'.$extention;
            $path = $file->move(base_path().'/uploads/',$newName);
            $retpath =  'uploads\\'.$newName;
            $arr = array('code'=>0,'msg'=>null,'data'=>$retpath);
            return json_encode($arr);
        }
    }

    public function deleteUploadFile($path)
    {
        $path = base_path().'/'.$path;
        unlink($path);
    }
}
