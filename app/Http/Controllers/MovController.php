<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovRequest;
use App\Models\Movimento;
use App\Models\Categoria;
use App\Models\CondPagamento;
use App\Models\Parcela;
use App\Models\Pessoa;
use Exception;
use Illuminate\Support\Facades\Auth;

class MovController extends Controller
{
    // CADASTRO 
    public function store(MovRequest $request)
    {

        try {
            
            $request->validated();

            $userId = Auth::id();

            $condicao = CondPagamento::where('copa_codigo', $request->movb_forma)->first();

            if (!$condicao) {
                throw new \Exception("Condição de pagamento inválida.");
            }

            $movimento = Movimento::create([
                'movb_codclie'      => $userId,
                'movb_codigo'       => $request->movb_codigo,
                'movb_valortotal'   => $request->movb_valortotal,
                'movb_valorliquido' => $request->movb_valorliquido,
                'movb_situacao'     => $request->movb_situacao,
                'movb_categoria'    => $request->movb_categoria,
                'movb_pessoa'       => $request->movb_pessoa,
                'movb_observ'       => $request->movb_observ,
                'movb_datavenc'     => $request->movb_datavenc,
                'movb_databaixa'    => $request->movb_databaixa,
                'movb_dataes'       => now(), 
                'movb_forma'        => $request->movb_forma,
                'movb_natureza'     => $request->movb_natureza,
            ]);

            $parcelasSelecionadas = $request->movb_parcelas;

            if ($parcelasSelecionadas > 1) {
                $valorParcela   = $request->movb_valortotal / $parcelasSelecionadas;
                $dataVencimento = \Carbon\Carbon::parse($request->movb_datavenc);
                
                for ($i = 1; $i <= $parcelasSelecionadas; $i++) {
                    Parcela::create([
                        'par_codclie'   => $userId, 
                        'par_codigo'    => $movimento->id,        
                        'par_codigomov' => $movimento->movb_codigo,  
                        'par_valor'     => $valorParcela,
                        'par_numero'    => $i,
                        'par_qtnumero'  => $parcelasSelecionadas,
                        'par_datavenc'  => $dataVencimento->copy()->addMonths($i - 1), // Aqui
                        'par_databaixa' => $request->movb_databaixa 
                                            ? $dataVencimento->copy()->addMonths($i - 1) 
                                            : null,
                        'par_situacao'  => $request->movb_databaixa ? 'Pago' : 'Pendente',
                    ]);
                }
            }

            return redirect()
                ->route('extrato')
                ->with('success', 'Movimento cadastrado com sucesso!');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao salvar o movimento: ' . $e->getMessage())
                ->withInput();
        }
    }

    // LISTAR EXTRATO
    public function exibir(Request $request) 
    {
    $userId = Auth::id();
    
    // QUERY FILTROS EXTRATO
    $query = Movimento::with('categoria', 'condpagamento', 'pessoa')
        ->where('movb_codclie', $userId);

    if ($request->filled('categoria')) {
        $query->where('movb_categoria', $request->categoria);
    }

    if ($request->filled('natureza')) {
        $query->where('movb_natureza', $request->natureza);
    }

    if ($request->filled('situacao')) {
        $query->where('movb_situacao', $request->situacao);
    }

    if ($request->filled('data_inicio') && $request->filled('data_fim')) {
        $query->whereBetween('movb_databaixa', [$request->data_inicio, $request->data_fim]);
    } elseif ($request->filled('data_inicio')) {
        $query->whereDate('movb_databaixa', '>=', $request->data_inicio);
    } elseif ($request->filled('data_fim')) {
        $query->whereDate('movb_databaixa', '<=', $request->data_fim);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('movb_pessoa', 'like', "%{$search}%")
              ->orWhere('movb_observ', 'like', "%{$search}%");
        });
    }

    $movimentos = $query->orderBy('movb_dataes', 'desc')->paginate(15);

    $categorias = Categoria::where('cat_codclie', $userId)
        ->orderBy('cat_codigo', 'asc')
        ->get();

    $cond_pagamento = CondPagamento::where('copa_codclie', $userId)
        ->orderBy('copa_codigo', 'asc')
        ->get();

    $pessoa = Pessoa::where('pes_codclie', $userId)
        ->orderBy('pes_codigo','asc')
        ->get();

    $parcela = Parcela::where('par_codclie', $userId)
        ->orderBy('par_codigo','asc')
        ->get();

    return view('pages.extrato', compact('movimentos', 'categorias', 'cond_pagamento', 'pessoa', 'parcela'));
    }

    // LISTAR PARCELAS
    public function parcelamento(Request $request, $movb_codigo)
    {
        $movimento = Movimento::findOrFail($movb_codigo);
        $userId = Auth::id();

        $parcelas = Parcela::where('par_codclie', $userId)
            ->where('par_codigomov', $movb_codigo) 
            ->orderBy('par_numero', 'asc')
            ->get();

        return response()->json([
            'movimento' => $movimento,
            'parcelas' => $parcelas
        ]);
    }

    // EDITAR 
    public function edit(Request $request, $movb_codigo)
    {
        $movimento = Movimento::findOrFail($movb_codigo);
        $categorias = Categoria::orderBy('cat_codigo', 'desc')->get();
        $cond_pagamento = CondPagamento::orderBy('copa_codigo', 'desc')->get();

        return view('pages.extrato', compact('movimento', 'categorias', 'cond_pagamento'));
    }

    // EDITAR 
    public function update(Request $request, $movb_codigo)
    {     
        try {
            $condicao = CondPagamento::where('copa_codigo', $request->movb_forma)->first();
            
            $userId = Auth::id();

            if (!$condicao) {
                throw new \Exception("Condição de pagamento inválida.");
            }

            $movimento = Movimento::findOrFail($movb_codigo);

            if (!empty($request->movb_databaixa)) {
                $request->merge(['movb_situacao' => 'Pago']);
            }

            $movimento->update($request->all());

            if ($condicao->copa_tipo === 'A prazo' && $condicao->copa_parcelas > 1) {
                $valorParcela   = $request->movb_valortotal / $condicao->copa_parcelas;
                $dataVencimento = \Carbon\Carbon::parse($request->movb_datavenc);

                Parcela::where('par_codigomov', $movimento->movb_codigo)->delete();

                for ($i = 1; $i <= $condicao->copa_parcelas; $i++) {
                    Parcela::create([
                        'par_codclie'   => $userId, 
                        'par_codigo'    => $movimento->id,        
                        'par_codigomov' => $movimento->movb_codigo,  
                        'par_valor'     => $valorParcela,
                        'par_numero'    => $i,
                        'par_qtnumero'  => $condicao->copa_parcelas,
                        'par_datavenc'  => $dataVencimento->copy()->addDays($condicao->copa_intervalo * ($i - 1)),
                        'par_databaixa' => null,
                        'par_situacao'  => 'Pendente',
                    ]);
                }
            }

            return redirect()
                ->route('extrato')
                ->with('success', 'Movimento cadastrado com sucesso!');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao salvar o movimento: ' . $e->getMessage())
                ->withInput();
        }
    }

    // DELETE 
    public function destroy($movb_codigo)
    {
        $movimento = Movimento::findOrFail($movb_codigo);
        $parcela = Parcela::where('par_codigomov', $movb_codigo);
        $movimento->delete();
        $parcela->delete();

        return redirect()->route('extrato')->with('success', 'Movimento excluído com sucesso!');
    }
}
