<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAiMarketingToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $configuredToken = (string) config('services.ai_marketing.token', env('AI_MARKETING_TOKEN'));

        if ($configuredToken === '' || $configuredToken === null) {
            return response()->json(['error' => 'AI marketing token is not configured'], 500);
        }

        $authorizationHeader = $request->header('Authorization', '');

        if (! str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $providedToken = substr($authorizationHeader, 7);

        if (! hash_equals($configuredToken, $providedToken)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

