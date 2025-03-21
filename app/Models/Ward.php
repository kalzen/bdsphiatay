<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug'
    ];
    
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
