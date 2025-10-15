<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('extra-scripts')
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex overflow-x-hidden">
    <aside id="sidebar"  class="sidebar bg-indigo-700 w-64 lg:w-16 text-white z-40 
         transition-all duration-300 flex flex-col h-screen fixed 
         top-0 left-0 uppercase tracking-wider 
         -translate-x-full lg:translate-x-0">
        @include('components.sidebar')
    </aside>


    <div id="mainContent" class="ml-0 lg:ml-16 flex-1 flex flex-col">

        @include('components.header')

        <main class="content flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }

    const labels = @json($labels);
    const labelsPrevistas = @json($labelsPrevistas);
    const receitas = @json($dadosReceita);
    const despesas = @json($dadosDespesa);
    const receitasPrevistas = @json($dadosReceitaPrevista);
    const despesasPrevistas = @json($dadosDespesaPrevista);
    const categoriaLabels = @json($categoriaLabels);
    const categoriaTotais = @json($categoriaTotais);
    const evolSaldo = @json($dadosSaldoEvolucao);

    const ctxDespesasXReceitaBaixado = document.getElementById('DespesasXReceitaBaixado').getContext('2d');
    new Chart(ctxDespesasXReceitaBaixado, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Receitas',
                    data: receitas,
                    backgroundColor: 'rgba(59, 130, 246, 1)',
                    tension: 0.3
                },
                {
                    label: 'Despesas',
                    data: despesas,
                    backgroundColor: 'rgba(239, 68, 68, 1)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
                x: {}
            }
        }
    });


    const ctxDespesasBaixadoporCategoria = document.getElementById('DespesasBaixadoporCategoria').getContext('2d');
    new Chart(ctxDespesasBaixadoporCategoria, {
        type: 'doughnut',
        data: {
            labels: categoriaLabels,
            datasets: [{
                data: categoriaTotais,
                backgroundColor: [
                    '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6',
                    '#EC4899', '#EF4444', '#A78BFA', '#F87171', '#34D399'
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
    
    const ctxDespesasXReceitaPendente = document.getElementById('DespesasXReceitaPendente').getContext('2d');
    new Chart(ctxDespesasXReceitaPendente, {
        type: 'bar',
        data: {
            labels: labelsPrevistas,
            datasets: [
                {
                    label: 'Receitas Previstas',
                    data: receitasPrevistas,
                    backgroundColor: 'rgba(59, 130, 246, 1)',
                    tension: 0.3
                },
                {
                    label: 'Despesas Previstas',
                    data: despesasPrevistas,
                    backgroundColor: 'rgba(239, 68, 68, 1)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
                x: {}
            }
        }
    });

    const ctxDespesasXReceitaEvolucao = document.getElementById('DespesasXReceitaEvolucao').getContext('2d');
    new Chart(ctxDespesasXReceitaEvolucao, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Evolução do Saldo Acumulado',
                data: evolSaldo,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.3,
                segment: {
                    borderColor: ctx => ctx.p0.parsed.y < 0 || ctx.p1.parsed.y < 0 
                        ? 'rgba(220, 53, 69, 1)'
                        : 'rgba(59, 130, 246, 1)', 

                    backgroundColor: ctx => ctx.p0.parsed.y < 0 || ctx.p1.parsed.y < 0 
                        ? 'rgba(220, 53, 69, 0.2)'
                        : 'rgba(59, 130, 246, 0.2)'
                },
                pointBackgroundColor: ctx => ctx.parsed.y < 0 
                    ? 'rgba(220, 53, 69, 1)'  
                    : 'rgba(59, 130, 246, 1)', 

                pointBorderColor: ctx => ctx.parsed.y < 0 
                    ? 'rgba(220, 53, 69, 1)'
                    : 'rgba(59, 130, 246, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
