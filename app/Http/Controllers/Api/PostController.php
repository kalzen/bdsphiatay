<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AiMarketingPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /** @var AiMarketingPostService */
    protected $postService;

    public function __construct(AiMarketingPostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Create or update a post coming from external AI Marketing Agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => ['required', 'string'],
                'body' => ['required', 'string'],
                'description' => ['nullable', 'string'],
                'published_url' => ['nullable', 'string'],
                'image_urls' => ['nullable', 'array'],
                'image_urls.*' => ['nullable', 'string'],
                'force_replace_images' => ['nullable'],
                'replace_images' => ['nullable'],
                'faq' => ['nullable', 'array'],
                'faq.*.question' => ['required_with:faq', 'string'],
                'faq.*.answer' => ['required_with:faq', 'string'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        }

        try {
            $result = $this->postService->upsert($validated);
            $post = $result['post'];
        } catch (\Throwable $e) {
            Log::error('Failed to upsert post via AI Marketing Agent', [
                'source' => 'ai_marketing_agent',
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to create post',
            ], 500);
        }

        if (! $post || ! $post->slug) {
            return response()->json([
                'error' => 'Failed to generate post URL',
            ], 500);
        }

        return response()->json([
            'url' => url($post->url),
        ], $result['created'] ? 201 : 200);
    }
}
