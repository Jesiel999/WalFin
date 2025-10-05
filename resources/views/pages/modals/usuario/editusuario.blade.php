<div id="usuario-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">
        
        <button id="closed-usuario-modal"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
        &times;
        </button>

        <h2 class="text-lg font-bold mb-4">Editar usuário</h2>

        <form method="POST" action="{{ route('usuario.edit') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Nome:</label>
                        <input type="text" step="0.01" name="usua_nome" value="{{$userName}}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">CPF/PJ:</label>
                        <input type="text" step="0.01" name="usua_cpfpj" value="{{ $userCpfpj }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Telefone:</label>
                        <input type="text" step="0.01" name="usua_telefone" value="{{ $userFone }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium font-bold mb-2">Email:</label>
                        <input type="email" step="0.01" name="usua_email" value="{{ $userEmail }}"
                            class="border rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" id="cancel-usuario-modal" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>