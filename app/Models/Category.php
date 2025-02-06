<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
    public function getUrlAttribute()
    {
        return '/danh-muc-tin-tuc/' . $this->slug;
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($category)
        {
            $category->slug = Str::slug($category->name);
        });
        static::updating(function($category)
        {
            $category->slug = Str::slug($category->name);
        });
    }
}
