@extends('layouts.app')

@section('extra-scripts')
    <script type="module" src="{{ Vite::asset('resources/js/modals/categoria.js') }}"></script>
@endsection

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
                            data-id="{{ $categoria->cat_codigo }}"
                            data-nome="{{ $categoria->cat_nome }}"
                            data-icone="{{ $categoria->cat_icone }}"
                        >
                            <i class="fas fa-pen text-sm md:text-base"></i>
                        </button>
                        <button type="button"
                            class="categoria-exclui p-2 bg-white border rounded-full hover:bg-gray-200"
                            data-id="{{ $categoria->cat_codigo }}">
                            <i class="fas fa-trash text-sm md:text-base"></i>
                        </button>
                    </div>
                </div>
                @include ('pages.modals.categoria.add')
                @include ('pages.modals.categoria.edit')
                @include ('pages.modals.categoria.delete')
            @endforeach
        </div>
    </div>
</section>  
@endsection