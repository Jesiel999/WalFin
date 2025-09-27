<div id="parcelamento-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-parcelamento" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>

        <h2 class="text-lg font-bold mb-4">Parcelamento da Movimentação</h2>
        <h2 class="text-lg font-bold mb-4 mr-5">
            Código: <span id="codigo-mov"></span>
            <input type="hidden" name="movb_codigo">
        </h2>
        <div id="parcelas-lista" class="mt-4 p-3 border rounded bg-gray-100"></div>
        
        <div class="flex justify-end mt-4">
            <button type="button" id="cancel-parcelamento-btn" 
                class="px-4 py-2 border rounded-lg bg-gray-300 hover:bg-gray-400">
                Fechar
            </button>
        </div>
    </div>
</div>