<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function rules(): array
    {
        return [
            'par_codclie'   => 'nullable|integer',
            'par_codigomov'    => 'nullable|integer',
            'par_valor'    => 'nullable|decimal',
            'par_numero'    => 'nullable|integer',
            'par_qtnumero'  => 'nullable|integer',
            'par_datavenc'  => 'nullable|integer',
            'par_databaixa' => 'nullable|integer',
            'par_situacao'  => 'nullable|integer',
        ];
    }
    public function messages(): array {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve estar em formato válido (YYYY-MM-DD).',
            'string'   => 'O campo :attribute deve ser um texto.',
        ];
    }
}
