<?php

namespace App\Http\Middleware;

use App\Library\Enum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard()->user();
        
        if( ($user->user_type == Enum::USER_TYPE_ADMIN) && $user->can($permission))
            return $next($request);

        abort(401, 'Permission denied');
    }
}
