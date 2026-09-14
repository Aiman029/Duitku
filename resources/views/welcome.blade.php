<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duitku — Your Personal Finance Management</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .brand-gradient { background: linear-gradient(135deg, #1B2A4B 0%, #14B8A6 55%, #10B981 100%); }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50">

    {{-- ================= NAVBAR ================= --}}
    <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.jpg') }}" alt="Duitku" class="w-9 h-9 rounded-full object-cover">
            <span class="font-bold text-slate-800 text-lg">duit<span class="text-[#14B8A6]">ku</span></span>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-[#0F1B33] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-[#1B2A4B] transition">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-slate-600 text-sm font-medium hover:text-slate-900">
                    Log In
                </a>
                <a href="{{ route('register') }}"
                   class="bg-[#0F1B33] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-[#1B2A4B] transition">
                    Sign Up Free
                </a>
            @endauth
        </div>
    </nav>

    {{-- ================= HERO ================= --}}
    <section class="max-w-7xl mx-auto px-6 pt-16 pb-20 text-center">
        <span class="inline-block bg-[#14B8A6]/10 text-[#0d8a7c] text-xs font-semibold px-3 py-1 rounded-full mb-4">
            Built especially for all
        </span>

        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-4">
            Manage your pocket money,<br class="hidden md:block"> without the headache.
        </h1>

        <p class="text-slate-500 max-w-xl mx-auto mb-8">
            Track your income, expenses, and savings goals in one place.
            Easy to use and designed for student life.
        </p>

        <div class="flex items-center justify-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-[#0F1B33] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#1B2A4B] transition">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="brand-gradient text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition">
                    Get Started Free
                </a>

                <a href="{{ route('login') }}"
                   class="bg-white text-slate-700 border border-slate-200 px-6 py-3 rounded-lg font-medium hover:bg-slate-50 transition">
                    Log In
                </a>
            @endauth
        </div>
    </section>

    {{-- ================= FEATURES ================= --}}
    <section class="max-w-6xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="w-10 h-10 rounded-lg brand-gradient flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>

                <h3 class="font-semibold text-slate-800 mb-2">Clear Dashboard</h3>
                <p class="text-sm text-slate-500">
                    View your income, expenses, and spending trends through easy-to-understand charts.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="w-10 h-10 rounded-lg brand-gradient flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" />
                    </svg>
                </div>

                <h3 class="font-semibold text-slate-800 mb-2">Budget & Alerts</h3>
                <p class="text-sm text-slate-500">
                    Set monthly limits for each category and receive email notifications when your spending exceeds the limit.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="w-10 h-10 rounded-lg brand-gradient flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5-1.343 1.5-3 1.5m0-6V6m0 1.5v9m0 0V18m0-1.5c-1.657 0-3-.672-3-1.5M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                </div>

                <h3 class="font-semibold text-slate-800 mb-2">Savings Goals</h3>
                <p class="text-sm text-slate-500">
                    Set savings targets, such as a new laptop, and track your progress with a motivating visual progress bar.
                </p>
            </div>

        </div>
    </section>

    {{-- ================= FOOTER ================= --}}
    <footer class="border-t border-slate-100 py-6 text-center text-sm text-slate-400">
        duit<span class="text-[#14B8A6] font-semibold">ku</span> &copy; {{ date('Y') }} — Your Personal Finance Management.
    </footer>

</body>
</html>