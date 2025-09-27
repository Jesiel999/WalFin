<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CondPagamentoRequest;
use Illuminate\Http\Request;
use App\Models\CondPagamento;
use Exception;

class CondPagamentoController extends Controller
{
    public function create()
    {
        return view ('CondPagamento.create');
    }

    public function store(CondPagamentoRequest $request)
    {
        try {
            $dados = $request->validated();

            $dados['copa_codclie'] = $request->cookie('user_id');

            CondPagamento::create($dados);
            
            return redirect()
                ->route('condicoesPagamento')
                ->with('success', 'Condição de Pagamento cadastrada com sucesso!');
        
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao cadastrar Condição de Pagamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function exibir()
    {
        $cond_pagamento = CondPagamento::where('copa_codclie', request()->cookie('user_id'))
            ->orderBy('copa_codigo', 'asc')
            ->get();

        return view('pages.condicoesPagamento', compact('cond_pagamento'));
    }

    public function update(Request $request, $copa_codigo)
    {
        $cond_pagamento = CondPagamento::findOrFail($copa_codigo);
        $cond_pagamento->update($request->all());

        return redirect()->route('condicoesPagamento')->with('success', 'Condição de Pagamento atualizada com sucesso !');
    }
    public function destroy($copa_codigo)
    {
        $cond_pagamento = CondPagamento::findOrFail($copa_codigo);
        $cond_pagamento->delete();

        return redirect()->route('condicoesPagamento')->with('success', 'Condição de Pagamento excluída com sucesso');
    }
}
