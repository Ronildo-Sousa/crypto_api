<?php

namespace App\Http\Middleware;

use App\Classes\CoinHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCoinIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate(['coin' => 'string']);

        if(!$request->coin) $request->coin = 'bitcoin';

        abort_if(!CoinHelper::isValidCoin($request->coin), Response::HTTP_NOT_FOUND, 'Could not find this coin');

        return $next($request);
    }
}
