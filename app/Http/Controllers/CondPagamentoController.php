<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CondPagamento;
use Illuminate\Support\Facades\Validator;
use Exception;

class CondPagamentoController extends Controller
{
    public function create()
    {
        return view ('CondPagamento.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'copa_codclie'   => 'nullable|integer',
            'copa_nome'      => 'required|string|max:255',
            'copa_desc'      => 'nullable|string',
            'copa_tipo'      => 'required|string', 
            'copa_intervalo' => 'nullable|integer',
            'copa_parcelas'  => 'nullable|integer',
            'copa_status'    => 'nullable|integer|max:1',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'string'   => 'O campo :attribute deve ser um texto.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            CondPagamento::create([
                'copa_codclie'   => $request->cookie('user_id'),
                'copa_nome'      => $request->copa_nome,
                'copa_desc'      => $request->copa_desc,
                'copa_tipo'      => $request->copa_tipo,
                'copa_intervalo' => $request->copa_intervalo,
                'copa_parcelas'  => $request->copa_parcelas,
                'copa_status'    => $request->copa_status ?? 1,
            ]);

            return redirect()->route('condicoesPagamento')->with('success', 'Condição de Pagamento cadastrada com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar Condição de Pagamento: ' . $e->getMessage())->withInput();
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
