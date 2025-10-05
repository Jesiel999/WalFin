<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use App\Models\Parcela;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvestController extends Controller
{
    public function exibir()
    {   
        ini_set('max_execution_time', 120);

        $userId = Auth::id();
        
        $totalResgatado = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Receita')
            ->whereNotNull('movb_databaixa')
            ->where('movb_categoria', '=', '10')
            ->whereDoesntHave('parcelas')
            ->sum('movb_valorliquido');

        $inicio = Carbon::now()->startOfMonth()->subMonths(5);
        $fim = Carbon::now()->endOfMonth();

        $investimentosPorMes = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Despesa')
            ->whereNotNull('movb_databaixa')
            ->where('movb_categoria', '=', '10')
            ->whereDoesntHave('parcelas')
            ->whereBetween('movb_databaixa', [$inicio, $fim])
            ->selectRaw('DATE_FORMAT(movb_databaixa, "%Y-%m") as ano_mes, SUM(movb_valorliquido) as total_mes')
            ->groupBy('ano_mes')
            ->get()
            ->keyBy('ano_mes');

        $mesesPeriodo = new \DatePeriod($inicio, new \DateInterval('P1M'), $fim->copy()->addMonth());

        $dadosInvestimentos = [];
        foreach ($mesesPeriodo as $mes) {
            $chave = $mes->format('Y-m');
            $dadosInvestimentos[$chave] = $investimentosPorMes[$chave]->total_mes ?? 0;
        }

        $totalInvestido = array_sum($dadosInvestimentos);
        $quantidadeMeses = count($dadosInvestimentos);
        $mediaInvestimentoMensal = $quantidadeMeses > 0 ? $totalInvestido / $quantidadeMeses : 0;
        $carteira = $totalInvestido - $totalResgatado;

        $meses = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $data->format('M/Y');
            $meses[$data->format('Y-m')] = [
                'receita' => 0,
                'despesa' => 0,
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
            ->where('mov_bancario.movb_categoria', '=', '10')
            ->groupBy('ano_mes', 'mov_bancario.movb_natureza')
            ->get();

        $movimentos = Movimento::select(
                DB::raw('DATE_FORMAT(movb_databaixa, "%Y-%m") as ano_mes'),
                'movb_natureza',
                DB::raw('SUM(movb_valorliquido) as total')
            )
            ->where('movb_codclie', $userId)
            ->where('movb_categoria', '=', '10')
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
                'despesa_prevista' => 0,
            ];
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

        return view('pages.invest', compact(
            'totalInvestido',
            'carteira',
            'totalResgatado',
            'mediaInvestimentoMensal',
            'labels',
            'dadosReceita',
            'dadosDespesa'
        ));
    }
}
