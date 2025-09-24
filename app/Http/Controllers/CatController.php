<?php

namespace App\Http\Controllers;

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


   
      public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'cat_codclie'   => 'nullable|integer',
            'cat_nome'      => 'required|string|max:45',   
            'cat_icone'     => 'required|string|max:20',   
        ],[
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser um texto.',
            'max'      => 'O campo :attribute não pode exceder :max caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Categoria::create([
                'cat_codclie'   => $request->cookie('user_id'),
                'cat_nome'      => $request->cat_nome,
                'cat_icone'     => $request->cat_icone,
            ]);

            return redirect()
                ->route('categorias')
                ->with('success', 'Categoria cadastrada com sucesso!');

        } catch (Exception $e) {
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
