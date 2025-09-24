<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Movimento;
use App\Models\Parcela;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    public function receitaXdespesa()
    {   
        ini_set('max_execution_time', 120);
        $userId = request()->cookie('user_id');

        $totalReceitasParcelas = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                  ->where('movb_natureza', 'Receita');
            })
            ->whereNotNull('par_databaixa')
            ->sum('par_valor');

        $totalDespesasParcelas = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                  ->where('movb_natureza', 'Despesa');
            })
            ->whereNotNull('par_databaixa')
            ->sum('par_valor');

        $totalReceitasMov = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Receita')
            ->whereNotNull('movb_databaixa')
            ->whereDoesntHave('parcelas')
            ->sum('movb_valorliquido');

        $totalDespesasMov = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Despesa')
            ->whereNotNull('movb_databaixa')
            ->whereDoesntHave('parcelas')
            ->sum('movb_valorliquido');

        $totalReceitas = $totalReceitasMov + $totalReceitasParcelas;
        $totalDespesas = $totalDespesasMov + $totalDespesasParcelas;
        $saldoAtual = $totalReceitas - $totalDespesas;

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear  = Carbon::now()->subMonth()->year;

        $totalReceitasAtual = 
            Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita');
            })
            ->whereMonth('par_databaixa', $currentMonth)
            ->whereYear('par_databaixa', $currentYear)
            ->sum('par_valor')
            +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $currentMonth)
                ->whereYear('movb_databaixa', $currentYear)
                ->sum('movb_valorliquido');

        $totalDespesasAtual =
            Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa');
            })
            ->whereMonth('par_databaixa', $currentMonth)
            ->whereYear('par_databaixa', $currentYear)
            ->sum('par_valor')
            +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $currentMonth)
                ->whereYear('movb_databaixa', $currentYear)
                ->sum('movb_valorliquido');

        $saldoMes = $totalReceitasAtual - $totalDespesasAtual;

        $totalReceitasAnterior = 
            Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita');
            })
            ->whereMonth('par_databaixa', $previousMonth)
            ->whereYear('par_databaixa', $previousYear)
            ->sum('par_valor')
            +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $previousMonth)
                ->whereYear('movb_databaixa', $previousYear)
                ->sum('movb_valorliquido');

        $totalDespesasAnterior =
            Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa');
            })
            ->whereMonth('par_databaixa', $previousMonth)
            ->whereYear('par_databaixa', $previousYear)
            ->sum('par_valor')
            +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $previousMonth)
                ->whereYear('movb_databaixa', $previousYear)
                ->sum('movb_valorliquido');

        $saldoAnterior = $totalReceitasAnterior - $totalDespesasAnterior;

        $evolucaoPercentual = $saldoAnterior != 0 
            ? (($saldoMes - $saldoAnterior) / abs($saldoAnterior)) * 100 
            : null;

        $mesReceita = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                  ->where('movb_natureza', 'Receita');
            })
            ->whereMonth('par_databaixa', $currentMonth)
            ->whereYear('par_databaixa', $currentYear)
            ->sum('par_valor') +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $currentMonth)
                ->whereYear('movb_databaixa', $currentYear)
                ->sum('movb_valorliquido');

        $mesDespesa = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                  ->where('movb_natureza', 'Despesa');
            })
            ->whereMonth('par_databaixa', $currentMonth)
            ->whereYear('par_databaixa', $currentYear)
            ->sum('par_valor') +
            Movimento::where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa')
                ->whereDoesntHave('parcelas')
                ->whereMonth('movb_databaixa', $currentMonth)
                ->whereYear('movb_databaixa', $currentYear)
                ->sum('movb_valorliquido');

        $meses = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $data->format('M/Y');
            $meses[$data->format('Y-m')] = [
                'receita' => 0,
                 'despesa' => 0
            ];
        }

        $parcelas = Parcela::join('mov_bancario', 'parcela.par_codigomov', '=', 'mov_bancario.movb_codigo')
            ->select(
                DB::raw('DATE_FORMAT(par_databaixa, "%Y-%m") as ano_mes'),
                'mov_bancario.movb_natureza',
                DB::raw('SUM(par_valor) as total')
            )
            ->where('mov_bancario.movb_codclie', $userId) 
            ->whereNotNull('par_databaixa')
            ->groupBy('ano_mes', 'mov_bancario.movb_natureza')
            ->get();

        $movimentos = Movimento::select(
                DB::raw('DATE_FORMAT(movb_databaixa, "%Y-%m") as ano_mes'),
                'movb_natureza',
                DB::raw('SUM(movb_valorliquido) as total')
            )
            ->where('movb_codclie', $userId)
            ->whereNotNull('movb_databaixa')
            ->whereDoesntHave('parcelas')
            ->groupBy('ano_mes', 'movb_natureza')
            ->get();

        foreach ($parcelas as $p) {
            if (isset($meses[$p->ano_mes])) {
                $meses[$p->ano_mes][strtolower($p->movb_natureza)] += $p->total;
            }
        }

        foreach ($movimentos as $m) {
            if (isset($meses[$m->ano_mes])) {
                $meses[$m->ano_mes][strtolower($m->movb_natureza)] += $m->total;
            }
        }

        $labelsPrevistas = [];
        $mesesPrevistos = [];
        for ($i = 0; $i <= 5; $i++) {
            $data = Carbon::now()->startOfMonth()->addMonths($i);
            $labelsPrevistas[] = $data->format('M/Y');
            $mesesPrevistos[$data->format('Y-m')] = [
                'receita_prevista' => 0,
                'despesa_prevista' => 0
            ];
        }

        $parcelasPrevistas = Parcela::join('mov_bancario', 'parcela.par_codigomov', '=', 'mov_bancario.movb_codigo')
            ->select(
                DB::raw('DATE_FORMAT(par_datavenc, "%Y-%m") as ano_mes'),
                'mov_bancario.movb_natureza',
                DB::raw('SUM(par_valor) as total')
            )
            ->where('mov_bancario.movb_codclie', $userId)
            ->whereBetween('par_datavenc', [Carbon::now()->startOfMonth(), Carbon::now()->addMonths(5)->endOfMonth()])
            ->groupBy('ano_mes', 'mov_bancario.movb_natureza')
            ->get();

        $movimentosPrevistos = Movimento::select(
                DB::raw('DATE_FORMAT(movb_datavenc, "%Y-%m") as ano_mes'),
                'movb_natureza',
                DB::raw('SUM(movb_valorliquido) as total')
            )
            ->where('movb_codclie', $userId)
            ->whereBetween('movb_datavenc', [Carbon::now()->startOfMonth(), Carbon::now()->addMonths(5)->endOfMonth()])
            ->whereDoesntHave('parcelas')
            ->groupBy('ano_mes', 'movb_natureza')
            ->get();

        foreach ($parcelasPrevistas as $p) {
            if (isset($mesesPrevistos[$p->ano_mes])) {
                $mesesPrevistos[$p->ano_mes][strtolower($p->movb_natureza).'_prevista'] += $p->total;
            }
        }

        foreach ($movimentosPrevistos as $m) {
            if (isset($mesesPrevistos[$m->ano_mes])) {
                $mesesPrevistos[$m->ano_mes][strtolower($m->movb_natureza).'_prevista'] += $m->total;
            }
        }

        $dadosReceita = [];
        $dadosDespesa = [];
        foreach ($meses as $m) {
            $dadosReceita[] = $m['receita'];
            $dadosDespesa[] = $m['despesa'];
        }
        
        $dadosSaldoEvolucao = [];
        $saldoAcumulado = 0;
        $n = count($dadosReceita);
        for ($i = 0; $i < $n; $i++) {
            $saldoAcumulado += ($dadosReceita[$i] - ($dadosDespesa[$i] ?? 0));
            $dadosSaldoEvolucao[] = $saldoAcumulado;
        }

        $dadosReceitaPrevista = [];
        $dadosDespesaPrevista = [];
        foreach ($mesesPrevistos as $m) {
            $dadosReceitaPrevista[] = $m['receita_prevista'];
            $dadosDespesaPrevista[] = $m['despesa_prevista'];
        }

        $despesasCategoria = Parcela::join('mov_bancario', 'parcela.par_codigomov', '=', 'mov_bancario.movb_codigo')
            ->select('mov_bancario.movb_categoria', DB::raw('SUM(par_valor) as total'))
            ->where('mov_bancario.movb_codclie', $userId)
            ->where('mov_bancario.movb_natureza', 'Despesa')
            ->whereNotNull('parcela.par_databaixa')
            ->groupBy('mov_bancario.movb_categoria')
            ->get()
            ->toBase();

        $movimentosCategoria = Movimento::select('movb_categoria', DB::raw('SUM(movb_valorliquido) as total'))
            ->where('movb_codclie', $userId)
            ->where('movb_natureza', 'Despesa')
            ->whereDoesntHave('parcelas')
            ->groupBy('movb_categoria')
            ->get()
            ->toBase();

        $despesasCategoria = $despesasCategoria->merge($movimentosCategoria)
            ->groupBy('movb_categoria')
            ->map(function($itens) {
                return $itens->sum('total');
            });

        $categoriaLabels = [];
        $categoriaTotais = [];
        foreach ($despesasCategoria as $categoriaId => $total) {
            $categoriaNome = Categoria::find($categoriaId)->cat_nome ?? 'Não Informado';
            $categoriaLabels[] = $categoriaNome;
            $categoriaTotais[] = $total;
        }

        return view('pages.dashboard', compact(
            'saldoAtual',
            'totalReceitas',
            'totalDespesas',
            'mesReceita',
            'mesDespesa',
            'dadosSaldoEvolucao',
            'evolucaoPercentual',
            'labels',
            'dadosReceita',
            'dadosDespesa',
            'labelsPrevistas',
            'dadosReceitaPrevista',
            'dadosDespesaPrevista',
            'categoriaLabels',
            'categoriaTotais'
        ));
    }
}
