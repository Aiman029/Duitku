```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'Duitku') : config('app.name', 'Duitku — Expense Tracker') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .brand-gradient { background: linear-gradient(135deg, #1B2A4B 0%, #14B8A6 55%, #10B981 100%); }
        .brand-text-gradient {
            background: linear-gradient(90deg, #1B2A4B 0%, #10B981 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased" x-cloak>

<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-50">

    {{-- ================= SIDEBAR ================= --}}
    <aside
        class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0F1B33] text-slate-200 flex flex-col transform transition-transform duration-200 ease-in-out
               md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- Brand --}}

    <div class="flex items-center gap-3 px-6 h-20 border-b border-white/10">
            <img src="{{ asset('images/logo.jpg') }}" alt="Duitku" class="w-9 h-9 rounded-full object-cover">
        <div>
        <p class="text-white font-bold leading-tight tracking-tight">duit<span class="text-[#14B8A6]">ku</span></p>
        <p class="text-[11px] text-slate-400 leading-tight">Personal Finance</p>
        </div>
    </div>

        {{-- Nav links --}}
        <nav class="flex-1 px-3 py-6 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border-l-2 border-[#14B8A6]' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('transactions.*') ? 'bg-white/10 text-white border-l-2 border-[#14B8A6]' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                Transactions
            </a>

            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('categories.*') ? 'bg-white/10 text-white border-l-2 border-[#14B8A6]' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 9V4a1 1 0 011-1z" />
                </svg>
                Categories
            </a>

            <a href="{{ route('budgets.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('budgets.*') ? 'bg-white/10 text-white border-l-2 border-[#14B8A6]' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" />
                </svg>
                Budget
            </a>

            <a href="{{ route('savings-goals.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('savings-goals.*') ? 'bg-white/10 text-white border-l-2 border-[#14B8A6]' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5-1.343 1.5-3 1.5m0-6V6m0 1.5v9m0 0V18m0-1.5c-1.657 0-3-.672-3-1.5M12 3a9 9 0 100 18 9 9 0 000-18z" />
                </svg>
                Savings Goals
            </a>
        </nav>

        {{-- User / logout --}}
        <div class="px-3 py-4 border-t border-white/10">
            <div class="flex items-center gap-3 px-3 py-2 mb-1">
                <div class="w-8 h-8 rounded-full brand-gradient flex items-center justify-center text-sm font-semibold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-white truncate">{{ Auth::user()->name }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-xs text-slate-400 hover:text-slate-200">Profile</a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-30 md:hidden"></div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="md:pl-64">

        {{-- Mobile top bar --}}
        <div class="md:hidden flex items-center justify-between px-4 h-16 bg-white border-b border-slate-200">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full brand-gradient flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H9M17 7V15" />
                    </svg>
                </div>
                <span class="font-bold text-slate-800">duit<span class="text-[#14B8A6]">ku</span></span>
            </div>

            <button @click="sidebarOpen = true" class="text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
```
