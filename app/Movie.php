<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{

    protected $guarded = ['types', 'genres', 'countries'];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = mb_strtolower(Str::slug($this->title . '_' . $this->id, '_'));
//        dd($this->id);
    }

    //Polymorph    
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country');
    }
    
    public function directors()
    {
        return $this->belongsToMany('App\Person', 'director_movie', 'movie_id', 'director_id');
    }
    
    public function actors()
    {
        return $this->belongsToMany('App\Person', 'actor_movie', 'movie_id', 'actor_id');
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
