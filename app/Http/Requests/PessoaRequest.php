<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "pes_codclie"=> "nullable|integer",
            "pes_nome"=> "required|string",
            "pes_cpfpj"=> "required|numeric",
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve estar em formato válido (YYYY-MM-DD).',
            'string'   => 'O campo :attribute deve ser um texto.',
        ];
    }
}
