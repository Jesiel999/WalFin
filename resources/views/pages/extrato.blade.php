@extends('layouts.app')

@section('title', 'Extrato')

@section('header')
@endsection

@section('content')
<section id="movimentacoes" class="section-content">
    <div class="bg-white rounded-xl shadow-sm p-4 lg:p-8 w-full  text-base lg:text-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Transações</h2>
            <button id="add-transacoes-btn" 
                class="bg-indigo-600 text-white px-8 py-6 text-lg lg:px-3 lg:py-2 lg:text-sm rounded-lg hover:bg-indigo-700 transition flex items-center font-bold">
                <i class="fas fa-plus mr-2"></i> Nova Transação
            </button> 
        </div>
  
        <form id="form-filtros" method="GET" action="{{ route('extrato') }}" 
            class="grid grid-cols-1 gap-4 mb-6 lg:grid-cols-4">

            <input type="text" name="search" placeholder="Pesquisar..." 
                value="{{ request('search') }}"
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">

            <select name="categoria" 
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">
                <option value="">Todas as categorias</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->cat_codigo }}" {{ request('categoria') == $categoria->cat_codigo ? 'selected' : '' }}>
                        {{ $categoria->cat_nome }}
                    </option>
                @endforeach
            </select>

            <select name="natureza" 
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">
                <option value="">Todos os tipos</option>
                <option value="Receita" {{ request('natureza') == 'Receita' ? 'selected' : '' }}>Receita</option>
                <option value="Despesa" {{ request('natureza') == 'Despesa' ? 'selected' : '' }}>Despesa</option>
            </select>

            <select name="situacao" 
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">
                <option value="">Todas as situações</option>
                <option value="Pago" {{ request('situacao') == 'Pago' ? 'selected' : '' }}>Pago</option>
                <option value="Pendente" {{ request('situacao') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
            </select>

            <input type="date" name="data_inicio" value="{{ request('data_inicio') }}"
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 min-w-full focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">

            <input type="date" name="data_fim" value="{{ request('data_fim') }}"
                class="border rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 min-w-full focus:ring-indigo-500 lg:px-3 lg:py-2 lg:text-base">

            <button type="submit" 
                class="bg-indigo-600 text-white px-6 py-3 text-lg rounded-lg hover:bg-indigo-700 transition lg:px-4 lg:py-2 lg:text-base">
                Filtrar
            </button>
            
            <button type="button" id="btn-limpar" 
                class="bg-gray-500 text-white px-6 py-3 text-lg rounded-lg hover:bg-gray-600 transition lg:px-4 lg:py-2 lg:text-base">
                <i class="fas fa-times-circle mr-2"></i> Limpar Filtros
            </button>
        </form>

        <div class="w-full overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider hidden lg:table-cell">Data de E/S</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider">Pessoa</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider hidden lg:table-cell">Tipo</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider">Situação</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider hidden lg:table-cell">Categoria</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider hidden lg:table-cell">Pagamento</th>
                        <th class="px-6 py-3 text-center text-left text-base font-semibold uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($movimentos as $mov)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-2 text-center text-gray-600 font-medium hidden lg:table-cell">
                                {{ \Carbon\Carbon::parse($mov->movb_dataes)->format('d/m/Y') }}
                            </td>
                            <td class="px-2 py-2 lg:px-6 text-wrap text-center text-gray-700">{{ $mov->movb_pessoa }}</td>
                            <td class="px-6 py-2 hidden text-center lg:table-cell">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $mov->movb_natureza === 'Receita' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $mov->movb_natureza }}
                                </span>
                            </td>
                            <td class="px-2 py-2 lg:px-6 text-center">
                                <span class="px-3 py-1 lg:text-xs text-base font-bold rounded-full
                                    {{ $mov->movb_situacao === 'Pago' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ $mov->movb_situacao }}
                                </span>
                            </td>
                            <td class="px-6 py-2 hidden lg:table-cell text-center">
                                <span class="px-6 py-4 text-gray-700 font-bold">
                                    {{ $mov->categoria->cat_nome }}
                                </span>
                            </td>
                            <td class="px-2 py-2 lg:px-6 text-base text-center font-bold">
                                R$ {{ number_format($mov->movb_valorliquido, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-2 hidden lg:table-cell text-center">{{ $mov->condpagamento->copa_nome }}</td>
                            <td class="px-2 py-2 lg:px-6 flex space-x-2 flex items-center justify-center space-x-2">
                                @if($mov->condpagamento->copa_parcelas > 1)
                                    <button type="button" 
                                        class="parcelamento px-5 py-3 text-base lg:px-3 lg:py-2 lg:text-sm border rounded-lg bg-yellow-300 text-gray-700 hover:bg-yellow-400"
                                        data-id="{{ $mov->movb_codigo }}"
                                        >
                                        Parcelas
                                    </button>
                                @endif
                                <button
                                    type="button"
                                    class="edit-transacao-btn px-5 py-3 text-base lg:px-3 lg:py-2 lg:text-sm bg-indigo-500 text-white text-xs rounded-lg hover:bg-indigo-600 transition"
                                    data-id="{{ $mov->movb_codigo }}"
                                    data-valortotal="{{ $mov->movb_valortotal }}"
                                    data-valorliquido="{{ $mov->movb_valorliquido }}"
                                    data-cpfpj="{{ $mov->movb_cpfpj }}"
                                    data-pessoa="{{ $mov->movb_pessoa }}"
                                    data-situacao="{{ $mov->movb_situacao }}"
                                    data-categoria="{{ $mov->movb_categoria }}"
                                    data-datavenc="{{ $mov->movb_datavenc ? \Illuminate\Support\Carbon::parse($mov->movb_datavenc)->format('Y-m-d') : '' }}"
                                    data-databaixa="{{ $mov->movb_databaixa ? \Illuminate\Support\Carbon::parse($mov->movb_databaixa)->format('Y-m-d') : '' }}"
                                    data-forma="{{ $mov->movb_forma }}"
                                    data-natureza="{{ $mov->movb_natureza }}"
                                    data-observ="{{ $mov->movb_observ }}"
                                    data-parcela="{{ $mov->condpagamento->copa_parcelas}}"
                                >
                                    Editar
                                </button>
                                <button type="button" class="add-transacoes-exclui px-5 py-3 text-base lg:px-3 lg:py-2 lg:text-sm border rounded-lg bg-red-600 text-gray-100 hover:bg-red-700"
                                data-id="{{ $mov->movb_codigo }}"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500 italic">
                                Nenhum movimento encontrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 flex items-center justify-end gap-4">
                <a   href="{{ url('/extratoExportExcel') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center mt-4">
                    <i class="fas fa-file-export mr-2"></i> Export Excel
                </a> 
                <button   id="add-import-btn" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center mt-4">
                    <i class="fas fa-file-import mr-2"></i> Import Excel
                </button> 
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div>
                    Mostrando {{ $movimentos->firstItem() }} até {{ $movimentos->lastItem() }}
                    de {{ $movimentos->total() }} movimentações
                </div>

                <div>
                    {{ $movimentos->links() }}
                </div>
            </div>
        </div>
        <div id="transacoes-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-md 
                        w-[95%] max-w-4xl max-h-[90vh] 
                        overflow-y-auto relative">

                <button id="close-transacoes-modal" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <h2 class="text-lg font-bold mb-4">Cadastro de Nova Transação</h2>

                <form method="POST" action="{{ route('cadastroMov') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Total</label>
                                <input type="number" step="0.01" name="movb_valortotal" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Líquido</label>
                                <input type="number" step="0.01" name="movb_valorliquido" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            </div>  

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF ou CNPJ</label>
                                <input type="text" name="movb_cpfpj" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Pessoa</label>
                                <input type="text" name="movb_pessoa" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                                <select name="movb_situacao" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                                    <option value="">Selecione</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Pago">Pago</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Categoria</label>
                                <select id="movb_categoria" name="movb_categoria" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->cat_codigo }}">{{ $categoria->cat_nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="extra-div" class="hidden mt-4 p-4 border border-indigo-500 rounded-lg bg-indigo-50">
                               <input type="hidden" id="tipo_invest" name="movb_tipoinvestimento">

                                <div id="invest" class="flex flex-wrap gap-4">
                                    <div id="cripto" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                        onclick="selecionarInvestimento('cripto', event)">
                                        <i class="fas fa-coins text-gray-600 text-base"></i>
                                        <p class="font-base">Cripto</p>
                                    </div>
                                    <div id="renda-fixa" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                        onclick="selecionarInvestimento('renda-fixa', event)">
                                        <i class="fas fa-university text-gray-600 text-base"></i>
                                        <p class="font-base">Renda Fixa</p>
                                    </div>
                                    <div id="acao" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                        onclick="selecionarInvestimento('acao', event)">
                                        <i class="fas fa-chart-line text-gray-600 text-base"></i>
                                        <p class="font-base">Bolsa</p>
                                    </div>
                                    <div id="fundos" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                        onclick="selecionarInvestimento('fundos', event)">
                                        <i class="fas fa-piggy-bank text-gray-600 text-base"></i>
                                        <p class="font-base">Fundos</p>
                                    </div>
                                </div>

                                <div id="investimentos" 
                                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 max-h-[10vh] overflow-y-auto">
                                </div>
                            </div>
                        </div>                        

                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                                <input type="date" name="movb_datavenc" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Data de Baixa</label>
                                <input type="date" name="movb_databaixa" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Forma</label>
                                <select name="movb_forma" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                                    <option value="">Selecione</option>
                                    @foreach($cond_pagamento as $cond)
                                        <option value="{{ $cond->copa_codigo }}">{{ $cond->copa_nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Natureza</label>
                                <select name="movb_natureza" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                                    <option value="">Selecione</option>
                                    <option value="Receita">Receita</option>
                                    <option value="Despesa">Despesa</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Observação</label>
                                <textarea name="movb_observ" rows="4" 
                                        class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancel-transacoes" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="transacoes-edit" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

                <button id="close-transacoes-edit" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <div class="flex justify-between">
                    <h2 class="text-lg font-bold mb-4">Editar Transação</h2>
                    <h2 class="text-lg font-bold mb-4 mr-5">Código: <input id="edit-codigo" step="0.01" name="movb_codigo"/></h2>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Total</label>
                                <input type="number" step="0.01" name="movb_valortotal" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Líquido</label>
                                <input type="number" step="0.01" name="movb_valorliquido" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>  

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF ou CNPJ</label>
                                <input type="text" name="movb_cpfpj" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Pessoa</label>
                                <input type="text" name="movb_pessoa" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                                <select name="movb_situacao" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Pago">Pago</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Categoria</label>
                                <select id="movb_categoria" name="movb_categoria" 
                                class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->cat_codigo }}">{{ $categoria->cat_nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="extra-div" class="hidden mt-4 p-4 border rounded-lg bg-gray-100">
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Investimento</label>
                                <input type="text" name="info_extra" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                                <input type="date" name="movb_datavenc" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Data de Baixa</label>
                                <input type="date" name="movb_databaixa" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div class="hidden">
                                <label class="block text-sm font-medium">Qt parcelas</label>
                                <input type="text" name="copa_parcelas" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Forma</label>
                                <select name="movb_forma" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    @foreach($cond_pagamento as $cond)
                                        <option value="{{ $cond->copa_codigo }}">{{ $cond->copa_nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Natureza</label>
                                <select name="movb_natureza" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    <option value="Receita">Receita</option>
                                    <option value="Despesa">Despesa</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Observação</label>
                                <textarea name="movb_observ" rows="4" 
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-4">                     
                        <button type="button" id="cancel-transacoes-edit" 
                        class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                            Cancelar
                        </button>
                        <button type="submit" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="confirm-exclui" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

                <button id="close-transacoe-exclui" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <div class="flex justify-between">
                    <h2 class="text-lg font-bold mb-4">Excluir movimentação</h2>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="flex align-center">
                        <div>
                            <div>
                                <h1 class="text-gray-700 text-lg font-bold mb-2">Você realmente deseja excluir essa movimentação ?</h1>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" id="cancel-transacoes-exclui" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="parcelamento-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

                <button id="close-parcelamento" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <h2 class="text-lg font-bold mb-4">Parcelamento da Movimentação</h2>
                <h2 class="text-lg font-bold mb-4 mr-5">
                    Código: <span id="codigo-mov"></span>
                    <input type="hidden" name="movb_codigo">
                </h2>
                <div id="parcelas-lista" class="mt-4 p-3 border rounded bg-gray-100"></div>
             
                <div class="flex justify-end mt-4">
                    <button type="button" id="cancel-parcelamento-btn" 
                        class="px-4 py-2 border rounded-lg bg-gray-300 hover:bg-gray-400">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
        <div id="import-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

                <button id="close-import" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>
                <form action="{{ url('/extratoImportExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="button" id="cancel-import" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Importar
                    </button>
                </form>
            </div>
        </div>
        <div id="edit-parcelamento-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

                <button id="close-parcelamento-edit" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <div class="flex justify-between">
                    <h2 class="text-lg font-bold mb-4">Editar Transação  <span id="edit-par-codigo" step="0.01" name="par_codigo"></span></h2>
                    <h2 class="text-lg font-bold mb-4 mr-5">Parcela: <span id="edit-par-numero" step="0.01" name="par_numero"></span>/<span id="edit-par-qtnumero" step="0.01" name="par_qtnumero"></span></h2>
                </div>

                <form id="form-edit" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="par_codigo" id="edit-par-codigo">
                    <input type="hidden" name="par_codigomov" id="edit-par-codigomov">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor da Parcela</label>
                                <input type="number" step="0.01" name="par_valor" id="edit-par-valor"
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                                <select name="par_situacao" id="edit-par-situacao"
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Selecione</option>
                                    <option value="Pendente">Pendente</option>
                                    <option value="Pago">Pago</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                                <input type="date" name="par_datavenc" id="edit-par-vencimento"
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Data de Baixa</label>
                                <input type="date" name="par_databaixa" id="edit-par-baixa"
                                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-4">                     
                        <button type="button" id="cancel-parcelamento-edit" 
                            class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                            Cancelar
                        </button>
                        <button type="submit" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>        

        <script>         
            /* Janela de Cadastro */
            document.getElementById('movb_categoria').addEventListener('change', function(){
                let extraDiv = document.getElementById('extra-div');
                if (this.value === "10") {
                    extraDiv.classList.remove('hidden');
                } else {
                    extraDiv.classList.add('hidden');
                }
            });

            function selecionarInvestimento(tipo, event) {
                document.getElementById("tipo_invest").value = tipo;

                carregarInvestimentos(tipo);

                document.querySelectorAll("#invest > div").forEach(div => {
                    div.classList.remove("ring-2", "ring-indigo-500");
                });

                if (event) {
                    event.currentTarget.classList.add("ring-2", "ring-indigo-500");
                }
            }

            async function carregarInvestimentos(tipo) {
                let baseUrl = "http://192.168.1.77:5000";
                let url = "";

                if (tipo === "cripto") url = `${baseUrl}/criptos`;
                if (tipo === "fundos") url = `${baseUrl}/fundos`;
                if (tipo === "acao") url = `${baseUrl}/api/acao/PETR4`;
                if (tipo === "renda-fixa") url = `${baseUrl}/api/renda-fixa`;

                try {
                    const resp = await fetch(url);
                    if (!resp.ok) throw new Error(`Erro HTTP ${resp.status}`);
                    const dados = await resp.json();
                    exibirInvestimentos(dados, tipo);
                } catch (e) {
                    console.error("Erro ao buscar:", e);
                    document.getElementById("invest").innerHTML =
                        `<p class="text-red-500">Falha ao carregar ${tipo}</p>`;
                }
            }

            function exibirInvestimentos(dados, tipo) {
                const container = document.getElementById("investimentos");
                container.innerHTML = "";

                if (!Array.isArray(dados)) {
                    dados = [dados];
                }

                dados.forEach(item => {
                    let card = document.createElement("div");
                    card.className = "p-2 bg-white rounded-lg shadow cursor-pointer hover:bg-indigo-100";
                    
                    let texto = "";
                    if (tipo === "cripto") texto = item.symbol;
                    else if (tipo === "fundos") texto = item.name;
                    else if (tipo === "acao") texto = item.ticker;
                    else if (tipo === "renda-fixa") texto = item.nome;

                    card.innerHTML = `<p class="font-base">${texto}</p>`;

                    card.addEventListener("click", () => {
            
                        container.querySelectorAll("div").forEach(div => {
                            div.classList.remove("ring-2", "ring-indigo-500");
                        });

                        card.classList.add("ring-2", "ring-indigo-500");
                        
                        document.getElementById("tipo_invest").value = `${tipo}:${texto}`;
                    });

                    container.appendChild(card);
                });
}

            document.getElementById('add-transacoes-btn').addEventListener('click', function() {
                document.getElementById('transacoes-modal').classList.remove('hidden');
            });
            document.getElementById('close-transacoes-modal').addEventListener('click', function() {
                document.getElementById('transacoes-modal').classList.add('hidden');
            });
            document.getElementById('cancel-transacoes').addEventListener('click', function() {
                document.getElementById('transacoes-modal').classList.add('hidden');
            });
            
            /* Janela de Editar */  
            document.querySelectorAll('.edit-transacao-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelector('#transacoes-edit input[name="movb_codigo"]').value = this.dataset.id;
                    document.querySelector('#transacoes-edit input[name="movb_valortotal"]').value = this.dataset.valortotal;
                    document.querySelector('#transacoes-edit input[name="movb_valorliquido"]').value = this.dataset.valorliquido;
                    document.querySelector('#transacoes-edit input[name="movb_cpfpj"]').value = this.dataset.cpfpj;
                    document.querySelector('#transacoes-edit input[name="movb_pessoa"]').value = this.dataset.pessoa;
                    document.querySelector('#transacoes-edit select[name="movb_situacao"]').value = this.dataset.situacao;
                    document.querySelector('#transacoes-edit select[name="movb_categoria"]').value = this.dataset.categoria;
                    document.querySelector('#transacoes-edit input[name="movb_datavenc"]').value = this.dataset.datavenc;
                    document.querySelector('#transacoes-edit input[name="movb_databaixa"]').value = this.dataset.databaixa;
                    document.querySelector('#transacoes-edit select[name="movb_forma"]').value = this.dataset.forma;
                    document.querySelector('#transacoes-edit select[name="movb_natureza"]').value = this.dataset.natureza;
                    document.querySelector('#transacoes-edit textarea[name="movb_observ"]').value = this.dataset.observ;
                    document.querySelector('#transacoes-edit input[name="copa_parcelas"]').value = this.dataset.parcela;
                                        
                    document.querySelector('#transacoes-edit form').action = `/extrato/${this.dataset.id}`;

                    document.getElementById('transacoes-edit').classList.remove('hidden');
                });
            });

            document.getElementById('close-transacoes-edit').addEventListener('click', function() {
                document.getElementById('transacoes-edit').classList.add('hidden');
            });
            document.getElementById('cancel-transacoes-edit').addEventListener('click', function() {
                document.getElementById('transacoes-edit').classList.add('hidden');
            });

            /* Janela Exclui */
            document.querySelectorAll('.add-transacoes-exclui').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    document.querySelector('#edit-codigo').value = id;
                    
                    document.querySelector('#confirm-exclui form').action = `/extrato/${id}`;

                    document.getElementById('confirm-exclui').classList.remove('hidden');
                });
            });
            document.getElementById('close-transacoe-exclui').addEventListener('click', function() {
                document.getElementById('confirm-exclui').classList.add('hidden');
            });
            document.getElementById('cancel-transacoes-exclui').addEventListener('click', function() {
                document.getElementById('confirm-exclui').classList.add('hidden');
            });

            /* Janela Parcelamento*/
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.parcelamento').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const movId = this.dataset.id; 
                        const modal = document.getElementById('parcelamento-modal');
                        const codigoSpan = modal.querySelector('#codigo-mov');
                        const hiddenInput = modal.querySelector('input[name="movb_codigo"]');
                        const parcelasLista = modal.querySelector('#parcelas-lista');

                        hiddenInput.value = movId;
                        codigoSpan.textContent = movId;

                        parcelasLista.innerHTML = '';

                        carregarParcelas(movId);

                        modal.classList.remove('hidden');
                    });
                });
                document.getElementById('close-parcelamento').addEventListener('click', () => {
                    document.getElementById('parcelamento-modal').classList.add('hidden');
                });

                document.getElementById('cancel-parcelamento-btn').addEventListener('click', () => {
                    document.getElementById('parcelamento-modal').classList.add('hidden');
                });
            });    

            function carregarParcelas(movb_codigo) {
                fetch(`/parcelamento/${movb_codigo}`)
                    .then(res => res.json())
                    .then(data => {
                        const parcelasLista = document.querySelector('#parcelamento-modal #parcelas-lista');
                        parcelasLista.innerHTML = '';

                        if (data.parcelas && data.parcelas.length > 0) {
                            data.parcelas.forEach(par => {
                                parcelasLista.innerHTML += `
                                    <div class="flex justify-between p-2 border-b">
                                        <span>Parcela: ${par.par_numero}/${par.par_qtnumero ?? ''}</span>
                                        <span>R$ ${parseFloat(par.par_valor).toFixed(2).replace('.', ',')}</span>
                                        <span>${new Date(par.par_datavenc).toLocaleDateString('pt-BR')}</span>
                                        <span class="${par.par_situacao === 'Pendente' ? 'text-yellow-800' : 'text-green-800'}">
                                            ${par.par_situacao ?? 'Pendente'}
                                        </span>
                                        <button type="button" 
                                            class="edit-parcelamento-btn px-3 py-1 border rounded-lg bg-indigo-600 text-gray-100 hover:bg-indigo-700"
                                            data-codigomov="${par.par_codigomov}"
                                            data-codigo="${par.par_codigo}"
                                            data-valor="${par.par_valor}"
                                            data-numero="${par.par_numero}"
                                            data-qtnumero="${par.par_qtnumero}"
                                            data-datavenc="${par.par_datavenc}"
                                            data-databaixa="${par.par_databaixa ?? ''}"
                                            data-situacao="${par.par_situacao ?? ''}">
                                            Editar
                                        </button>
                                    </div>`;
                            });

                            document.querySelectorAll('.edit-parcelamento-btn').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const modalEdit = document.getElementById('edit-parcelamento-modal');

                                    modalEdit.querySelector('#edit-par-codigomov').value = this.dataset.codigomov;
                                    modalEdit.querySelector('#edit-par-codigo').textContent = this.dataset.codigo;
                                    modalEdit.querySelector('#edit-par-valor').value = this.dataset.valor;
                                    modalEdit.querySelector('#edit-par-numero').textContent = this.dataset.numero;
                                    modalEdit.querySelector('#edit-par-qtnumero').textContent = this.dataset.qtnumero;
                                    modalEdit.querySelector('#edit-par-situacao').value = this.dataset.situacao;
                                    modalEdit.querySelector('#edit-par-vencimento').value = this.dataset.datavenc;
                                    modalEdit.querySelector('#edit-par-baixa').value = this.dataset.databaixa;

                                    modalEdit.querySelector('form').action = `/parcelamento/${this.dataset.codigo}/${this.dataset.codigomov}`;

                                    modalEdit.classList.remove('hidden');
                                });
                            });
                        } else {
                            parcelasLista.innerHTML = `<div class="text-center text-gray-500 p-4">Nenhuma parcela encontrada.</div>`;
                        }
                    })
                    .catch(err => console.error("Erro ao carregar parcelas:", err));
            }

            document.getElementById('close-parcelamento-edit').addEventListener('click', () => {
                document.getElementById('edit-parcelamento-modal').classList.add('hidden');
            });

            document.getElementById('cancel-parcelamento-edit').addEventListener('click', () => {
                document.getElementById('edit-parcelamento-modal').classList.add('hidden');
            });

            /* Janela de Cadastro */
            document.getElementById('add-import-btn').addEventListener('click', function() {
                document.getElementById('import-modal').classList.remove('hidden');
            });
            document.getElementById('close-import').addEventListener('click', function() {
                document.getElementById('import-modal').classList.add('hidden');
            });
            document.getElementById('cancel-import').addEventListener('click', function() {
                document.getElementById('import-modal').classList.add('hidden');
            });

            /* Limpar Filtro */
            document.getElementById('btn-limpar').addEventListener('click', function () {
                const form = document.getElementById('form-filtros');
                form.reset();

                window.location.href = "{{ route('extrato') }}";
            });
        </script>
    </div>
</section>
@endsection

@section('footer')
@endsection
