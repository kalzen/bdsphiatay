<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class)->withTimestamps();
    }
}
