@extends('layouts.acesso')

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="bg-white bg-opacity-90 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md">
    <a href="{{ route('home') }}" 
        class="absolute top-4 right-4 bg-gray-400 hover:bg-gray-500 text-white px-3 py-1.5 rounded shadow-lg transition-transform duration-200 hover:scale-105">
        ✕
    </a>

    <form method="post" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="cpf_pj" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">CPF/PJ:</label>
            <input type="text" name="cpf_pj" id="cpf_pj" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Digite seu CPF ou CNPJ">
            <input type="hidden" name="cpf_pj" id="cpfpjHidden">
        </div>

        <div>
            <label for="senha" class="block text-sm font-semibold text-gray-700 mb-1">Senha</label>
            <input type="password" name="senha" id="senha"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="Digite sua senha" required>
        </div>

        @if ($errors->has('login'))
            <div class="text-sm text-red-500">{{ $errors->first('login') }}</div>
        @endif

        <div class="mt-6 text-center">
            <input type="submit" name="Login" value="Entrar"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition">
        </div>
    </form>
    <div class="text-center mt-5">
        <a href="{{ route('cadastro') }}" 
            class="w-full bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded shadow-lg transition-transform duration-200 hover:scale-105">
            Cadastro de Usuário
        </a>
        <a href="{{ route('recuperarSenha') }}" class="w-full text-sm text-blue-600 hover:underline mt-2 inline-block">
            Esqueceu sua senha?
        </a>
    </div>
    
</div>
@endsection

@section('footer')
@endsection

