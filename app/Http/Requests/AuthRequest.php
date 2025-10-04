<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
   
    public function rules(): array
    {
        return [
            "nome"=> "required|string|max:255",
            "cpf_pj"=> "required|digits_between:10,18|unique:usuario,usua_cpfpj",
            "email"=> "required|string|email|max:255|unique:usuario,usua_email",
            "telefone"=> "required|digits_between:10,11|unique:usuario,usua_telefone",
            "senha"=> "required|string|min:4|confirmed",
        ];
    }

    public function messages(): array
    {
        return [
            'required'          => 'O campo :attribute é obrigatório.',
            'digits_between'    => 'O campo :attribute deve ter de 10 a 18 dígitos.',
            'unique'            => 'Já existe um usuário cadastrado com este :attribute.',
            'confirmed'         => 'As senhas são diferentes.',
            'email'             => 'O campo :attribute deve ser um E-mail válido.',
        ];
    }
}