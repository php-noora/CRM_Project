<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $admin, string $seller = '', string $customer = ''): Response
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        } else {
            if ($admin == 'admin' && $seller == '' && $customer == '') {
                if ($user->role == 'admin') {
                    return $next($request);
                } else {
                    return redirect()->route('error');
                }

            }
            if ($admin == 'admin' && $seller == 'seller' && $customer == '') {
                if ($user->role == 'admin' || $user->role == 'seller') {
                    return $next($request);
                } else {
                    return redirect()->route('error');
                }
            }
            if ($admin == 'admin' && $seller == 'seller' && $customer == 'customer') {
                if ($user->role == 'admin' || $user->role == 'seller' || $user->role == 'customer') {
                    return $next($request);
                } else {
                    return redirect()->route('error');
                }
            }


        }

        return $next($request);
    }
}


