<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    // protected $table = 'blogposts';
    
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
    	return $this->hasMany('App\Comment')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

     public function image()
    {
        return $this->hasOne('App\Image');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
         static::addGlobalScope(new DeletedAdminScope);
         
    	 parent::boot();

    	 static::deleting(function(BlogPost $blogPost) {
    	 	$blogPost->comments()->delete();
    	 });

         static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
         });
    }
}
