<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tailwindcss.com"></script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    </head>
    <body class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
      style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">

    <div class="mb-6">
        <a href="/">
            <div class="flex items-center gap-2 text-white">
                <svg class="w-10 h-10 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h16v2H4V4zm2 4h2v2H6V8zm4 0h2v2h-2V8zm4 0h2v2h-2V8zm4 0h2v2h-2V8zM4 12h16v8H4v-8z"/>
                </svg>
                <span class="text-2xl font-bold tracking-wide">Cinema<span class="text-indigo-400">Admin</span></span>
            </div>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white/95 backdrop-blur shadow-2xl overflow-hidden sm:rounded-2xl border border-white/10">
        {{ $slot }}
    </div>

    <p class="mt-6 text-slate-400 text-sm">🎬 Manage your movie collection with ease</p>
</body>
</html>
