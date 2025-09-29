<div id="pessoa-edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl p-6 w-11/12 max-w-md">
        <button id="close-pessoa-edit" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        
        <h2 class="text-lg font-bold mb-4">Editar Pessoa</h2>

        <form id="form-edit" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="pes_codigo">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                <input type="text" name="pes_nome"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">CPF/CNPJ</label>
                <input type="text" name="pes_cpfpj"
                    class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end space-x-3 mt-4">                     
                <button type="button" id="cancel-pessoa-edit" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Salvar</button>
            </div>
        </form>
    </div>
</div>