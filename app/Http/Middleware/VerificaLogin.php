<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificaLogin
{
    public function handle(Request $request, Closure $next)
    {

        if (Session::has('usuario')) {
            return $next($request);
        }

        $userId = $request->cookie('user_id');
        if ($userId) {
           
            return $next($request);
        }

        // 3) não autenticado -> redireciona ao login
        return redirect()
            ->route('login')
            ->withErrors(['login' => 'Faça login para acessar.']);
    }
}
