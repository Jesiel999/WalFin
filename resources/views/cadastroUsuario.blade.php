@extends('layouts.acesso')

@section('title', 'Cadastro de usuário')

@section('header')
@endsection

@section('content')
<div class="bg-white bg-opacity-90 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md">
  <a href="{{ route('login') }}" 
      class="absolute top-4 right-4 bg-gray-400 hover:bg-gray-500 text-white px-3 py-1.5 rounded shadow-lg transition-transform duration-200 hover:scale-105">
    ✕
  </a>

  <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Cadastro de Usuário</h2>

  <form method="POST" enctype="multipart/form-data" action="{{ route('cadastro') }}" class="space-y-5">
    @csrf

    <div>
      <label for="nome" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">Nome:</label>
      <input type="text" name="nome" id="nome" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Nome">
    </div>

    <div>
      <label for="cpf_pj" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">CPF/PJ:</label>
      <input type="text" name="cpf_pj" id="cpf_pj" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Digite seu CPF ou CNPJ">
      <input type="hidden" name="cpf_pj" id="cpfpjHidden">
    </div>

    <div>
      <label for="telefone" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">Telefone:</label>
      <input type="text" id="telefone" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Digite seu Telefone">
      <input type="hidden" name="telefone" id="telefoneHidden">
    </div>

    <div>
      <label for="email" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">E-mail:</label>
      <input type="text" name="email" id="email" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Digite seu E-mail">
    </div>

    <div>
      <label for="senha" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">Senha:</label>
      <input type="password" name="senha" id="senha" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Senha">
    </div>

    <div>
      <label for="senha_confirmation" class="block text-sm font-semibold text-gray-700 mt-4 mb-1">Confirme a Senha:</label>
      <input type="password" name="senha_confirmation" id="senha_confirmation" required 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
            placeholder="Repita a senha">
    </div>

    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif  

    <div class="flex justify-end">
      <input type="submit" value="Cadastrar" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow-md transition duration-200">
    </div>
  </form>
</div>
@endsection

@section('footer')
@endsection