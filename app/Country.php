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
        'description',
        'code_alpha2',
        'image',
        'image_show',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published',
        'created_by',
        'modified_by',
    ];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = mb_strtolower(Str::slug($this->title, '_'));
    }

    //Polymorph
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }

    public function personBirth()
    {
        return $this->hasMany('App\Person', 'country_birth_id');
    }

    public function personDeath()
    {
        return $this->hasMany('App\Person', 'death_country');
    }

}
