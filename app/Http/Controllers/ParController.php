<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movimento;
use App\Models\CondPagamento;
use App\Models\Categoria;
use App\Models\Parcela;

class ParController extends Controller
{
    public function create()
    {
        return view('par.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'par_codclie'   => 'nullable|integer',
            'par_codigomov'    => 'nullable|integer',
            'par_valor'    => 'nullable|decimal',
            'par_numero'    => 'nullable|integer',
            'par_qtnumero'  => 'nullable|integer',
            'par_datavenc'  => 'nullable|integer',
            'par_databaixa' => 'nullable|integer',
            'par_situacao'  => 'nullable|integer',
        ],
        [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve estar em formato válido (YYYY-MM-DD).',
            'string'   => 'O campo :attribute deve ser um texto.',

        ]);

        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            Movimento::create([
                'par_codclie'       => $request->cookie('user_id'),
                'par_codigomov'        => $request->par_codigomov,
                'par_valor'        => $request->par_valor,
                'par_numero'        => $request->par_numero,
                'par_qtnumero'      => $request->par_qtnumero,
                'par_datavenc'      => $request->par_datavenc,
                'par_databaixa'     => $request->par_databaixa,
                'par_situacao'      => $request->par_situacao,
            ]);

            return redirect()
                ->route('')
                ->with('success', 'Movimento cadastrado com sucesso!');

        } catch (Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Erro ao salvar o movimento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function exibir() 
    {
        $movimentos = Movimento::with('categoria')
            ->where('movb_codclie', request()->cookie('user_id'))
            ->orderBy('movb_dataes', 'desc')
            ->get();

        $categorias = Categoria::where('cat_codclie', request()->cookie('user_id'))
            ->orderBy('cat_codigo', 'asc')
            ->get();

        $cond_pagamento = CondPagamento::where('copa_codclie', request()->cookie('user_id'))
            ->orderBy('copa_codigo', 'asc')
            ->get();

        $parcelas = Parcela::where('par_codclie', request()->cookie('user_id'))
            ->orderBy('par_codigo', 'asc')
            ->get();

        return view('pages.extrato', compact('movimentos','categorias','cond_pagamento','parcelas'));
    }
    public function update(Request $request, $par_codigo, $par_codigomov)
    {
        $parcela = Parcela::findOrFail($par_codigo);
        $parcela->update($request->all());

        if ($request->filled('par_databaixa')) {
        $parcela->par_situacao = 'Pago';
        } else {
            $parcela->par_situacao = 'Pendente';
        }

        $parcela->save();

        $verificarParcelas = Parcela::where('par_codigomov', $par_codigomov)
        ->where('par_situacao', '!=', 'Pago')
        ->count() === 0;

        if ($verificarParcelas) {
            $movimento = Movimento::findOrFail($par_codigomov);
            $movimento->movb_situacao = 'Pago';
            $movimento->save();
        }

        return redirect()->route('extrato')->with('success', 'Parcelamento atualizado com sucesso!');
    }
}
