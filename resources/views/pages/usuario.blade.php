@extends('layouts.app')

@section('title', 'Usuário')

@section('header')
@endsection

@section('sidebar')
@endsection

@section('content')
<div id="usuario" class="flex flex-col lg:flex-row gap-8">
    <div class="w-full lg:w-1/3 space-y-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <div class="border-b border-gray-200 p-4 flex flex-row justify-between">
                <h1 class="text-lg font-semibold text-gray-800">Informações Pessoais</h1>
                <button id="editarUser" class="display:none text-yellow-500">Editar</button>
            </div>
            <div class="p-4 space-y-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-envelope text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="font-medium">{{$userEmail}}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Telefone</p>
                        <p id="cpf_pj" class="font-medium">{{$userFone}}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">CPF PJ</p>
                        <p class="font-medium">{{$userCpfpj}}</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('logout') }}" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition flex items-center justify-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
            @csrf
        </form>

        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <div class="border-b border-gray-200 p-4">
                <h2 class="text-lg font-semibold text-gray-800">Segurança</h2>
            </div>
            <div class="p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-green-500 mr-3"></i>
                        <span>Autenticação de dois fatores</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-bell text-yellow-500 mr-3"></i>
                        <span>Notificações por email</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-mobile-alt text-purple-500 mr-3"></i>
                        <span>Notificações por SMS</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <button id="alterar-senha"class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-key mr-2"></i> Alterar Senha
                </button>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-2/3 space-y-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800">Visão Geral da Conta</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Saldo Disponível</p>
                                <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-wallet text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Investimentos</p>
                                <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Rendimento Mensal</p>
                                <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-coins text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Metas Financeiras</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Reserva de Emergência</span>
                                <span class="text-sm font-medium text-gray-700">75%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">R$ 15.000 de R$ 20.000</p>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Viagem Internacional</span>
                                <span class="text-sm font-medium text-gray-700">32%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: 32%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">R$ 6.400 de R$ 20.000</p>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Entrada do Apartamento</span>
                                <span class="text-sm font-medium text-gray-700">18%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-600 h-2.5 rounded-full" style="width: 18%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">R$ 9.000 de R$ 50.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alterar-senha-modal" class="fixed inset-0 bg-black bg-opacity-50 max-w-1x1 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-mdw-full relative">
            <button id="closed-alterar-senha-modal"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2x1 font-bold">
                &times;
            </button>
            <div class="flex justify-between">
                <h2 class="text-lg font-bold mb-4">Alterar Senha</h2>
            </div>
             <form method="POST" action="{{ route('usuario.updateSenha') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium">Senha Atual</label>
                    <input type="password" name="senha_atual" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Nova Senha</label>
                    <input type="password" name="nova_senha" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Confirmar Nova Senha</label>
                    <input type="password" name="nova_senha_confirmation" class="w-full border rounded px-3 py-2" required>
                </div>

                <button type="button" id="cancel-alterar-senha-modal" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Alterar Senha
                </button>
            </form>
        </div>
    </div>
</div>

<div id="usuario-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">
        
        <button id="closed-usuario-modal"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
        &times;
        </button>

        <h2 class="text-lg font-bold mb-4">Editar usuário</h2>

        <form method="POST" action="{{ route('usuario.edit') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Nome:</label>
                        <input type="text" step="0.01" name="usua_nome" value="{{$userName}}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF/PJ:</label>
                        <input type="text" step="0.01" name="usua_cpfpj" value="{{ $userCpfpj }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Telefone:</label>
                        <input type="text" step="0.01" name="usua_telefone" value="{{ $userFone }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Email:</label>
                        <input type="email" step="0.01" name="usua_email" value="{{ $userEmail }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-usuario-modal" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    /* Alterar Senha */
    document.getElementById('alterar-senha').addEventListener('click', function() {
        document.getElementById('alterar-senha-modal').classList.remove('hidden');
    });
    document.getElementById('closed-alterar-senha-modal').addEventListener('click', function() {
        document.getElementById('alterar-senha-modal').classList.add('hidden');
    });
    document.getElementById('cancel-alterar-senha-modal').addEventListener('click', function() {
        document.getElementById('alterar-senha-modal').classList.add('hidden');
    });

    /* Editar Usuario */
    document.getElementById('editarUser').addEventListener('click', function() {
        document.getElementById('usuario-modal').classList.remove('hidden');
    });
    document.getElementById('closed-usuario-modal').addEventListener('click', function() {
        document.getElementById('usuario-modal').classList.add('hidden');
    });
    document.getElementById('cancel-usuario-modal').addEventListener('click', function() {
        document.getElementById('usuario-modal').classList.add('hidden');
    });
</script>
@endsection

@section('footer')
@endsection
