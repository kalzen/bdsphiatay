<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostDetailImageSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_related_post_without_images_does_not_throw(): void
    {
        $related = Post::create([
            'title' => 'Bai related khong anh',
            'content' => '<p>Related</p>',
            'description' => 'Related desc',
            'status' => Post::STATUS_ACTIVE,
        ]);

        $related->load('images');
        $this->assertCount(0, $related->images);

        // Mirrors resources/views/post/detail.blade.php related-posts img src.
        $src = $related->images->first()?->url ?? '';

        $this->assertSame('', $src);
    }
}
