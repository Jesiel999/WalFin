<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Financeiro - WallFin</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">
    @vite('resources/css/app.css')
</head>
    <body class="bg-gray-50 text-gray-800">

        <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-600">WallFin</h1>
                <div>
                    <a href="#planos" class="mx-3 text-gray-700 hover:text-blue-600">Planos</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Login</a>
                </div>
            </div>
        </nav>

        <section class="pt-24 pb-16 bg-gradient-to-r from-blue-50 to-blue-100 text-center">
            <h2 class="text-4xl font-extrabold mb-4 text-gray-800">Simplifique sua Gestão Financeira</h2>
            <p class="text-lg mb-6 text-gray-600">Organize suas finanças, controle receitas, despesas e tenha relatórios completos em tempo real.</p>
            <a href="#planos" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Ver Planos</a>
        </section>

        <section class="py-16 max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold mb-4 text-gray-800">Tudo o que você precisa em um só lugar</h3>
            <p class="text-gray-600 mb-10">Controle de receitas, despesas, relatórios personalizados e dashboards inteligentes para tomada de decisão.</p>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold mb-2 text-blue-600">Gestão Completa</h4>
                    <p class="text-gray-600">Tenha controle total de entradas, saídas e categorias financeiras.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold mb-2 text-blue-600">Relatórios Detalhados</h4>
                    <p class="text-gray-600">Acompanhe relatórios de desempenho financeiro e gráficos dinâmicos.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-semibold mb-2 text-blue-600">Segurança e Backup</h4>
                    <p class="text-gray-600">Seus dados sempre protegidos com criptografia e backups automáticos.</p>
                </div>
            </div>
        </section>

        <section class="planos py-8">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-center mb-6">Nossos Planos</h2>

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($plans as $plan)
                        <div class="bg-white shadow-lg rounded-2xl p-6 text-center w-72">
                            <h3 class="text-xl font-semibold mb-4">{{ $plan->plan_nome }}</h3>
                            <p class="text-2xl font-bold mb-4">R$ {{ number_format($plan->plan_valor, 2, ',', '.') }}</p>

                            <ul class="text-gray-600 text-left mb-6">
                                @foreach(explode(',', $plan->plan_descricao) as $descricao)
                                    <li>✔ {{ trim($descricao) }}</li>
                                @endforeach
                            </ul>

                            <a href="{{ route('assinar') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Assinar
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <footer class="bg-gray-800 text-white py-8">
            <div class="border-gray-700 text-center">
                <p>&copy; 2025 WallFin. Todos os direitos reservados.</p>
            </div>
        </footer>
    </body>
</html>
