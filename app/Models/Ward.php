<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ward extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug'
    ];
    
    // Ensure a slug is always available
    public function getSlugAttribute($value)
    {
        // If slug is empty, generate from name
        if (empty($value) && !empty($this->name)) {
            return Str::slug($this->name);
        }
        return $value;
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // Method to get ward by slug
    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}
