<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-950 via-slate-900 to-indigo-950 border-b border-slate-800/80 shadow-lg relative">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo type="white" class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-inner' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/30' }}">
                        <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        {{ __('Dashboard') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48" contentClasses="py-1 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-700/50 text-sm leading-4 font-semibold rounded-xl text-slate-300 bg-slate-800/40 hover:bg-slate-800/80 hover:text-white focus:outline-none transition ease-in-out duration-150 gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div>{{ Auth::user()?->name ?? 'Admin Guest' }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm font-semibold text-slate-300 hover:bg-slate-800/60 hover:text-white transition duration-150 ease-in-out">
                                {{ __('Profile') }}
                            </a>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                   class="block w-full px-4 py-2 text-start text-sm font-semibold text-rose-400 hover:bg-rose-950/20 hover:text-rose-300 transition duration-150 ease-in-out"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full px-4 py-2 text-start text-sm font-semibold text-slate-300 hover:bg-slate-800/60 hover:text-white transition duration-150 ease-in-out">
                                {{ __('Log In') }}
                            </a>
                            <a href="{{ route('register') }}" class="block w-full px-4 py-2 text-start text-sm font-semibold text-slate-300 hover:bg-slate-800/60 hover:text-white transition duration-150 ease-in-out">
                                {{ __('Register') }}
                            </a>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-950 border-t border-slate-800/80">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="block w-full pl-3 pr-4 py-2 border-l-4 text-start text-base font-bold transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/30' }}">
                {{ __('Dashboard') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-800/80">
            <div class="px-4">
                <div class="font-bold text-base text-slate-200">{{ Auth::user()?->name ?? 'Admin Guest' }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()?->email ?? 'admin@ojol.com' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <a href="{{ route('profile.edit') }}" 
                       class="block w-full pl-3 pr-4 py-2 text-start text-base font-semibold text-slate-400 hover:text-slate-200 hover:bg-slate-800/30 transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                           class="block w-full pl-3 pr-4 py-2 text-start text-base font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-950/20 transition duration-150 ease-in-out"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="block w-full pl-3 pr-4 py-2 text-start text-base font-semibold text-slate-400 hover:text-slate-200 hover:bg-slate-800/30 transition duration-150 ease-in-out">
                        {{ __('Log In') }}
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full pl-3 pr-4 py-2 text-start text-base font-semibold text-slate-400 hover:text-slate-200 hover:bg-slate-800/30 transition duration-150 ease-in-out">
                        {{ __('Register') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
