<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class VerificaLogin
{
    public function handle(Request $request, Closure $next)
    {
        // 1) Verifica sessão (Laravel)
        if (Session::has('usuario')) {
            return $next($request);
        }

        // 2) Verifica cookie diretamente da request (mais confiável)
        $userId = $request->cookie('user_id');
        if ($userId) {
            // opcional: você pode re-hidratar session a partir do cookie
            // Session::put('usuario', ['id' => $userId, 'nome' => $request->cookie('user_name')]);
            return $next($request);
        }

        // 3) não autenticado -> redireciona ao login
        return redirect()->route('login')->withErrors(['login' => 'Faça login para acessar.']);
    }
}
