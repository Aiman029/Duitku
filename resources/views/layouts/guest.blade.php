<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Duitku — Expense Tracker') }}</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50 selection:bg-teal-500 selection:text-white">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 sm:px-6 lg:px-8 relative overflow-hidden bg-gradient-to-br from-slate-900 via-[#10243E] to-slate-900">
            <!-- Decorative ambient light circles -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="w-full max-w-md relative z-10">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Duitku. Personal finance made simple.
            </div>
        </div>
    </body>
</html>
