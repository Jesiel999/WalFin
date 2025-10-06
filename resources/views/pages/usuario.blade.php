@extends('layouts.app')

@section('extra-scripts')
    <script type="module" src="{{Vite::asset('resources/js/modals/usuario.js')}}"></script>
@endsection
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
            </div>
        </div>
    </div>
</div>
@include('pages.modals.usuario.editsenha')
@include('pages.modals.usuario.editusuario')
@endsection

@section('footer')
@endsection
