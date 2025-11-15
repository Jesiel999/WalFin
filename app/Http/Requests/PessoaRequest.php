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
            "pes_cpfpj"=> "nullable|numeric",
            "pes_email"=> "nullable|email",
            "pes_telefone"=> "nullable|integer|digits_between:10,11",
            "pes_observacao"=> "nullable|string", 
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
            'unique'   => 'O :attribute já está cadastrado.',
            'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
        ];
    }
}
