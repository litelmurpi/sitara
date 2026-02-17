<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} - SITARA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 min-h-screen relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-teal-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse" style="animation-delay: 2s"></div>
        <div class="absolute top-[20%] right-[20%] w-[30%] h-[30%] bg-amber-300/20 rounded-full blur-[100px] mix-blend-multiply animate-pulse" style="animation-delay: 4s"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center p-4">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>