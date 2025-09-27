<div id="confirm-exclui" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-transacoe-exclui" 
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
                        <h1 class="text-gray-700 text-lg font-bold mb-2">Você realmente deseja excluir essa movimentação ?</h1>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-transacoes-exclui" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>