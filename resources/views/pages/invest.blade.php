@extends('layouts.invest')

@section('title', 'Investimentos')

@section('header')
@endsection

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Investimentos</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-500 uppercase tracking-wide text-sm">Total Investido</p>
                <h2 class="text-3xl font-bold text-green-500 mt-1">
                    R$ {{ number_format($totalInvestido, 2, ',', '.') }}
                </h2>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-wallet text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-sm text-gray-500">+00% em rendimento da carteira.</p>
    </div>
    <div class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all ">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-500 uppercase tracking-wide text-sm">Média de Investimento Anual</p>
                <h2 class="text-3xl font-bold text-blue-500 mt-1">
                    R$ {{ number_format($mediaInvestimentoMensal, 2, ',', '.') }}
                </h2>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-coins text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-sm text-gray-500">+00% em relação ao mês passado</p>
    </div>
    <div class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-500 uppercase tracking-wide text-sm">Total Resgatado</p>
                <h2 class="text-3xl font-bold text-red-500 mt-1">
                    R$ {{ number_format($totalResgatado, 2, ',', '.') }}
                </h2>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <i class="fas fa-hand-holding-usd text-red-600 text-xl"></i>
            </div>
        </div>
        <p class="text-sm text-gray-500">+00% em relação ao mês passado</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="rounded-xl bg-white shadow-sm p-3 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Entradas e Saídas</h3>
            <select>
                <option>Últimos 6 meses</option>
                <option>Este ano</option>
                <option>Ano passado</option>
            </select>
        </div>
        <div class="h-64">
            <canvas id="AporteResgate"></canvas>
        </div>
    </div>

    <div class="rounded-xl bg-white shadow-sm p-3 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Receitas vs Despesas Baixado</h3>
            <select>
                <option>Últimos 6 meses</option>
                <option>Este ano</option>
                <option>Ano passado</option>
            </select>
        </div>
        <div class="h-64">
            <canvas id="EvolucaoAportes"></canvas>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="bg-white shadow-inner p-3 flex flex-col justify-between overflow-y-auto h-80">
        
            <h3 class="font-semibold text-lg text-gray-700">Top 10 Criptos</h3>
            
            <div id="top-cripto" class="text-lg text-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="nome text-1xl font-bold text-gray-500"></h1>
                    <h2 class="valor text-1xl font-semibold text-gray-800"></h2>
                </div>
            </div>
        </div>            
    </div>
    <div class="flex flex-col">
        <div class="bg-white shadow-inner p-3 flex flex-col justify-between overflow-y-auto h-80">
        
            <h3 class="font-semibold text-lg text-gray-700">Top 5 Ativos</h3>
            
            <div id="top-ativos" class="text-lg text-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="nome text-1xl font-bold text-gray-500"></h1>
                    <h2 class="valor text-1xl font-semibold text-gray-800"></h2>
                </div>
            </div>
        </div>   
    </div>         
</div>
    
@endsection