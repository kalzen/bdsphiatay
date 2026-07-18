<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Post;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AiMarketingPostService
{
    /**
     * Create or update a post from AI Marketing payload.
     *
     * @param  array<string, mixed>  $payload
     * @return array{post: Post, created: bool}
     */
    public function upsert(array $payload): array
    {
        $body = MediaUrl::sanitizeHtml($payload['body'] ?? '');
        $title = $payload['title'];
        $description = $payload['description'] ?? null;
        $forceReplace = filter_var(
            $payload['force_replace_images'] ?? $payload['replace_images'] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );
        $imageUrls = array_values(array_filter(array_map(
            static fn ($url) => MediaUrl::stabilize(is_string($url) ? $url : ''),
            $payload['image_urls'] ?? []
        )));

        $existing = $this->findByPublishedUrl($payload['published_url'] ?? null);
        $created = false;

        $post = DB::transaction(function () use (
            &$created,
            $existing,
            $title,
            $body,
            $description,
            $payload,
            $imageUrls,
            $forceReplace
        ) {
            if ($existing) {
                $slug = $existing->slug;
                // Preserve public URL: Post::updating rewrites slug from title.
                Post::withoutEvents(function () use ($existing, $title, $body, $description, $slug) {
                    if (method_exists($existing, 'trashed') && $existing->trashed()) {
                        $existing->restore();
                    }
                    $existing->forceFill([
                        'title' => $title,
                        'content' => $body,
                        'description' => $description,
                        'status' => Post::STATUS_ACTIVE,
                        'slug' => $slug,
                    ])->save();
                });
                $post = $existing->fresh();

                if (array_key_exists('faq', $payload)) {
                    $this->syncFaqs($post, $payload['faq'] ?? []);
                }
            } else {
                $post = Post::create([
                    'title' => $title,
                    'content' => $body,
                    'description' => $description,
                    'status' => Post::STATUS_ACTIVE,
                ]);
                $created = true;

                if (! empty($payload['faq']) && is_array($payload['faq'])) {
                    $this->syncFaqs($post, $payload['faq']);
                }
            }

            if ($imageUrls !== []) {
                $this->syncCoverImage($post, $imageUrls[0], $forceReplace || $created || ! $post->images()->exists());
            }

            Log::info($created ? 'Post created via AI Marketing Agent' : 'Post updated via AI Marketing Agent', [
                'source' => 'ai_marketing_agent',
                'post_id' => $post->id,
            ]);

            return $post->fresh(['images', 'faqs']);
        });

        return ['post' => $post, 'created' => $created];
    }

    public function findByPublishedUrl(?string $publishedUrl): ?Post
    {
        if (! $publishedUrl) {
            return null;
        }

        $path = parse_url($publishedUrl, PHP_URL_PATH) ?: $publishedUrl;
        $path = trim($path, '/');

        if (preg_match('#(?:^|/)tin-tuc/([^/]+)/?$#u', $path, $matches)) {
            $slug = $matches[1];
        } else {
            $segments = array_values(array_filter(explode('/', $path)));
            $slug = end($segments) ?: null;
        }

        if (! $slug) {
            return null;
        }

        return Post::withTrashed()->where('slug', $slug)->first();
    }

    /**
     * @param  array<int, array{question?: string, answer?: string}>  $faqs
     */
    protected function syncFaqs(Post $post, array $faqs): void
    {
        $post->faqs()->delete();

        foreach ($faqs as $faqItem) {
            if (empty($faqItem['question']) || empty($faqItem['answer'])) {
                continue;
            }
            $post->faqs()->create([
                'question' => $faqItem['question'],
                'answer_html' => $faqItem['answer'],
            ]);
        }
    }

    protected function syncCoverImage(Post $post, string $coverUrl, bool $shouldReplace): void
    {
        if ($coverUrl === '' || ! $shouldReplace) {
            return;
        }

        $existing = $post->images()->first();
        if ($existing) {
            $existing->update(['url' => $coverUrl]);

            return;
        }

        $image = Image::create(['url' => $coverUrl]);
        $post->images()->attach($image->id);
    }
}
