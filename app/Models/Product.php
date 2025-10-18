<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'price', 'status', 'user_id', 'ward_id'
    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    public function getUrlAttribute()
    {
        return '/du-an/'.$this->getSlugAttribute();
    }
    
    public function getSlugAttribute($value)
    {
        // Nếu slug null hoặc rỗng, tự động generate từ title
        if (empty($value) && !empty($this->title)) {
            $slug = Str::slug($this->title);
            // Lưu slug vào database nếu chưa có
            if ($this->exists) {
                $this->update(['slug' => $slug]);
            }
            return $slug;
        }
        return $value;
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
            return  ($price / 1000000) ." triệu ";
        }
        if ($price >= 1000000000)
        {
            return ($price / 1000000000)." tỷ";
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
    
    /**
     * Update tất cả sản phẩm thiếu slug
     */
    public static function updateMissingSlugs()
    {
        $products = self::whereNull('slug')->orWhere('slug', '')->get();
        
        foreach ($products as $product) {
            if (!empty($product->title)) {
                $slug = Str::slug($product->title);
                // Đảm bảo slug unique
                $originalSlug = $slug;
                $counter = 1;
                while (self::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $product->update(['slug' => $slug]);
            }
        }
        
        return $products->count();
    }
}
