<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Person extends Model
{

    protected $table = 'persons';
    protected $fillable = [
        'firstname',
        'middlename',
        'middlename_second',
        'middlename_third',
        'middlename_fourth',
        'lastname',
        'lastneme_prefix',
        'slug',
        'sex',
        'tall',
        'birth_date',
        'death_date',
        'birth_place',
        'death_place',
        'image_name',
        'image_ext',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'published',
        'views',
        'kp_id',
        'created_by',
        'modified_by',
    ];

    public function setSlugAttribute()
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->firstname . ' ' . $this->lastname, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    public function professions()
    {
        return $this->BelongsToMany('App\Profession');
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
