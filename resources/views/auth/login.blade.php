<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Wirojek Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-slate-950 text-slate-100 relative overflow-hidden select-none">

    <!-- Decorative background elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-650/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-slate-900/30 rounded-full blur-3xl pointer-events-none border border-indigo-500/5"></div>

    <div class="w-full max-w-md p-6 sm:p-8 relative z-10">
        <!-- Glassmorphism Login Card -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800/80 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Top brand header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center p-3.5 bg-slate-950/60 rounded-2xl border border-slate-800 shadow-inner mb-4">
                    <!-- Dynamic logo container -->
                    <x-application-logo type="white" class="h-10 w-auto" />
                </div>
                <h2 class="text-2xl font-black tracking-widest text-white uppercase font-sans">WIROJEK</h2>
                <p class="text-slate-500 text-xs mt-1 uppercase tracking-widest font-bold">Administrasi Sistem</p>
            </div>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mb-5 p-4 text-xs font-semibold rounded-2xl bg-indigo-950/40 border border-indigo-900 text-indigo-400">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-5 p-4 text-xs font-semibold rounded-2xl bg-rose-950/40 border border-rose-900/50 text-rose-400 space-y-1">
                    <div class="font-bold">Gagal Masuk:</div>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div class="space-y-2">
                    <label for="email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Alamat Email</label>
                    <div class="relative rounded-2xl shadow-inner flex items-center">
                        <div class="absolute left-4 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            class="w-full rounded-2xl border-slate-800 bg-slate-950/60 py-3.5 pl-11 pr-4 text-sm text-slate-100 placeholder-slate-600 focus:border-indigo-500 focus:bg-slate-950 focus:ring-indigo-500 transition-all duration-200"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kata Sandi</label>
                    </div>
                    <div class="relative rounded-2xl shadow-inner flex items-center">
                        <div class="absolute left-4 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-2xl border-slate-800 bg-slate-950/60 py-3.5 pl-11 pr-4 text-sm text-slate-100 placeholder-slate-600 focus:border-indigo-500 focus:bg-slate-950 focus:ring-indigo-500 transition-all duration-200"
                            placeholder="Masukkan sandi Anda">
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-800 text-indigo-650 bg-slate-950 focus:ring-indigo-500 focus:ring-offset-slate-900 focus:ring-2">
                        <span class="ms-2 text-xs font-bold text-slate-400 tracking-wider">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-sm font-bold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transition-all duration-250">
                        Masuk Ke Panel
                    </button>
                </div>
            </form>
        </div>
        <!-- Footer Info -->
        <p class="text-center text-[10px] text-slate-600 uppercase tracking-widest font-bold mt-8">WIROJEK ECOSYSTEM &copy; 2026</p>
    </div>
</body>
</html>
