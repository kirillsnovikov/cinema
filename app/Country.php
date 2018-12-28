<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{

    //Allowed values
    protected $fillable = [
        'title',
        'slug',
        'published',
        'created_by',
        'modified_by'
    ];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = mb_strtolower(Str::slug($this->title, '_'));
    }

//    public function setTitleAttribute()
//    {
//
//    }
    //Polymorph
    public function movies()
    {
        return $this->BelongsToMany('App\Movie');
    }
    
    public function persons()
    {
        return $this->BelongsToMany('App\Person');
    }

}
