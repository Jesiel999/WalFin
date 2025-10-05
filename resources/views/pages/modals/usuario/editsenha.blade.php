<div id="alterar-senha-modal" class="fixed inset-0 bg-black bg-opacity-50 max-w-1x1 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-mdw-full relative">
        <button id="closed-alterar-senha-modal"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2x1 font-bold">
            &times;
        </button>
        <div class="flex justify-between">
            <h2 class="text-lg font-bold mb-4">Alterar Senha</h2>
        </div>
            <form method="POST" action="{{ route('usuario.updateSenha') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Senha Atual</label>
                <input type="password" name="senha_atual" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Nova Senha</label>
                <input type="password" name="nova_senha" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Confirmar Nova Senha</label>
                <input type="password" name="nova_senha_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="button" id="cancel-alterar-senha-modal" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                Cancelar
            </button>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Alterar Senha
            </button>
        </form>
    </div>
</div>