<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Tối đa $limit tag được gắn nhiều nhất với bài viết đang hiển thị (active).
     */
    public static function topUsedOnPosts(int $limit = 10)
    {
        return static::query()
            ->withCount(['posts' => function ($query) {
                $query->active();
            }])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }
}
