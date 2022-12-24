<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdministratorCheck
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
        $user = auth()->user();
        $roles = Role::where('id', 1)->pluck('id')->toArray();

        if (!$user) {
            return $next($request);
        }

        Gate::define('isAdmin', function($user) use ($roles) {
            return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
         });

        return $next($request);
    }
}
