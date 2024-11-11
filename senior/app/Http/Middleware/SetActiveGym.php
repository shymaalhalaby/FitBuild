<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Gym;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveGym
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $gymId = $request->user()->gym_id;
            $gym = Gym::findOrFail($gymId);

            app()->instance('gym.active', $gym);
        }

        return $next($request);
    }
}
