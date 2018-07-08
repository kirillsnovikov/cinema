<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{

    protected $fillable = [
        'title',
        'title_eng',
        'slug',
        'description',
        'description_short',
        'kp_raiting',
        'imdb_raiting',
        'image_name',
        'image_ext',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'published',
        'views',
        'year',
        'duration',
        'kp_id',
        'created_by',
        'modified_by',
    ];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    //Polymorph    
    public function genres()
    {
        return $this->BelongsToMany('App\Genre');
    }

    public function scopeLastMovies($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function userCreated()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function userModified()
    {
        return $this->belongsTo('App\User', 'modified_by');
    }

}