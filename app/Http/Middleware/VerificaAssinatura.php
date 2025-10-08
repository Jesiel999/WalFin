<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assinatura;

class VerificaAssinatura
{
    public function handle(Request $request, Closure $next)
    {
        // Se o usuário não estiver logado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        $userId = Auth::id();

        // Busca assinatura ativa
        $assinatura = Assinatura::where('assi_codclie', $userId)
            ->where('assi_status', 'ativa')
            ->first();

        // Se não tiver assinatura, redireciona para a home
        if (!$assinatura) {
            return redirect()->route('home')->with('error', 'Você precisa assinar um plano para acessar o sistema.');
        }

        // Tudo certo → segue para a rota
        return $next($request);
    }
}
