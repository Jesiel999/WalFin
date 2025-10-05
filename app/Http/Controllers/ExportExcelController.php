<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use Illuminate\Http\Request;

class ExportExcelController extends Controller
{
    public function export()
    {
        $movimentos = Movimento::all();
        $filename = 'movimentos.csv';
        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'Código Cliente', 'Valor Total', 'Valor Líquido', 'Situação', 'Categoria',
            'CPF/CNPJ', 'Pessoa', 'Observações', 'Data Vencimento', 'Data Baixa',
            'Data Entrada/Saída', 'Forma de Pagamento', 'Natureza'
        ]);


        foreach ($movimentos as $mov) {
            fputcsv($handle, [
                $mov->movb_codclie,
                $mov->movb_valortotal,
                $mov->movb_valorliquido,
                $mov->movb_situacao,
                $mov->movb_categoria,
                $mov->movb_cpfpj,
                $mov->movb_pessoa,
                $mov->movb_observ,
                $mov->movb_datavenc,
                $mov->movb_databaixa,
                $mov->movb_dataes,
                $mov->movb_forma,
                $mov->movb_natureza,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
