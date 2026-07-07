<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wirojek Admin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Script for Theme Prevention (Avoid FOUC) -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts & Styles -->
        @if (file_exists(public_path('build/manifest.json')))
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
                $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
                $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
            @endphp
            @if($cssFile)
                <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
            @endif
            @if($jsFile)
                <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
            @endif
        @else
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex transition-colors duration-200">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200/60 dark:border-slate-800 flex flex-col justify-between shrink-0 transition-colors duration-200">
            <div>
                <!-- Brand Logo & Header -->
                <div class="h-16 flex items-center px-6 border-b border-slate-200/60 dark:border-slate-800 gap-3">
                    <x-application-logo type="transparent" class="h-9 w-auto" />
                    <span class="font-black text-lg tracking-wider text-slate-900 dark:text-white">Wirojek</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1.5">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition duration-150 {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 12.408.01-.01H5.625a1.875 1.875 0 0 1-1.875-1.875V10.5m10.5-6h-3M5.625 7.5H9.75m-6.75 3h1.5" />
                        </svg>
                        Orders
                    </a>

                    <a href="{{ route('admin.accounts.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition duration-150 {{ request()->routeIs('admin.accounts.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                        Accounts
                    </a>

                    <a href="{{ route('admin.performance.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition duration-150 {{ request()->routeIs('admin.performance.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.173-.437.681-.437.854 0l1.96 4.93 5.38.442c.472.039.66.618.314.934l-4.02 3.67 1.05 5.3c.092.463-.41.83-.816.596L12 16.864l-4.837 2.796c-.407.234-.908-.133-.817-.597l1.05-5.3-4.02-3.67c-.347-.316-.16-.895.314-.934l5.38-.443 1.96-4.93z" />
                        </svg>
                        Performance
                    </a>

                    <a href="{{ route('admin.finance.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition duration-150 {{ request()->routeIs('admin.finance.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Finance
                    </a>
                </nav>
            </div>

            <!-- Footer User Profile Details & Sign Out -->
            <div class="p-4 border-t border-slate-200/60 dark:border-slate-800 space-y-3">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center font-extrabold text-sm text-slate-900 shadow-lg shadow-emerald-500/20">
                        {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ Auth::user()?->name ?? 'Admin Guest' }}</div>
                        <div class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()?->email ?? 'admin@ojol.com' }}</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('profile.edit') }}" class="flex justify-center items-center py-2 px-3 bg-slate-100 dark:bg-slate-850 hover:bg-slate-200 dark:hover:bg-slate-800 text-xs font-bold rounded-xl text-slate-700 dark:text-slate-300 transition">
                        Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center py-2 px-3 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-xs font-bold rounded-xl text-rose-600 dark:text-rose-400 transition">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-h-screen min-w-0">
            <!-- Top Navbar Header -->
            <header class="h-16 bg-white/70 dark:bg-slate-900/50 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800 px-8 flex items-center justify-between shrink-0 transition-colors duration-200">
                <div class="flex items-center gap-4">
                    @isset($header)
                        {{ $header }}
                    @else
                        <h1 class="text-lg font-bold text-slate-800 dark:text-slate-200">Wirojek Web Administration</h1>
                    @endisset
                </div>
                <div class="flex items-center gap-4">
                    <!-- Light/Dark Mode Switcher Toggle Button -->
                    <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-450 hover:bg-slate-100 dark:hover:bg-slate-850 focus:outline-none rounded-xl text-sm p-2 transition">
                        <!-- Dark Icon (Moon) -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <!-- Light Icon (Sun) -->
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.46 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 shadow-inner">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-555 dark:bg-emerald-400 mr-1.5 animate-pulse"></span>
                        Admin Server Live
                    </span>
                </div>
            </header>

            <!-- Main Scrollable Section -->
            <main class="flex-grow p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

        <!-- JS logic for Theme Switcher Toggle -->
        <script>
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            const themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }

                // if not set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        </script>
    </body>
</html>
