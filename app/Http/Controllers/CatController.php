<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categoria;
use Exception;

class CatController extends Controller
{
    public function exibir()
    {
        $categorias = Categoria::where('cat_codclie', request()->cookie('user_id'))
            ->orderBy('cat_codigo', 'asc')
            ->get();

        return view('pages.categorias', compact('categorias'));
    }
   
    public function store(CatRequest $request)
    {       
        try {
            $dados = $request->validated();

            $dados['cat_codclie'] = $request->cookie('user_id');

            Categoria::create($dados);

            return redirect()
                ->route('categorias')
                ->with('success', 'Categoria cadastrada com sucesso!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao salvar categoria: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $cat_codigo)
    {
        $categorias = Categoria::findOrFail($cat_codigo);
        $categorias->update($request->all());

        return redirect()->route('categorias')->with('success', 'Categoria atualizada com sucesso !');
    }
    
    public function destroy($cat_codigo)
    {
        $categorias = Categoria::findOrFail($cat_codigo);
        $categorias->delete();

        return redirect()->route('categorias')->with('success', 'Categoria excluída com sucesso');
    }
}
