<div id="confirm-exclui" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-11/12 max-w-md">
        <button id="close-pessoa-exclui" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>

        <h2 class="text-lg font-bold mb-4">Excluir Pessoa</h2>

        <form method="POST" action="">
            @csrf
            @method('DELETE')
            <p class="text-gray-700 text-lg font-bold mb-4">Você realmente deseja excluir esta pessoa?</p>
            
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-pessoa-exclui" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Confirmar</button>
            </div>
        </form>
    </div>
</div>