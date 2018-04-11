<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = 'article';
    //
    public $timestamps = false;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Http\Model\Category','category_id','id');
//        $art = Article::find($id);
//        $field = $art->category;
//        dd($field);
    }
}
