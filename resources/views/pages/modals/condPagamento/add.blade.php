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