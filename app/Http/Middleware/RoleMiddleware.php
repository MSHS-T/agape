<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $roleValues = array_map(function($r){
            $r = ucfirst($r);
            return \App\Enums\UserRole::getValue($r);
        }, $roles);
        $roleLabels = array_map(function($r){
            $r = ucfirst($r);
            return __('vocabulary.role.'.$r);
        }, $roles);
        if ($request->user() && !in_array($request->user()->role, $roleValues))
        {
            return response()->view('pages.unauthorized', ['roles' => $roleLabels]);
        }
        return $next($request);
    }
}
