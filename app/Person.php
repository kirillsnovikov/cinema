<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Person extends Model
{

    protected $table = 'persons';
    protected $guarded = ['professions'];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = mb_strtolower(Str::slug($this->firstname . '_' . $this->lastname . '_' . $this->id, '_'));
    }

    public function professions()
    {
        return $this->BelongsToMany('App\Profession');
    }
    
    public function countries()
    {
        return $this->BelongsToMany('App\Country');
    }

    public function scopeLastPersons($query, $count)
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
