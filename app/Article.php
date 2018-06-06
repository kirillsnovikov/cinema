<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class Article extends Model
{
    
    
    protected $fillable = ['title', 'slug', 'parent_id', 'description_short', 'description', 'image', 'image_show', 'meta_title', 'meta_description', 'meta_keyword', 'published', 'views', 'created_by', 'modified_by'];
    
    public function setSlugAttribute()
	{
		$this->attributes['slug'] = Str::slug( mb_substr($this->title, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-' );
	}
	
	/*public function setImageAttribute()
	{
		$this->attributes['image'] = 'sdfgsdf';
	}*/
	
	//Polymorph    
    public function categories()
	{
		return $this->morphToMany('App\Category', 'categoryable');
	}
	
	public function scopeLastArticles($query, $count)
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
