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