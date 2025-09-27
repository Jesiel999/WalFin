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