<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'movb_codclie'      => 'nullable|integer',
            'movb_codigo'       => 'nullable|integer',
            'movb_valortotal'   => 'nullable|numeric',
            'movb_valorliquido' => 'nullable|numeric',
            'movb_situacao'     => 'nullable|string',
            'movb_categoria'    => 'nullable|numeric',
            'movb_cpfpj'        => 'nullable|numeric',
            'movb_pessoa'       => 'nullable|string',
            'movb_observ'       => 'nullable|string',
            'movb_datavenc'     => 'nullable|date',
            'movb_databaixa'    => 'nullable|date',
            'movb_dataes'       => 'nullable|date',
            'movb_forma'        => 'nullable|numeric',
            'movb_natureza'     => 'nullable|string',
        ] ;
    }

    public function messages(): array{
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve estar em formato válido (YYYY-MM-DD).',
            'string'   => 'O campo :attribute deve ser um texto.',
        ] ;
    }
}
?>