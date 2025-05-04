<?php

namespace App\Http\Middleware;

use App\Enums\GuardType;
use App\Traits\ApiTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use ApiTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAdmin = GuardType::isAdmin(auth()->user()->currentAccessToken()->name);
        if (! $isAdmin) {
            return $this->errorMessage('Not Authorized', 401);
        }
        return $next($request);
    }
}
