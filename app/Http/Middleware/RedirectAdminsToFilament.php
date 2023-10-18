<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminsToFilament
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminRoles = collect(config('agape.roles'))->filter(fn ($canAccessAdmin) => $canAccessAdmin)->keys()->all();
        if (Auth::user()->hasAnyRole($adminRoles)) {
            return redirect(route('filament.admin.pages.dashboard'));
        }
        return $next($request);
    }
}
