<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Meu App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       
    </style>
</head>
<body class="flex">
    <aside id="sidebar"  class="sidebar bg-indigo-700 w-64 lg:w-16 text-white z-40 
         transition-all duration-300 flex flex-col h-screen fixed 
         top-0 left-0 uppercase tracking-wider 
         -translate-x-full lg:translate-x-0">
    @include('components.sidebar')
    </aside>


    <div id="mainContent" class="ml-0 lg:ml-16 flex-1 flex flex-col min-h-screen">

        @include('components.header')

        <main class="content flex-1 p-6 bg-gray-100">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    <script>
        const labels = @json($labels);
        const receitas = @json($dadosReceita);
        const despesas = @json($dadosDespesa);
        const totalInvestido = @json($totalInvestido);

        const ctxAporteResgate = document.getElementById('AporteResgate').getContext('2d');
        new Chart(ctxAporteResgate, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Resgate',
                        data: receitas,
                        backgroundColor: 'rgba(59, 130, 246, 1)',
                        tension: 0.3
                    },
                    {
                        label: 'Aporte',
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

        const ctxEvolucaoAportes= document.getElementById('EvolucaoAportes').getContext('2d');
        new Chart(ctxEvolucaoAportes, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Resgate',
                        data: receitas,
                        backgroundColor: 'rgba(59, 130, 246, 1)',
                        tension: 0.3
                    },
                    {
                        label: 'Aporte',
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
</script>
</body>
</html>
