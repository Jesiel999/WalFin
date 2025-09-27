<div id="transacoes-edit" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-transacoes-edit" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>

        <div class="flex justify-between">
            <h2 class="text-lg font-bold mb-4">Editar Transação</h2>
            <h2 class="text-lg font-bold mb-4 mr-5">Código: <input id="edit-codigo" step="0.01" name="movb_codigo"/></h2>
        </div>

        <form id="form-edit" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Total</label>
                        <input type="number" step="0.01" name="movb_valortotal" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Líquido</label>
                        <input type="number" step="0.01" name="movb_valorliquido" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>  

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF ou CNPJ</label>
                        <input type="text" name="movb_cpfpj" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Pessoa</label>
                        <input type="text" name="movb_pessoa" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                        <select name="movb_situacao" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Pago">Pago</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Categoria</label>
                        <select id="movb_categoria" name="movb_categoria" 
                        class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->cat_codigo }}">{{ $categoria->cat_nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="extra-div" class="hidden mt-4 p-4 border rounded-lg bg-gray-100">
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Investimento</label>
                        <input type="text" name="info_extra" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                        <input type="date" name="movb_datavenc" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="databaixa">
                        <label class="block text-sm font-medium">Data de Baixa</label>
                        <input type="date" name="movb_databaixa" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="hidden">
                        <label class="block text-sm font-medium">Qt parcelas</label>
                        <input type="text" name="copa_parcelas" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Forma</label>
                        <select name="movb_forma" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            @foreach($cond_pagamento as $cond)
                                <option value="{{ $cond->copa_codigo }}">{{ $cond->copa_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Natureza</label>
                        <select name="movb_natureza" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            <option value="Receita">Receita</option>
                            <option value="Despesa">Despesa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Observação</label>
                        <textarea name="movb_observ" rows="4" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-4">                     
                <button type="button" id="cancel-transacoes-edit" 
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