<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Store a newly created post coming from external AI Marketing Agent.
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
            $post = null;

            DB::transaction(function () use (&$post, $validated) {
                $post = Post::create([
                    'title' => $validated['title'],
                    'content' => $validated['body'],
                    'description' => $validated['description'] ?? null,
                    'status' => Post::STATUS_ACTIVE,
                ]);

                if (!empty($validated['faq']) && is_array($validated['faq'])) {
                    foreach ($validated['faq'] as $faqItem) {
                        $post->faqs()->create([
                            'question' => $faqItem['question'],
                            'answer_html' => $faqItem['answer'],
                        ]);
                    }
                }

                Log::info('Post created via AI Marketing Agent', [
                    'source' => 'ai_marketing_agent',
                    'post_id' => $post->id,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to create post via AI Marketing Agent', [
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

        $publicUrl = url($post->url);

        return response()->json([
            'url' => $publicUrl,
        ], 201);
    }
}

