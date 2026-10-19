<x-guest-layout>
    <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-100 p-8 sm:p-10 transition-all">
        <!-- Brand Header -->
        <div class="flex flex-col items-center mb-6">
            <a href="/" class="group flex flex-col items-center focus:outline-none">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center shadow-lg shadow-teal-500/30 text-white font-extrabold text-2xl tracking-tight group-hover:scale-105 transition-transform duration-200">
                    D
                </div>
                <div class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                    duit<span class="text-teal-600">ku</span>
                </div>
            </a>
            <h1 class="text-xl font-bold text-slate-800 mt-4 tracking-tight">Reset password</h1>
            <p class="text-xs text-slate-500 mt-1 text-center max-w-xs">
                Enter your registered email address and we'll send you a password reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5 text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-2.5 rounded-lg border border-emerald-200" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
                           placeholder="you@example.com"
                           class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-150 @error('email') border-rose-300 bg-rose-50/30 text-rose-900 focus:ring-rose-500/20 focus:border-rose-500 @enderror" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 active:scale-[0.99] shadow-lg shadow-teal-600/25 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-150">
                <span>Send reset link</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-teal-600 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back to sign in</span>
            </a>
        </div>
    </div>
</x-guest-layout>
