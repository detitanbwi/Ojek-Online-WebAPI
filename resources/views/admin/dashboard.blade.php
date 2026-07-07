<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-600 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        
        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Total Drivers Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Total Drivers</div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-slate-100">{{ $totalDrivers }}</div>
                    <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif dalam sistem
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Total Customers</div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-slate-100">{{ $totalCustomers }}</div>
                    <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        Terdaftar di aplikasi
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Total Orders</div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-slate-100">{{ $totalOrders }}</div>
                    <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        Transaksi perjalanan
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-650 dark:text-purple-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 12.408.01-.01H5.625a1.875 1.875 0 0 1-1.875-1.875V10.5m10.5-6h-3M5.625 7.5H9.75m-6.75 3h1.5" />
                    </svg>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg flex items-center justify-between group">
                <div class="space-y-1">
                    <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Total Platform Fee</div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-555"></span>
                        Pendapatan bersih admin
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- Live Status Metric Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-3xl p-8 relative overflow-hidden transition-colors duration-200">
            <h3 class="text-lg font-bold text-slate-900 dark:text-slate-200">Aktivitas Sistem Realtime</h3>
            <p class="text-sm text-slate-500 dark:text-slate-455 mt-1">Status dan aktivitas ekosistem Wirojek terpantau aktif secara otomatis.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6">
                <div class="border border-slate-150 dark:border-slate-800 rounded-2xl p-6 bg-slate-50 dark:bg-slate-950/40">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-300 mb-4 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                        Status Server
                    </h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-800/80 pb-2">
                            <span class="text-slate-500 dark:text-slate-400">Database Connection</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">Connected (SQLite)</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-800/80 pb-2">
                            <span class="text-slate-500 dark:text-slate-400">OneSignal Gateway</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">Online & Configured</span>
                        </div>
                        <div class="flex justify-between pb-1">
                            <span class="text-slate-500 dark:text-slate-400">Midtrans API Gateway</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">Sandbox Mode Active</span>
                        </div>
                    </div>
                </div>

                <div class="border border-slate-150 dark:border-slate-800 rounded-2xl p-6 bg-slate-50 dark:bg-slate-950/40">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-300 mb-4">Informasi Operasional</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-800/80 pb-2">
                            <span class="text-slate-500 dark:text-slate-400">Wilayah Layanan</span>
                            <span class="font-bold text-indigo-650 dark:text-indigo-400">Jember & Sekitarnya</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-800/80 pb-2">
                            <span class="text-slate-500 dark:text-slate-400">Admin Platform Share</span>
                            <span class="font-bold text-slate-700 dark:text-slate-200">{{ $commissionType === 'percentage' ? $commissionValue . '%' : 'Rp ' . number_format($commissionValue, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pb-1">
                            <span class="text-slate-500 dark:text-slate-400">Jam Operasional</span>
                            <span class="font-bold text-slate-700 dark:text-slate-200">24 Jam Realtime</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
