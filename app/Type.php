<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Type extends Model
{
    protected $guarded = [];
    
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }
}
