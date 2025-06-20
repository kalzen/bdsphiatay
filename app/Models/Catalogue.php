<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Catalogue extends Model
{
    protected $guarded = [];
    public function children() {
        return $this->hasMany(Catalogue::class, 'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Catalogue::class, 'parent_id');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function getUrlAttribute()
    {
        return '/danh-muc/' . $this->slug;
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
    
    public static function boot()
    {
        parent::boot();
        static::creating(function($catalogue)
        {
            $catalogue->slug = Str::slug($catalogue->name);
        });
        static::updating(function($catalogue)
        {
            $catalogue->slug = Str::slug($catalogue->name);
        });
    }
}
