<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicKeyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sk_key = $request->header('x-secret-key');
        $key = ApiKey::where('private_key', $sk_key)->first();
        if (! $key || ! $key->active) {
            return response()->json(['message' => 'You do not have permission to this resource.'], Response::HTTP_FORBIDDEN);
        }

        // TODO log activity.
        $request->merge(['throttle' => true]);
        return $next($request);
    }
}
