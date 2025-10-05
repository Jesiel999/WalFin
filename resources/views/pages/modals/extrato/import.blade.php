<div id="import-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl w-full relative">

        <button id="close-import" 
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>
        <form action="{{ url('/extratoImportExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="button" id="cancel-import" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                Cancelar
            </button>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Importar
            </button>
        </form>
        <table class="gap-4">
            <title>Esse formato abaixo é o necessário para importar uma planilha de dados</title>
            <td>Valor Total</td>
            <td>Valor Título</td>
            <td>Situação</td>
            <td>Categoria</td>
            <td>CPF/PJ</td>
            <td>Pessoa</td>
            <td>Observação</td>
            <td>Data de vencimento</td>
            <td>Data de baixa</td>
            <td>Data de entrada e saída</td>
            <td>Forma de pamento</td>
            <td>Natureza</td>
        </table>
    </div>
</div>