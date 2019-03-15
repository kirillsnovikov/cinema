<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Type extends Model
{
    protected $guarded = ['genres'];
    
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    
    public function movies()
    {
        return $this->hasMany('App\Movie');
    }
}
