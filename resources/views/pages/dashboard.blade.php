@extends('layouts.dash')

@section('title', 'Dashboard')

@section('header')
@endsection

@section('content')
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500">Saldo Atual</p>
                    <h2 class="text-3xl font-bold text-green-500">
                        R$ {{ number_format($saldoAtual, 2, ',', '.') }}
                    </h2>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-wallet text-green-600" style="font-size: 1.25rem;"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">{{ number_format($evolucaoPercentual, 2, ',', '.') }}% em relação ao mês passado</p>
        </div>

        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500">Receitas</p>
                    <h2 class="text-3xl font-bold text-blue-500">
                        R$ {{ number_format($totalReceitas, 2, ',', '.') }}
                    </h2>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-arrow-down text-blue-600" style="font-size: 1.25rem;"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">R$ {{ number_format($mesReceita, 2, ',', '.') }} receita mês atual </p>
        </div>

        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500">Despesas</p>
                    <h2 class="text-3xl font-bold text-red-500">
                        R$ {{ number_format($totalDespesas, 2, ',', '.') }}
                    </h2>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-arrow-up text-red-600" style="font-size: 1.25rem;"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500">R$ {{ number_format($mesDespesa, 2, ',', '.') }} despesa mês atual</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-lg">Receitas vs Despesas Pagos</h3>
                <select>
                    <option>Últimos 6 meses</option>
                    <option>Este ano</option>
                    <option>Ano passado</option>
                </select>
            </div>
            <div class="h-64">
                <canvas id="DespesasXReceitaBaixado"></canvas>
            </div>
        </div>

        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-lg">Despesas por Categoria Pagos</h3>
                <select>
                    <option>Este mês</option>
                    <option>Mês passado</option>
                    <option>Últimos 3 meses</option>
                </select>
            </div>
            <div class="h-64">
                <canvas id="DespesasBaixadoporCategoria"></canvas>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-lg">Receitas vs Despesas Pendentes</h3>
                <select>
                    <option>Últimos 6 meses</option>
                    <option>Este ano</option>
                    <option>Ano passado</option>
                </select>
            </div>
            <div class="h-64">
                <canvas id="DespesasXReceitaPendente"></canvas>
            </div>
        </div>

        <div class="card p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-lg">Evolução do Saldo Acumulado</h3>
                <select>
                    <option>Últimos 6 meses</option>
                    <option>Mês passado</option>
                    <option>Últimos 3 meses</option>
                </select>
            </div>
            <div class="h-64">
                <canvas id="DespesasXReceitaEvolucao"></canvas>
            </div>
        </div>
    </div>
@endsection