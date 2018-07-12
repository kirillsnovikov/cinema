<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profession extends Model
{

    //Allowed values
    protected $fillable = ['title', 'slug', 'published', 'created_by', 'modified_by'];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    public function persons()
    {
        return $this->BelongsToMany('App\Person');
    }

}
