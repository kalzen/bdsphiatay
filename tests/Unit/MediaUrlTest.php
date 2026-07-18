<?php

namespace Tests\Unit;

use App\Support\MediaUrl;
use PHPUnit\Framework\TestCase;

class MediaUrlTest extends TestCase
{
    public function test_stabilize_strips_x_amz_query_params(): void
    {
        $signed = 'https://cdn.example.com/bucket/cover.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=x&X-Amz-Date=20260711T000000Z&X-Amz-Signature=abc';

        $this->assertSame(
            'https://cdn.example.com/bucket/cover.jpg',
            MediaUrl::stabilize($signed)
        );
    }

    public function test_stabilize_keeps_public_url(): void
    {
        $public = 'https://cdn.example.com/bucket/cover.jpg';

        $this->assertSame($public, MediaUrl::stabilize($public));
    }

    public function test_sanitize_html_strips_signed_urls_in_src(): void
    {
        $html = '<p>Hi</p><img src="https://cdn.example.com/a.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Signature=xyz" alt="x">';

        $result = MediaUrl::sanitizeHtml($html);

        $this->assertStringContainsString('src="https://cdn.example.com/a.jpg"', $result);
        $this->assertStringNotContainsString('X-Amz-', $result);
    }
}
