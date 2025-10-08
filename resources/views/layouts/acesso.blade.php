<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Meu App')</title>
    @vite(['resources/css/app.css', 'resources/js/acesso.js'])
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen flex flex-col bg-black bg-opacity-60">

    <main class="flex-grow flex items-center justify-center p-4">
        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>
