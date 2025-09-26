<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CondPagamentoRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'copa_codclie'   => 'nullable|integer',
            'copa_nome'      => 'required|string|max:255',
            'copa_desc'      => 'nullable|string',
            'copa_tipo'      => 'required|string', 
            'copa_intervalo' => 'nullable|integer',
            'copa_parcelas'  => 'nullable|integer',
            'copa_status'    => 'nullable|integer|max:1',
        ];
    }
    public function messages(): array {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'string'   => 'O campo :attribute deve ser um texto.',
        ];
    }
}
?>