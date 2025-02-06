<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    public function getUrlAttribute()
    {
        return '/du-an/'.$this->slug;
    }
    public function scopeActive($query) {
        $query->where('status', Product::STATUS_ACTIVE);
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
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class)->withTimestamps();
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withTimestamps()->withPivot(['value']);
    }
    public function plans()
    {
        return $this->belongsToMany(Plan::class)->withTimestamps();
    }
    public function price_convert()
    {
        $price = $this->price;
        if ($price < 1000000000 && $price > 100000000)
        {
            return  ($price / 1000000) ."triệu ";
        }
        if ($price >= 1000000000)
        {
            return ($price / 1000000000)."tỷ";
        }
    }
    //public function attribute($id)
//    {
//        return $this->attributes()->where('attribute_id', $id)->first();
//    }
    public function getValueAttribute($id)
    {
        return $this->attributes()->where('attribute_product.attribute_id', $id)->withPivot(['value']);
        
    }
    public function catalogues()
    {
        return $this->belongsToMany(Catalogue::class)->withTimestamps();
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($product)
        {
            $product->slug = $product->slug ?: (Str::slug($product->title));
            $product->user_id = $product->user_id ?: (auth()->user()->id ?? null);
        });
        static::updating(function($product)
        {
            $product->slug = Str::slug($product->title);
        });
    }
}
