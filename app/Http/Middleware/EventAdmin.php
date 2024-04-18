<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//auth
use Illuminate\Support\Facades\Auth;

class EventAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //auth check if not redirect login
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        //get user role on $userrole var
        $userRole = Auth::user()->role;

        //passing request 
        if($userRole==1)
        {
            return redirect()->route('admin');
        }

        if($userRole==2)
        {
            return $next($request);
        }

        if($userRole==3)
        {
            return redirect()->route('dashboard');
        }
    }
}
