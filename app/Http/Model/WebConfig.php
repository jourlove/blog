<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    protected $table = 'web_config';
    //
    public $timestamps = false;

    protected $guarded = [];
}
