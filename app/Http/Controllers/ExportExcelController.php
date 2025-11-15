<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController extends Controller
{
    public function export()
    {
        $userId = Auth::id();

        $movimentos = Movimento::where('movb_codclie', $userId)
            ->leftJoin('pessoa', 'mov_bancario.movb_pessoa', '=', 'pessoa.pes_codigo')
            ->select('mov_bancario.*', 'pessoa.pes_nome')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalhos
        $sheet->fromArray([
            ['Valor Total', 'Valor Líquido', 'Situação', 'Categoria', 'CPF/CNPJ', 'Pessoa', 'Observações', 'Data Vencimento', 'Data Baixa', 'Data Entrada/Saída', 'Forma de Pagamento', 'Natureza']
        ], NULL, 'A1');

        $row = 2;

        foreach ($movimentos as $mov) {
            $sheet->setCellValue("A$row", $mov->movb_valortotal);
            $sheet->setCellValue("B$row", $mov->movb_valorliquido);
            $sheet->setCellValue("C$row", $mov->movb_situacao);
            $sheet->setCellValue("D$row", $mov->movb_categoria);
            $sheet->setCellValue("E$row", $mov->movb_cpfpj);
            $sheet->setCellValue("F$row", $mov->pes_nome ?? 'Não informado');
            $sheet->setCellValue("G$row", $mov->movb_observ);
            $sheet->setCellValue("H$row", $this->format($mov->movb_datavenc));
            $sheet->setCellValue("I$row", $this->format($mov->movb_databaixa));
            $sheet->setCellValue("J$row", $this->format($mov->movb_dataes));
            $sheet->setCellValue("K$row", $mov->movb_forma);
            $sheet->setCellValue("L$row", $mov->movb_natureza);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'movimentos.xlsx');
    }

    private function format($date)
    {
        return $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '';
    }
}
