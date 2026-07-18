<?php

namespace App\Support;

class MediaUrl
{
    /**
     * Strip pre-signed S3 query params so the URL stays stable.
     */
    public static function stabilize(?string $url): string
    {
        if ($url === null || $url === '') {
            return '';
        }

        $parts = parse_url($url);
        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            return $url;
        }

        $query = [];
        if (! empty($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        $hasSignedParams = false;
        foreach (array_keys($query) as $key) {
            if (stripos((string) $key, 'X-Amz-') === 0 || in_array(strtolower((string) $key), ['signature', 'expires', 'awsaccesskeyid'], true)) {
                $hasSignedParams = true;
                break;
            }
        }

        if (! $hasSignedParams) {
            return $url;
        }

        $stable = $parts['scheme'].'://'.$parts['host'];
        if (isset($parts['port'])) {
            $stable .= ':'.$parts['port'];
        }
        $stable .= $parts['path'] ?? '';

        return $stable;
    }

    /**
     * Rewrite src/href URLs inside HTML through stabilize().
     */
    public static function sanitizeHtml(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        return preg_replace_callback(
            '/\b(src|href)\s*=\s*(["\'])(.*?)\2/iu',
            static function (array $matches): string {
                $attr = $matches[1];
                $quote = $matches[2];
                $url = self::stabilize($matches[3]);

                return $attr.'='.$quote.$url.$quote;
            },
            $html
        ) ?? $html;
    }

    /**
     * Null-safe first image URL for any model with images relation.
     */
    public static function firstImageUrl($model, string $fallback = ''): string
    {
        if (! $model || ! method_exists($model, 'images')) {
            return $fallback;
        }

        $images = $model->relationLoaded('images')
            ? $model->images
            : $model->images();

        $first = $images instanceof \Illuminate\Database\Eloquent\Relations\Relation
            ? $images->first()
            : $images->first();

        return $first?->url ?? $fallback;
    }
}
