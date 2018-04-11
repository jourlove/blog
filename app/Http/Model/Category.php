<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    //
    public $timestamps = false;

    protected $guarded = [];

    public function getDataAsTree()
    {
        $datas = Category::orderBy('order')->get();

        $ret = array();
        foreach($datas as $i=>$v) {
            $ret[] = $v;
        }
//        dd($ret);
        return $ret;
    }
}
