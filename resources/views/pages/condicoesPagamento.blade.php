@extends('layouts.app')

@section('extra-scripts')
    <script type="module" src="{{ Vite::asset('resources/js/modals/condPagamento.js') }}"></script>
@endsection

@section('title', 'Condição de Pagamento')

@section('content')
<section id="condicao-pagamento" class="section-content">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Condições de Pagamento</h2>
            <button id="add-condPagamento-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Nova Condição
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="lista-condicao-pagamento">
            @forelse($cond_pagamento as $cond)
                <div class="bg-gray-100 rounded-xl p-4 shadow-sm flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $cond->copa_nome }}</h3>
                        <p class="text-sm text-gray-500">{{ $cond->copa_tipo }}</p>
                    </div>

                    <div class="flex space-x-2">
                        <button type="button"
                            class="cond-pagamento-edit p-2 bg-white border rounded-full hover:bg-gray-200"
                            data-id="{{ $cond->copa_codigo }}"
                            data-nome="{{ $cond->copa_nome }}"
                            data-desc="{{ $cond->copa_desc }}">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button type="button"
                            class="cond-pagamento-exclui p-2 bg-white border rounded-full hover:bg-gray-200"
                            data-id="{{ $cond->copa_codigo }}"
                            >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-6 text-gray-500 italic">
                    Nenhuma condição encontrada
                </div>
            @endforelse
            @include('pages.modals.condPagamento.add')
            @include('pages.modals.condPagamento.edit')
            @include('pages.modals.condPagamento.delete')
        </div>
    </div>
</section>
@endsection