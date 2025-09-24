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

        async function atualizarCotacao() {
            try {
                const container = document.getElementById("top-cripto");
                const response = await fetch(`http://192.168.1.77:5000/criptostop10`);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const data = await response.json();
                
                data.forEach(coin => {
                    const id = `criptostop10-${coin.symbol}`;
                    let div = document.getElementById(id);

                    if (!div) {
                        div = document.createElement("div");
                        div.id = id;
                        div.className = "shadow-md bg-gray-50 p-4 flex flex-col mb-2 rounded-xl";
                        container.appendChild(div);
                    }

                    const arrow = coin.var_24h >= 0 ? '▲' : '▼';
                    const arrowColor = coin.var_24h >= 0 ? 'text-green-600' : 'text-red-600';

                    div.innerHTML = `
                        <div class="flex justify-between items-center">
                            <h1 class="text-1xl font-bold text-gray-500">
                                ${coin.symbol}
                            </h1>
                            <h2 class="text-1xl font-semibold text-gray-800">
                                R$ ${coin.preco.toFixed(2)}
                            </h2>
                        </div>
                        <div class="text-right mt-1">
                            <span class="${arrowColor}">
                                ${arrow} ${coin.var_24h_percent.toFixed(2)}%
                            </span>
                        </div>
                    `;
                });
                
            } catch (error) {
                console.error("Erro ao carregar top 10 Binance:", error);
                document.getElementById("top-cripto").innerText = "Erro ao carregar dados.";
            }
        }

        setInterval(atualizarCotacao, 20000);
        atualizarCotacao();

        async function carregarFundos() {
            try {
                const container = document.getElementById("top-ativos");
                const response = await fetch("http://192.168.1.77:5000/fundostop5");
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const fundos = await response.json();
                if (!Array.isArray(fundos)) throw new Error("Resposta inválida: não é um array");

                fundos.forEach(fundo => {
                    const id = `fundostop5-${fundo.symbol}`;
                    let div = document.getElementById(id);

                    if (!div) {
                        div = document.createElement("div");
                        div.id = id;
                        div.className = "shadow-md bg-gray-50 p-4 flex flex-col mb-2 rounded-xl";
                        container.appendChild(div);
                    }

                    div.innerHTML = `
                        <div class="flex justify-between items-center">
                            <h1 class="text-1xl font-bold text-gray-500">${fundo.shortName || fundo.symbol}</h1>
                            <h2 class="text-1xl font-semibold text-gray-800">R$ ${fundo.price?.toFixed(2) || '-'}</h2>
                        </div>
                        <div class="text-right mt-1">
                            <span class="${fundo.change_percent >= 0 ? 'text-green-600' : 'text-red-600'}">
                                ${fundo.change_percent >= 0 ? '▲' : '▼'} ${fundo.change_percent?.toFixed(2) || '0.00'}%
                            </span>
                        </div>
                    `;
                });

            } catch (error) {
                console.error("Erro ao carregar fundos:", error);
                const container = document.getElementById("top-ativos");
                container.innerText = "Erro ao carregar dados.";
            }
        }

        setInterval(carregarFundos, 20000);
        carregarFundos();



</script>
</body>
</html>
