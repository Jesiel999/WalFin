@extends('layouts.app')

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
        </div>
    </div>
</section>
<div id="condPagamento-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Nova Condição de Pagamento</h3>
            <button id="close-condPagamento-modal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('CondPagamento.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="nome" class="block font-medium mb-1">Nome*</label>
                <input type="text" name="copa_nome" id="copa_nome" required
                    class="w-full border rounded px-3 py-2" value="{{ old('copa_nome') }}">
                @error('nome') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="tipo" class="block font-medium mb-1">Tipo de Pagamento*</label>
                <select name="copa_tipo" id="copa_tipo" required
                    class="w-full border rounded px-3 py-2">
                    <option value="A vista" {{ old('copa_tipo', 'A vista') == 'A vista' ? 'selected' : '' }}>A vista</option>
                    <option value="A prazo" {{ old('copa_tipo') == 'A prazo' ? 'selected' : '' }}>A prazo</option>
                </select>
                @error('copa_tipo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="numero_parcelas" class="block font-medium mb-1">Número de Parcelas*</label>
                <input type="number" name="copa_parcelas" id="copa_parcelas" min="1"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('copa_parcelas') }}"
                    {{ old('copa_tipo', 'A vista') != 'A prazo' ? 'disabled' : '' }}>
                @error('numero_parcelas') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="intervalo_dias" class="block font-medium mb-1">Intervalo entre parcelas (dias)*</label>
                <input type="number" name="copa_intervalo" id="copa_intervalo" min="0"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('copa_intervalo') }}"
                    {{ old('copa_tipo', 'A vista') != 'A prazo' ? 'disabled' : '' }}>
                @error('intervalo_dias') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            
            <div class="mb-4">
                <label for="descricao" class="block font-medium mb-1">Descrição</label>
                <textarea name="copa_desc" id="copa_desc" rows="3"
                    class="w-full border rounded px-3 py-2">{{ old('copa_desc') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="copa_status" id="copa_status" value="1" {{ old('copa_status', true) ? 'checked' : '' }}>
                    <span class="ml-2">Ativo</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <button id="cancel-condPagamento" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>
<div id="cond-pagamento-edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-cond-pagamento-edit" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>
        
        <div class="flex justify-between">
            <h2 class="text-lg font-bold mb-4">Editar Condição Pagamento</h2>
            <h2 class="text-lg font-bold mb-4 mr-5 hidden">Código: <input id="edit-codigo" step="0.01" name="copa_codigo"/></h2>
        </div>

        <form id="form-edit" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg::grid-cols-2 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Nome</label>
                        <input type="text" step="0.01" name="copa_nome"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 ">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Descrição</label>
                        <textarea type="text" step="0.01" name="copa_desc"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 ">
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4">                     
                <button type="button" id="cancel-cond-pagamento-edit" 
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

        <button id="close-cond-pagamento-exclui" 
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
                        <h1 class="text-gray-700 text-lg font-bold mb-2">Você realmente deseja excluir essa condição de pagamento ?</h1>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-cond-pagamento-exclui" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('condPagamento-modal');
    const openBtn = document.getElementById('add-condPagamento-btn');
    const closeBtn = document.getElementById('close-condPagamento-modal');
    const cancelBtn = document.getElementById('cancel-condPagamento');

    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    const tipoPagamento = document.getElementById('copa_tipo');
    const parcelasInput = document.getElementById('copa_parcelas');
    const intervaloInput = document.getElementById('copa_intervalo');

    function toggleCampos() {
        if (tipoPagamento.value === 'A prazo') {
            parcelasInput.disabled = false;
            intervaloInput.disabled = false;
        } else {
            parcelasInput.value = '';
            intervaloInput.value = '';
            parcelasInput.disabled = true;
            intervaloInput.disabled = true;
        }
    }

    tipoPagamento.addEventListener('change', toggleCampos);

    toggleCampos();
});

/* Janela de Editar */
document.querySelectorAll('.cond-pagamento-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelector('#cond-pagamento-edit-modal input[name="copa_codigo"]').value = this.dataset.id;
        document.querySelector('#cond-pagamento-edit-modal input[name="copa_nome"]').value = this.dataset.nome;
        document.querySelector('#cond-pagamento-edit-modal textarea[name="copa_desc"]').value = this.dataset.desc;
                                   
            document.querySelector('#cond-pagamento-edit-modal form').action = `/condicoesPagamento/${this.dataset.id}`;

        document.getElementById('cond-pagamento-edit-modal').classList.remove('hidden');
    });
});
document.getElementById('close-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('cond-pagamento-edit-modal').classList.add('hidden');
});
document.getElementById('cancel-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('cond-pagamento-edit-modal').classList.add('hidden');
});

/* Janela Exclui */
document.querySelectorAll('.cond-pagamento-exclui').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        document.querySelector('#edit-codigo').value = id;
        
        document.querySelector('#confirm-exclui form').action = `/condicoesPagamento/${id}`;

        document.getElementById('confirm-exclui').classList.remove('hidden');
    });
});
document.getElementById('close-cond-pagamento-exclui').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});
document.getElementById('cancel-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});
</script>
@endsection

