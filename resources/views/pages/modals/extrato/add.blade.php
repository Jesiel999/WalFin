<div id="transacoes-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md 
                w-[95%] max-w-4xl max-h-[90vh] 
                overflow-y-auto relative">

        <button id="close-transacoes-modal" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>

        <h2 class="text-lg font-bold mb-4">Cadastro de Nova Transação</h2>

        <form method="POST" action="{{ route('cadastroMov') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Total</label>
                        <input type="number" step="0.01" name="movb_valortotal" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Valor Líquido</label>
                        <input type="number" step="0.01" name="movb_valorliquido" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                    </div>  

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF ou CNPJ</label>
                        <input type="text" name="movb_cpfpj" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Pessoa</label>
                        <input type="text" name="movb_pessoa" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Situação</label>
                        <select name="movb_situacao" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
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

                    <div id="extra-div" class="hidden mt-4 p-4 border border-indigo-500 rounded-lg bg-indigo-50">
                        <input type="hidden" id="tipo_invest" name="movb_tipoinvestimento">

                        <div id="invest" class="flex flex-wrap gap-4">
                            <div id="cripto" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                onclick="selecionarInvestimento('cripto', event)">
                                <i class="fas fa-coins text-gray-600 text-base"></i>
                                <p class="font-base">Cripto</p>
                            </div>
                            <div id="renda-fixa" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                onclick="selecionarInvestimento('renda-fixa', event)">
                                <i class="fas fa-university text-gray-600 text-base"></i>
                                <p class="font-base">Renda Fixa</p>
                            </div>
                            <div id="acao" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                onclick="selecionarInvestimento('acao', event)">
                                <i class="fas fa-chart-line text-gray-600 text-base"></i>
                                <p class="font-base">Bolsa</p>
                            </div>
                            <div id="fundos" class="flex-1 min-w-[120px] p-2 bg-white border rounded-lg shadow text-center cursor-pointer hover:bg-indigo-100"
                                onclick="selecionarInvestimento('fundos', event)">
                                <i class="fas fa-piggy-bank text-gray-600 text-base"></i>
                                <p class="font-base">Fundos</p>
                            </div>
                        </div>

                        <div id="investimentos" 
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 max-h-[10vh] overflow-y-auto">
                        </div>
                    </div>
                </div>                        

                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Data de Vencimento</label>
                        <input type="date" name="movb_datavenc" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Data de Baixa</label>
                        <input type="date" name="movb_databaixa" 
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Forma</label>
                        <select name="movb_forma" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
                            <option value="">Selecione</option>
                            @foreach($cond_pagamento as $cond)
                                <option value="{{ $cond->copa_codigo }}">{{ $cond->copa_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Natureza</label>
                        <select name="movb_natureza" class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" >
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
            
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancel-transacoes" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>