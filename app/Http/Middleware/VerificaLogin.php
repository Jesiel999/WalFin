<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class VerificaLogin
{
    public function handle(Request $request, Closure $next)
    {
       if (Auth::check()) {
            return $next($request);
       }
       return redirect()->route("login")->withErrors(["login" => "Faça login para acessar."]);
    }

}
