<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Genre extends Model
{

    //Allowed values
    protected $guarded = ['types'];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug($this->title, '_');
    }

    // Get children genre
    public function types()
    {
        return $this->belongsToMany('App\Type');
    }

    //Polymorph
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }

    public function scopeLastGenres($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

}
