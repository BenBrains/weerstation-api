<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('API_KEY');

        if ($apiKey !== config('app.api_key')) {
            return response()->json(['error' => 'Invalid API Key'], 401);
        }

        return $next($request);
    }
}
