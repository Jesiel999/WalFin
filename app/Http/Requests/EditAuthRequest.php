<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;

class EditAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = (int) Cookie::get('user_id');

        return [
            "usua_nome" => [
                "required",
                "string",
                "max:255",
            ],
            "usua_cpfpj" => [
                "required",
                "digits_between:10,18",
                Rule::unique('usuario', 'usua_cpfpj')->ignore($userId, 'usua_codigo'),
            ],
            "usua_email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique('usuario', 'usua_email')->ignore($userId, 'usua_codigo'),
            ],
            "usua_telefone" => [
                "required",
                "digits_between:10,11",
                Rule::unique('usuario', 'usua_telefone')->ignore($userId, 'usua_codigo'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required'       => 'O campo :attribute é obrigatório.',
            'digits_between' => 'O campo :attribute deve ter de :min a :max dígitos.',
            'unique'         => 'Já existe um usuário cadastrado com este :attribute.',
            'email'          => 'O campo :attribute deve ser um e-mail válido.',
        ];
    }
}
