<?php

namespace App\Http\Middleware\Developers;

use Closure;

use App\Helpers\EnvHelper;

class DeveloperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!EnvHelper::isDev()) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Permission denied.',
                ], 404);
            }

            return abort(404); 
        }

        return $next($request);
    }
}
