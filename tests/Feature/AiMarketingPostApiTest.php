<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiMarketingPostApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.ai_marketing.token' => 'test-ai-token']);
    }

    public function test_create_post_with_image_urls_strips_signed_query(): void
    {
        $signedBody = '<p>Hello</p><img src="https://cdn.example.com/in.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Signature=abc">';
        $signedCover = 'https://cdn.example.com/cover.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=x&X-Amz-Signature=yz';

        $response = $this->withHeader('Authorization', 'Bearer test-ai-token')
            ->postJson('/api/posts', [
                'title' => 'Bai test anh S3',
                'body' => $signedBody,
                'description' => 'Mo ta',
                'image_urls' => [$signedCover],
            ]);

        $response->assertCreated();
        $response->assertJsonStructure(['url']);

        $post = Post::where('slug', 'bai-test-anh-s3')->first();
        $this->assertNotNull($post);
        $this->assertStringNotContainsString('X-Amz-', $post->content);
        $this->assertStringContainsString('https://cdn.example.com/in.jpg', $post->content);
        $this->assertSame('https://cdn.example.com/cover.jpg', $post->images()->first()?->url);
    }

    public function test_update_via_published_url_replaces_content_and_images(): void
    {
        $post = Post::create([
            'title' => 'Bai cu',
            'slug' => 'bien-dong-bang-gia-dat-nen-2026-giai-phap-dinh-gia-thuc-te-cho-nha-dau-tu',
            'content' => '<img src="https://old.example.com/a.jpg?X-Amz-Signature=old">',
            'description' => 'cu',
            'status' => Post::STATUS_ACTIVE,
        ]);
        // Prevent boot from changing slug on create if title slug differs
        $post->forceFill([
            'slug' => 'bien-dong-bang-gia-dat-nen-2026-giai-phap-dinh-gia-thuc-te-cho-nha-dau-tu',
        ])->saveQuietly();

        $oldImage = Image::create(['url' => 'https://old.example.com/cover.jpg?X-Amz-Signature=old']);
        $post->images()->attach($oldImage->id);

        $newBody = '<p>Noi dung moi</p><img src="https://cdn.example.com/new.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Signature=new">';
        $newCover = 'https://cdn.example.com/new-cover.jpg?X-Amz-Signature=new';

        $response = $this->withHeader('Authorization', 'Bearer test-ai-token')
            ->postJson('/api/posts', [
                'title' => 'Bai moi title',
                'body' => $newBody,
                'description' => 'mo ta moi',
                'published_url' => 'https://batdongsanphiatay.vn/tin-tuc/bien-dong-bang-gia-dat-nen-2026-giai-phap-dinh-gia-thuc-te-cho-nha-dau-tu',
                'image_urls' => [$newCover],
                'force_replace_images' => true,
            ]);

        $response->assertOk();
        $response->assertJson([
            'url' => url('/tin-tuc/bien-dong-bang-gia-dat-nen-2026-giai-phap-dinh-gia-thuc-te-cho-nha-dau-tu'),
        ]);

        $post->refresh();
        $this->assertSame('bien-dong-bang-gia-dat-nen-2026-giai-phap-dinh-gia-thuc-te-cho-nha-dau-tu', $post->slug);
        $this->assertSame('Bai moi title', $post->title);
        $this->assertStringContainsString('Noi dung moi', $post->content);
        $this->assertStringNotContainsString('X-Amz-', $post->content);
        $this->assertStringNotContainsString('old.example.com', $post->content);
        $this->assertSame('https://cdn.example.com/new-cover.jpg', $post->images()->first()?->url);
    }
}
