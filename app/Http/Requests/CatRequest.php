<?php 

namespace App\Http\Requests;

class CatRequest extends Request {
    public function authorize(Request $request)  {

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
    }
}
?>