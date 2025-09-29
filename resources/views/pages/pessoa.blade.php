@extends ('layouts.app')

@section('extra-scripts')
    <script type="module" src="{{Vite::asset('resources/js/modals/pessoa.js')}}"></script>
@endsection

@section('title', 'Pessoa')

@section('content')
<section>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Pessoas</h2>
            <button id="add-pessoa-btn"
                class="bg-indigo-600 text-white px-8 py-6 text-lg lg:px-3 lg:py-2 lg:text-sm rounded-lg hover:bg-indigo-700 transition flex items-center font-bold">
                <i class="fas fa-plus mr-2"></i> Nova Pessoa
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="lista-pessoa">
            @forelse ($pessoas as $pessoa)
            <div class="bg-gray-100 rounded-x1 p-4 shadow-sm flex justify-between items-center">
                <div>
                    <h3>{{$pessoa->pes_nome}}</h3>
                    <p>{{$pessoa->pes_cpfpj}}</p>
                </div>
                <div class="flex space-x-2">
                    <button type="button"
                        class="pessoa-edit p-2 bg-white border rounded-full hover:bg-gray-200"
                        data-id="{{$pessoa->pes_codigo}}"
                        data-nome="{{$pessoa->pes_nome}}"
                        data-cpfpj="{{$pessoa->pes_cpfpj}}">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button"
                        class="pessoa-exclui p-2 bg-white border rounded-full hover:bg-gray-200"
                        data-id="{{$pessoa->pes_codigo}}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-6 text-gray-500 italic">
                Nenhuma pessoa encontrada
            </div>          
            @endforelse
            @include('pages.modals.pessoa.add')
            @include('pages.modals.pessoa.edit')
            @include('pages.modals.pessoa.delete')
        </div>
    </div>
</section>
@endsection
