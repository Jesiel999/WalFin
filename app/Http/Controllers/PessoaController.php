<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use Exception;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller
{
    // CADASTRO
    public function store(PessoaRequest $request)
    {
        try {
            $dados = $request->validated();

            $userId = Auth::id();
            
            $dados['pes_codclie'] = $userId;

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
        
        $userId = Auth::id();

        $pessoas = Pessoa::with('pessoa')
        ->where('pes_codclie', $userId)
        ->orderBy('pes_codigo','asc')
        ->get();
        
        return view("pages.pessoa", compact("pessoas"));
    }

    /* BUSCAR */
    public function buscar(Request $request) {
        $q = $request->input('q');

        $pessoas = Pessoa::where('pes_nome', 'LIKE', "%$q%")
            ->orWhere('pes_cpfpj', 'LIKE', "%$q%")
            ->limit(10)
            ->get(['pes_codigo', 'pes_nome', 'pes_cpfpj']);

        return response()->json($pessoas);
    }

    /* UPDATE BUSCAR */
    public function buscarUpdate(Request $request) {
        $q = $request->input('q');

        $pessoas = Pessoa::where('pes_nome', 'LIKE', "%$q%")
            ->orWhere('pes_cpfpj', 'LIKE', "%$q%")
            ->limit(10)
            ->get(['pes_codigo', 'pes_nome', 'pes_cpfpj']);

        return response()->json($pessoas);
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
