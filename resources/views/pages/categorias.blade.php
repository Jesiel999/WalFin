@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
<section id="categories" class="section-content">
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-lg md:text-xl lg:text-2xl font-bold">Categorias</h2>
            <button type="button" id="add-category-btn" 
                class="bg-indigo-600 text-white px-4 py-2 text-sm md:text-base rounded-lg hover:bg-indigo-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Nova Categoria
            </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($categorias as $categoria)
                <div class="bg-gray-100 rounded-xl p-3 md:p-4 shadow-sm flex items-center justify-between">
                    <div class="bg-blue-100 p-2 md:p-3 rounded-full mr-3 md:mr-4">
                        <i class="{{ $categoria->cat_icone }} text-blue-600 text-lg md:text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium truncate text-sm md:text-base">{{ $categoria->cat_nome }}</h3>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button"
                            class="categoria-edit p-2 bg-white border rounded-full hover:bg-gray-200"
                            data-id="{{ $categoria->cat_codigo }}">
                            <i class="fas fa-pen text-sm md:text-base"></i>
                        </button>
                        <button type="button"
                            class="categoria-exclui p-2 bg-white border rounded-full hover:bg-gray-200"
                            data-id="{{ $categoria->cat_codigo }}">
                            <i class="fas fa-trash text-sm md:text-base"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>  

<div id="category-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md fade-in relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Nova Categoria</h3>
            <button type="button" id="close-category-modal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf
            <div class="mb-4">
                <label for="cat_nome" class="block text-gray-700 text-sm font-bold mb-2">Nome da Categoria</label>
                <input type="text" name="cat_nome" id="cat_nome" value="{{ old('cat_nome') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                @error('cat_nome')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ícone</label>
                <input type="hidden" name="cat_icone" id="cat_icone" value="{{ old('cat_icone') }}" required>
                @php
                    $icons = [
                        'fas fa-utensils','fas fa-home','fas fa-car','fas fa-film',
                        'fas fa-shopping-bag','fas fa-book','fas fa-coffee','fas fa-heart',
                        'fas fa-bicycle','fas fa-laptop','fas fa-music','fas fa-camera',
                        'fas fa-tree','fas fa-star','fas fa-globe','fas fa-gift',
                        'fas fa-bed','fas fa-bolt','fas fa-briefcase','fas fa-wifi'
                    ];
                @endphp
                <div class="grid grid-cols-5 gap-2">
                    @foreach($icons as $icon)
                        <button type="button" 
                                class="p-2 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                data-icone="{{ $icon }}">
                            <i class="{{ $icon }} text-xl"></i>
                        </button>
                    @endforeach
                </div>
                @error('cat_icone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="cancel-category" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Salvar</button>
            </div>
        </form>
    </div>
</div>

<div id="categoria-edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl p-6 w-11/12 max-w-md">
        <button id="close-categoria-edit" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        
        <h2 class="text-lg font-bold mb-4">Editar Categoria</h2>

        <form id="form-edit" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="cat_codigo">
            <input type="hidden" name="cat_icone">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                <input type="text" name="cat_nome"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ícone</label>
                <div class="grid grid-cols-5 gap-2">
                    @foreach($icons as $icon)
                        <button type="button" 
                                class="p-2 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                data-icone="{{ $icon }}">
                            <i class="{{ $icon }} text-xl"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-4">                     
                <button type="button" id="cancel-categoria-edit" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Salvar</button>
            </div>
        </form>
    </div>
</div>

<div id="confirm-exclui" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-11/12 max-w-md">
        <button id="close-categoria-exclui" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>

        <h2 class="text-lg font-bold mb-4">Excluir Categoria</h2>

        <form method="POST" action="">
            @csrf
            @method('DELETE')
            <p class="text-gray-700 text-lg font-bold mb-4">Você realmente deseja excluir esta categoria?</p>
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-categoria-exclui" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Confirmar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('category-modal');
    const openBtn = document.getElementById('add-category-btn');
    const closeBtn = document.getElementById('close-category-modal');
    const cancelBtn = document.getElementById('cancel-category');
    const iconButtons = document.querySelectorAll('button[data-icone]');
    const iconInput = document.getElementById('cat_icone');

    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    iconButtons.forEach(button => {
        button.addEventListener('click', () => {
            if(button.closest('#categoria-edit-modal')) {
                document.querySelector('#categoria-edit-modal input[name="cat_icone"]').value = button.dataset.icone;
            } else {
                iconInput.value = button.dataset.icone;
            }
            iconButtons.forEach(btn => btn.classList.remove('bg-indigo-200'));
            button.classList.add('bg-indigo-200');
        });
    });

    /* Modal Editar */
    document.querySelectorAll('.categoria-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#categoria-edit-modal input[name="cat_codigo"]').value = this.dataset.id;
            document.querySelector('#categoria-edit-modal input[name="cat_nome"]').value = this.dataset.nome;
            document.querySelector('#categoria-edit-modal input[name="cat_icone"]').value = this.dataset.icone;
            document.querySelector('#categoria-edit-modal form').action = `/categorias/${this.dataset.id}`;
            document.getElementById('categoria-edit-modal').classList.remove('hidden');
        });
    });
    document.getElementById('close-categoria-edit').addEventListener('click', () => {
        document.getElementById('categoria-edit-modal').classList.add('hidden');
    });
    document.getElementById('cancel-categoria-edit').addEventListener('click', () => {
        document.getElementById('categoria-edit-modal').classList.add('hidden');
    });

    /* Modal Excluir */
    document.querySelectorAll('.categoria-exclui').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#confirm-exclui form').action = `/categorias/${this.dataset.id}`;
            document.getElementById('confirm-exclui').classList.remove('hidden');
        });
    });
    document.getElementById('close-categoria-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
    document.getElementById('cancel-categoria-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
});
</script>
@endsection
