@extends('layouts.app')

@section('extra-scripts')
    <script type="module" src="{{Vite::asset('resources/js/modals/extrato.js')}}"></script>
    <script type="module" src="{{Vite::asset('resources/js/buscapessoa.js')}}"></script>
    <script type="module" src="{{Vite::asset('resources/js/buscapessoaupdate.js')}}"></script>
@endsection

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
                            <td class="px-2 py-2 lg:px-6 text-wrap text-center text-gray-700">{{ $mov->pessoa ? $mov->pessoa->pes_nome : '' }}</td>
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
                                @if($mov->parcela->par_qtnumero > 1)
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
                                    data-pessoa="{{ $mov->pessoa ? $mov->pessoa->pes_nome : '' }}"
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
        @include ('pages.modals.extrato.add')
        @include ('pages.modals.extrato.edit')
        @include ('pages.modals.extrato.delete')
        @include ('pages.modals.extrato.parcelas')
        @include ('pages.modals.extrato.import')
        @include ('pages.modals.extrato.editParcelas')
    </div>
</section>
@endsection
<!-- LIMPA FILTRO -->
<script>
    const limpaFiltroExtrato = "{{ route('extrato') }}";
</script>
