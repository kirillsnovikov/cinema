<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{

    //Allowed values
    protected $fillable = ['title', 'slug', 'published', 'created_by', 'modified_by'];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    //Polymorph
    public function movies()
    {
        return $this->BelongsToMany('App\Movie');
    }

}
