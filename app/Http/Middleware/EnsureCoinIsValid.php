<?php

namespace App\Http\Middleware;

use App\Classes\CoinHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCoinIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $coin = $request->route('coin');
        if (!CoinHelper::isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database'], Response::HTTP_NOT_FOUND);
        }
        return $next($request);
    }
}
