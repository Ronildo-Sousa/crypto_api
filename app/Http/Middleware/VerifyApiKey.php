<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $api_key = $request->get('api_key') ?? '';
        $validApiKey = User::hasValidApiKey($api_key);

        if (!$api_key || !$validApiKey) {
            abort(Response::HTTP_UNAUTHORIZED, 'You must provide an api_key');
        }

        return $next($request);
    }
}
