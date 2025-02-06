<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];
    public function imageable()
    {
        return $this->morphTo();
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($image)
        {
            $image->user_id = auth()->user()->id ?? null;
        });
    }
}
