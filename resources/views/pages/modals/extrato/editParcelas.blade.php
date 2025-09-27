<div id="edit-parcelamento-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-parcelamento-edit" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>

        <div class="flex justify-between">
            <h2 class="text-lg font-bold mb-4">Editar Transação  <span id="edit-par-codigo" step="0.01" name="par_codigo"></span></h2>
            <h2 class="text-lg font-bold mb-4 mr-5">Parcela: <span id="edit-par-numero" step="0.01" name="par_numero"></span>/<span id="edit-par-qtnumero" step="0.01" name="par_qtnumero"></span></h2>
        </div>

        <form id="form-edit" method="POST" action="">
            @csrf
            @method('PUT')

            <input type="hidden" name="par_codigo" id="edit-par-codigo">
            <input type="hidden" name="par_codigomov" id="edit-par-codigomov">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor da Parcela</label>
                        <input type="number" step="0.01" name="par_valor" id="edit-par-valor"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                        <select name="par_situacao" id="edit-par-situacao"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Pago">Pago</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                        <input type="date" name="par_datavenc" id="edit-par-vencimento"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Data de Baixa</label>
                        <input type="date" name="par_databaixa" id="edit-par-baixa"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-4">                     
                <button type="button" id="cancel-parcelamento-edit" 
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