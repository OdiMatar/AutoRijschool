<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanManageVehicles
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->canManageVehicles()) {
            abort(403, 'Je hebt geen rechten om voertuiggegevens te wijzigen.');
        }

        return $next($request);
    }
}
