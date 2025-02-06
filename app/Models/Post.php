<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    protected $guarded = [];
    public function getUrlAttribute()
    {
        return '/tin-tuc/'.$this->slug;
    }
    public function scopeActive($query) {
        $query->where('status', Post::STATUS_ACTIVE);
    }
    public function scopeIsPromotion($query) {
        $query->where('is_promotion', Post::STATUS_ACTIVE);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class)->withTimestamps();
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($post)
        {
            $post->slug = $post->slug ?: (Str::slug($post->title));
            $post->user_id = $post->user_id ?: (auth()->user()->id ?? null);
        });
        static::updating(function($post)
        {
            $post->slug = Str::slug($post->title);
        });
    }
}
