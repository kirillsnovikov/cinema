<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profession extends Model
{

    //Allowed values
    protected $guarded = [];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug($this->title, '_');
    }

    public function persons()
    {
        return $this->BelongsToMany('App\Person');
    }

}
