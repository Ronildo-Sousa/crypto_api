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
        $api_key = $request->get('api_key');

        abort_if(is_null($api_key),Response::HTTP_UNAUTHORIZED, 'You must provide an api_key');

        abort_if(!User::hasValidApiKey($api_key), Response::HTTP_UNAUTHORIZED, 'Invalid api_key, try again');

        return $next($request);
    }
}
