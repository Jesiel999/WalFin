<div id="pessoa-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md fade-in relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Nova Pessoa</h3>
            <button type="button" id="close-pessoa-modal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('pessoa.store') }}">
            @csrf
            <div class="mb-4">
                <label for="pes_nome" class="block text-gray-700 text-sm font-bold mb-2">Nome da pessoa</label>
                <input type="text" name="pes_nome" id="pes_nome" value="{{ old('pes_nome') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                @error('pes_nome')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pes_cpfpj" class="block text-gray-700 text-sm font-bold mb-2">CPF/CNPJ</label>
                <input type="text" name="pes_cpfpj" id="pes_cpfpj" value="{{ old('pes_cpfpj') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('pes_cpfpj')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pes_email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                <input type="text" name="pes_email" id="pes_email" value="{{ old('pes_email') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('pes_email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pes_telefone" class="block text-gray-700 text-sm font-bold mb-2">Telefone</label>
                <input type="text" name="pes_telefone" id="pes_telefone" value="{{ old('pes_telefone') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('pes_telefone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="pes_observacao" class="block text-gray-700 text-sm font-bold mb-2">Observação</label>
                <textarea type="text" name="pes_observacao" id="pes_observacao" value="{{ old('pes_observacao') }}"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                @error('pes_observacao')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="cancel-pessoa" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Salvar</button>
            </div>
        </form>
    </div>
</div>
