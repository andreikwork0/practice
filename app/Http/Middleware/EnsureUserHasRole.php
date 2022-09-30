<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles )
    {

        $role = $request->user()->role ?? false;

        if ($role){

            $rn = $role->name;
            if ($rn  == 'admin') return $next($request);

            if ($rn == 'kaf' && !(request()->user()->pulpit_id))   return redirect()->route('home');

            if (! in_array($rn, $roles))   return redirect()->route('home');
            else    return $next($request);

        }
            return redirect()->route('home');
    }
}
