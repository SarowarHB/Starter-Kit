<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $guard = Auth::guard();
        if($guard->check() && $guard->user()->user_type === $role) {

            // Config::set('auth.role_permissions', $guard->user()->roles()->first()->permissions()->pluck('slug')->toArray());

            $data = [];
            foreach($guard->user()->roles as $item) {
               $data[] = $item->permissions()->pluck('slug')->toArray();
            }

            $result = array_merge(...$data);

            Config::set('auth.role_permissions', $result);

            return $next($request);
        }
        else{
            return redirect()->route('admin.login');
        }
    }
}
