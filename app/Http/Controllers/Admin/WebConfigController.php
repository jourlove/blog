<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\WebConfig;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class WebConfigController extends AdminBaseController
{

    public function index()
    {
        $data = WebConfig::orderBy('order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->content_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="content[]" value="'.$v->content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="content[]">'.$v->content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->content_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }

        }
        return view('admin.web_config.list',compact('data'));
    }
//GET	/web_config/create	添加
    public function create()
    {
        return view('admin.web_config.add');
    }

    private function isContentValueValid($value) {
        $arr1 = explode(',',$value);
        if (count($arr1) < 2) {
            return false;
        }
        foreach ($arr1 as $item) {
            $arr2 = explode('|',$item);
            if (count($arr2) != 2) {
                return false;
            }
        }
        return true;
    }
    //POST	/photo	store	photo.store
    public function store()
    {
        $input = Input::except('_token');
        //验证规则是否合法,TODO 需要设置默认值
        if ($input['content_type']=='radio' && !$this->isContentValueValid($input['content_value'])) {
            return back()->with('errors','内容类型输入不正确');
        }

        $rules = [
            'var_name'=>'required | between:1,50',
            'title'=>'required | between:1,15',
        ];
        $messages = [
            'var_name.required'=>'名称不能为空',
            'var_name.between'=>'名称长度必须在50字符以内',
            'title.required'=>'标题不能为空',
            'title.between'=>'标题长度必须在15字以内',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            $ret = WebConfig::create($input);
            if ($ret) {
                return redirect('admin/web_config');
            }else {
                return back()->withErrors($validator);
            }
        }else {
            return back()->withErrors($validator);
        }
    }

    //GET	/web_config/{id}/edit
    public function edit($id)
    {
        $field = WebConfig::find($id);
        return view('admin.web_config.edit',compact("field"));
    }
    //PUT/PATCH	/web_config/{id}	update	photo.update
    public function update($id)
    {
        $input = Input::except('_method','_token');
        //验证规则是否合法
        if ($input['content_type']=='radio' && !$this->isContentValueValid($input['content_value'])) {
            return back()->with('errors','内容类型输入不正确');
        }
        $ret = WebConfig::find($id)->update($input);
        if($ret) {
            $this->putFile();
            return redirect('admin/web_config');
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
        $item = WebConfig::find($input['id']);
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
    //  /web_config/{id}
    public function destroy($id)
    {
        $ret = WebConfig::where('id',$id)->delete();
        if ($ret) {
            $this->putFile();
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


    public function changeContent()
    {
        $input = Input::except('_token');
        foreach($input['id'] as $k=>$v){
            WebConfig::where('id',$v)->update(['content'=>$input['content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功！');
    }

    public function putFile()
    {
//        $config = WebConfig::pluck('content','var_name')->all();
//        $path = base_path().'\config\web_config.php';
//        $str = '<?php return '.var_export($config,true).';';
//        file_put_contents($path,$str);
    }
}
