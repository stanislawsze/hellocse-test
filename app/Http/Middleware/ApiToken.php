<?php

namespace App\Http\Middleware;

use App\Models\Administrator;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->bearerToken();
        if (!$accessToken) {
            return response()->json(['message' => 'Missing token'], Response::HTTP_UNAUTHORIZED);
        }
        $administrator = Administrator::where('bearer_token', $accessToken)->first();

        if(!$administrator){
            return response()->json(['message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
