<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }
    public function rules(): array {
        return [
            'cat_codclie'   => 'nullable|integer',
            'cat_nome'      => 'required|string|max:45',   
            'cat_icone'     => 'required|string|max:20',   
        ];
    }

    public function messages(): array {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser um texto.',
            'max'      => 'O campo :attribute não pode exceder :max caracteres.',
        ];
    }
}
?>