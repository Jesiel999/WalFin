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
<body class="overflow-x-hidden">
    <aside id="sidebar"  class="sidebar bg-indigo-700 w-64 lg:w-16 text-white z-40 
         transition-all duration-300 flex flex-col h-screen fixed 
         top-0 left-0 uppercase tracking-wider 
         -translate-x-full lg:translate-x-0">
    @include('components.sidebar')
    </aside>

    <div id="mainContent" class="ml-0 lg:ml-16 flex-1 flex flex-col">
        @include('components.header')
        <main class="content flex-1 p-6">
            @if (session('errors'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach (session('errors') as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @yield('scripts')
    @if ($errors->any())
        <script>
            document.getElementById('category-modal').classList.remove("hidden");
            document.getElementById('pessoa-modal').classList.remove("hidden");
        </script>
    @endif
</body>
</html>
