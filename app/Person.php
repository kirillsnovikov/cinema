<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';

    public function scopeLastPersons($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

}
