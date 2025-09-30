<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use Exception;
class PessoaController extends Controller
{
    // CADASTRO
    public function store(PessoaRequest $request)
    {
        try {
            $dados = $request->validated();

            $dados['pes_codclie'] = $request->cookie('user_id');

            Pessoa::create($dados);

            return redirect()
                ->route("pessoa")
                ->with('success','Pessoa cadastrada com sucesso!');

        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao salvar Pessoa: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // LISTAR
    public function exibir() {
    
        $pessoas = Pessoa::with('pessoa')
        ->where('pes_codclie', request()->cookie('user_id'))
        ->orderBy('pes_codigo','asc')
        ->get();
        
        return view("pages.pessoa", compact("pessoas"));
    }

    // ALTERAR
    public function update(PessoaRequest $request, $pes_codigo) 
    {

        $pessoas = Pessoa::findOrFail($pes_codigo);
        $pessoas->update($request->validated());

        return redirect()
         ->route("pessoa")
         ->with("success","Pessoa atualizada com sucesso !");
    }

    // DELETE
    public function destroy($pes_codigo)
    {
        $pessoas = Pessoa::findOrFail($pes_codigo);
        $pessoas->delete();

        return redirect()
            ->route("pessoa")
            ->with("success","Pessoa excluída com sucesso !");
    }
}
