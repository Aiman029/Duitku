<x-guest-layout>
    <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-100 p-8 sm:p-10 transition-all">
        <!-- Brand Header -->
        <div class="flex flex-col items-center mb-8">
            <a href="/" class="group flex flex-col items-center focus:outline-none">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center shadow-lg shadow-teal-500/30 text-white font-extrabold text-2xl tracking-tight group-hover:scale-105 transition-transform duration-200">
                    D
                </div>
                <div class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                    duit<span class="text-teal-600">ku</span>
                </div>
            </a>
            <h1 class="text-xl font-bold text-slate-800 mt-4 tracking-tight">Welcome back</h1>
            <p class="text-xs text-slate-500 mt-1">Enter your credentials to access your finances</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5 text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-2.5 rounded-lg border border-emerald-200" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Email address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="you@example.com"
                           class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-150 @error('email') border-rose-300 bg-rose-50/30 text-rose-900 focus:ring-rose-500/20 focus:border-rose-500 @enderror" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Password
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-teal-600 hover:text-teal-700 hover:underline transition-colors" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-150 @error('password') border-rose-300 bg-rose-50/30 text-rose-900 focus:ring-rose-500/20 focus:border-rose-500 @enderror" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember"
                           class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500/30 transition">
                    <span class="ms-2 text-xs font-medium text-slate-600">Keep me logged in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 active:scale-[0.99] shadow-lg shadow-teal-600/25 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-150">
                <span>Sign in to account</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-700 hover:underline transition-colors ml-1">
                    Create free account
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
