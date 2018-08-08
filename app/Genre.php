<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Genre extends Model
{

    //Allowed values
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'published',
        'created_by',
        'modified_by'
    ];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug($this->title, '_');
    }

    // Get children genre
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    //Polymorph
    public function movies()
    {
        return $this->BelongsToMany('App\Movie');
    }

    public function scopeLastGenres($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

}
