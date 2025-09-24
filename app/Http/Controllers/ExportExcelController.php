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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'Nenhum arquivo enviado.');
        }

        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        if (!$handle) {
            return back()->with('error', 'Não foi possível abrir o arquivo.');
        }

        $header = fgetcsv($handle, 1000, ';');
        $errors = [];
        $linhasImportadas = 0;

        while (($data = fgetcsv($handle, 1000, ';')) !== false) {
            if (count($data) < 13) {
                $errors[] = "Linha ".implode(',', $data)." ignorada: menos de 13 colunas.";
                continue;
            }
            if (empty($data[1])) {
                $errors[] = "Linha ".implode(',', $data)." ignorada: Valor Total vazio.";
                continue;
            }

            try {
                Movimento::create([
                    'movb_codclie'      => $request->cookie('user_id') ?? 0,
                    'movb_valortotal'   => floatval(str_replace(',', '.', str_replace('"', '', $data[1]))),
                    'movb_valorliquido' => floatval(str_replace(',', '.', str_replace('"', '', $data[2] ?? 0))),
                    'movb_situacao'     => $data[3] ?? null,
                    'movb_categoria'    => $data[4] ?? null,
                    'movb_cpfpj'        => preg_replace('/[^0-9]/', '', $data[5] ?? ''),
                    'movb_pessoa'       => $data[6] ?? null,
                    'movb_observ'       => $data[7] ?? null,
                    'movb_datavenc'     => !empty($data[8]) ? date('Y-m-d', strtotime(str_replace('/', '-', $data[8]))) : null,
                    'movb_databaixa'    => !empty($data[9]) ? date('Y-m-d', strtotime(str_replace('/', '-', $data[9]))) : null,
                    'movb_dataes'       => !empty($data[10]) ? date('Y-m-d', strtotime(str_replace('/', '-', $data[10]))) : null,
                    'movb_forma'        => $data[11] ?? null,
                    'movb_natureza'     => $data[12] ?? null,
                ]);
                $linhasImportadas++;
            } catch (\Exception $e) {
                $errors[] = "Erro na linha ".implode(',', $data).": ".$e->getMessage();
            }
        }

        fclose($handle);

        $msg = "$linhasImportadas linhas importadas com sucesso.";
        if (count($errors) > 0) {
            return back()->with(['success' => $msg, 'errors' => $errors]);
        }

        return back()->with('success', $msg);
    }

}
