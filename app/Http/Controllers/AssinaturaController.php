<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assinatura;

class AssinaturaController extends Controller
{

    // Efetua a assinatura (POST)
    public function assinar(Request $request)
    {
        $request->validate([
            'plano_id' => 'required|integer',
        ]);

        $userId = Auth::id();

        // Se já tiver assinatura ativa
        $assinaturaAtiva = Assinatura::where('assi_codclie', $userId)
            ->where('assi_status', 'ativa')
            ->first();

        if ($assinaturaAtiva) {
            return redirect()->route('dashboard')->with('info', 'Você já possui uma assinatura ativa.');
        }

        // Cria nova assinatura
        Assinatura::create([
            'assi_codclie' => $userId,
            'assi_codplan' => $request->plano_id,
            'assi_status' => 'ativa',
            'assi_inicio' => now(),
            'assi_fim' => now()->addMonth(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Assinatura realizada com sucesso!');
    }
}
