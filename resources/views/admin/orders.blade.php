<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-500 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Order Management') }}
        </h2>
    </x-slot>

    <!-- Session Messages -->
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-650 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left/Middle: Create Order & Map (Col-span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Create Order Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 sm:p-8 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 text-slate-800 dark:text-white border-b border-slate-200/60 dark:border-slate-800 relative">
                    <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-10 -translate-y-10 scale-150 text-indigo-600 dark:text-indigo-400">
                        <svg width="200" height="200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold tracking-wide">Buat Order Baru</h3>
                    <p class="text-indigo-600 dark:text-indigo-200 text-xs mt-1">Input rincian perjalanan untuk langsung dikirim ke driver terpilih.</p>
                </div>
                
                <!-- Custom CSS for Google Autocomplete and Map Container -->
                <style>
                    .pac-container {
                        border-radius: 1rem !important;
                        border: 1px solid #e2e8f0 !important;
                        background-color: #ffffff !important;
                        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
                        font-family: Figtree, ui-sans-serif, system-ui, sans-serif !important;
                        padding: 0.5rem 0 !important;
                        margin-top: 4px !important;
                        z-index: 9999 !important;
                        pointer-events: auto !important;
                    }
                    .dark .pac-container {
                        border: 1px solid #1e293b !important;
                        background-color: #0f172a !important;
                        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.4) !important;
                    }
                    .pac-item {
                        padding: 8px 16px !important;
                        font-size: 0.875rem !important;
                        color: #4b5563 !important;
                        border-top: 1px solid #e5e7eb !important;
                        cursor: pointer !important;
                        pointer-events: auto !important;
                    }
                    .dark .pac-item {
                        color: #94a3b8 !important;
                        border-top: 1px solid #1e293b !important;
                    }
                    .pac-item:hover {
                        background-color: #f3f4f6 !important;
                        color: #111827 !important;
                    }
                    .dark .pac-item:hover {
                        background-color: #1e293b !important;
                        color: #f1f5f9 !important;
                    }
                    .pac-item-query {
                        font-size: 0.875rem !important;
                        color: #111827 !important;
                    }
                    .dark .pac-item-query {
                        color: #f1f5f9 !important;
                    }
                    .pac-matched {
                        color: #4f46e5 !important;
                        font-weight: 600 !important;
                    }
                    .dark .pac-matched {
                        color: #6366f1 !important;
                    }
                </style>

                <form id="createOrderForm" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        
                        <!-- Form Fields (Left Column) -->
                        <div class="lg:col-span-5 space-y-6">
                            <div>
                                <label for="origin" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Titik Jemput (Origin)</label>
                                <div class="relative rounded-2xl shadow-sm flex items-center">
                                    <input type="text" id="origin" name="origin" required
                                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 pl-4 pr-32 text-slate-850 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm"
                                        placeholder="Cari lokasi atau klik Pilih...">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <button type="button" id="pickOriginOnMapBtn" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Pilih
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="destination" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Titik Tujuan (Destination)</label>
                                <div class="relative rounded-2xl shadow-sm flex items-center">
                                    <input type="text" id="destination" name="destination" required
                                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 pl-4 pr-32 text-slate-850 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm"
                                        placeholder="Cari lokasi atau klik Pilih...">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <button type="button" id="pickDestOnMapBtn" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Pilih
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tarif (Rupiah)</label>
                                    <div class="relative rounded-2xl shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="text-slate-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" id="price" name="price" required min="0"
                                            class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 pl-10 pr-4 text-slate-850 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm font-bold text-indigo-600 dark:text-indigo-400"
                                            placeholder="Tarif otomatis">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="driver_id" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Pilih Driver</label>
                                    <select id="driver_id" name="driver_id" required
                                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 px-4 text-slate-850 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm">
                                        <option class="bg-white dark:bg-slate-905" value="">-- Pilih Driver --</option>
                                        @foreach($drivers->where('status_online', true) as $driver)
                                            <option class="bg-white dark:bg-slate-905" value="{{ $driver->id }}">
                                                {{ $driver->name }} ({{ $driver->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="passenger_name" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Penumpang (Opsional)</label>
                                    <input type="text" id="passenger_name" name="passenger_name"
                                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 px-4 text-slate-850 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm"
                                        placeholder="Nama penumpang acak">
                                </div>
                                <div>
                                    <label for="payment_type" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Pembayaran</label>
                                    <select id="payment_type" name="payment_type" required
                                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 px-4 text-slate-855 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200 text-sm font-semibold">
                                        <option class="bg-white dark:bg-slate-905" value="cash">💵 Tunai (Cash)</option>
                                        <option class="bg-white dark:bg-slate-905" value="qris">📱 QRIS (Midtrans)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Fare Breakdown -->
                            <div id="fareBreakdown" class="hidden rounded-2xl p-4 text-xs bg-indigo-50 dark:bg-indigo-950/60 text-indigo-900 dark:text-indigo-300 border border-indigo-150 dark:border-indigo-900/50 space-y-1">
                                <!-- Will be populated dynamically -->
                            </div>
                            
                            <!-- Response Message -->
                            <div id="responseMessage" class="hidden rounded-2xl p-4 text-sm transition-all duration-300"></div>
                            
                            <div class="flex justify-end pt-2">
                                <button type="submit" id="submitBtn"
                                    class="relative overflow-hidden group w-full inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-sm font-semibold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 transition-all duration-200">
                                    <span class="relative z-10 flex items-center gap-2">
                                        Kirim Orderan
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Map Section (Right Column) -->
                        <div class="lg:col-span-7 flex flex-col h-full min-h-[450px] border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden relative shadow-inner bg-slate-100 dark:bg-slate-950">
                            <!-- API Key Configuration Panel -->
                            <div id="apiKeyConfigCard" class="hidden absolute inset-0 z-50 bg-slate-900/95 dark:bg-slate-950/95 backdrop-blur-sm p-6 flex flex-col justify-center items-center text-white text-center">
                                <svg class="w-12 h-12 text-indigo-400 mb-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"/></svg>
                                <h4 class="text-lg font-bold">Google Maps API Key Diperlukan</h4>
                                <p class="text-xs text-slate-400 max-w-sm mt-1 mb-6">Tambahkan GOOGLE_MAPS_API_KEY di file .env atau masukkan di bawah ini untuk menggunakannya sekarang.</p>
                                <div class="w-full max-w-xs space-y-3">
                                    <input type="password" id="tempApiKeyInput" class="w-full rounded-xl border-slate-700 bg-slate-800 text-white placeholder-slate-500 py-2.5 px-4 focus:ring-indigo-500 focus:border-indigo-500 text-xs text-center" placeholder="Masukkan Google Maps API Key...">
                                    <button type="button" id="saveApiKeyBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-2.5 text-xs font-bold transition-all shadow-md">Simpan & Aktifkan Peta</button>
                                </div>
                            </div>

                            <!-- The Map Element -->
                            <div id="map" class="w-full h-full flex-grow min-h-[380px]"></div>

                            <!-- Instructional floating banner -->
                            <div class="absolute top-3 left-3 right-3 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-md border border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs text-slate-800 dark:text-slate-200 z-10">
                                <div id="mapInstruction" class="flex items-center gap-2">
                                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 dark:bg-indigo-400 animate-ping"></span>
                                    <span id="instructionText">Klik peta untuk meletakkan <b>Titik A (Jemput)</b>.</span>
                                </div>
                                <button type="button" id="resetMarkersBtn" class="text-rose-600 dark:text-rose-400 font-bold hover:underline hidden">Reset Rute</button>
                            </div>

                            <!-- Floating Status Indicator -->
                            <div id="mapStatusOverlay" class="absolute bottom-3 left-3 bg-white/90 dark:bg-slate-900/90 text-slate-850 dark:text-white px-3.5 py-2 rounded-xl text-xs font-semibold shadow-md flex items-center gap-2 z-10 hidden border border-slate-200 dark:border-slate-800">
                                <span id="mapStatusText">Menghitung rute...</span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

        <!-- Right: Driver Status & Commission Settings (Col-span 1) -->
        <div class="space-y-8">
            <!-- Status Driver Online -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200/60 dark:border-slate-800 text-slate-800 dark:text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-slate-700 dark:text-white">
                        <svg width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold tracking-wide">Driver Online</h3>
                    <p class="text-slate-500 dark:text-indigo-200 text-xs mt-1">Monitor driver terdaftar dan status online.</p>
                </div>
                
                <div id="driverListContainer" class="divide-y divide-slate-150 dark:divide-slate-800 max-h-[300px] overflow-y-auto">
                    @forelse($drivers->where('status_online', true) as $driver)
                        <div class="p-5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-all duration-150">
                            <div class="space-y-1">
                                <div class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                    {{ $driver->name }}
                                    <span class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 00.996.808H10.5a1 1 0 01.96.697l1.037 3.111a1 1 0 01-.004.814l-1.04 3.119a1 1 0 01-.962.678h-2.17a1 1 0 00-.996.808l-.548 2.2a1 1 0 01-.94.725H5a2 2 0 01-2-2V5z"/></svg>
                                    {{ $driver->phone }}
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <button onclick="detachDriver({{ $driver->id }})" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold rounded-xl text-rose-605 dark:text-rose-400 bg-rose-50 dark:bg-rose-955/50 hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-colors border border-rose-200 dark:border-rose-900/50">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Detach
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-450 dark:text-slate-500 text-sm">Tidak ada driver online saat ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- Commission Settings Panel -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200/60 dark:border-slate-800 text-slate-800 dark:text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-slate-700 dark:text-white">
                        <svg width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold tracking-wide">Pengaturan Komisi</h3>
                    <p class="text-slate-550 dark:text-indigo-200 text-xs mt-1">Atur besaran potongan komisi platform per orderan.</p>
                </div>
                <form action="{{ route('admin.settings.save') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label for="commission_type" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Komisi</label>
                        <select name="commission_type" id="commission_type" onchange="toggleRoundingOption()"
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200">
                            <option class="bg-white dark:bg-slate-905" value="percentage" {{ ($settings['commission_type'] ?? '') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option class="bg-white dark:bg-slate-905" value="fixed" {{ ($settings['commission_type'] ?? '') === 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rupiah)</option>
                        </select>
                    </div>
                    <div>
                        <label for="commission_value" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nilai Potongan</label>
                        <input type="number" name="commission_value" id="commission_value" value="{{ $settings['commission_value'] ?? '10' }}" min="0" required
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-3 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200">
                    </div>
                    <div id="roundOptionContainer" class="{{ ($settings['commission_type'] ?? 'percentage') === 'fixed' ? 'hidden' : '' }}">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="round_hundreds_down" value="true" class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 bg-white dark:bg-slate-950 focus:ring-indigo-500" {{ ($settings['round_hundreds_down'] ?? 'true') === 'true' ? 'checked' : '' }}>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Bulatkan komisi ke ratusan kebawah</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-600/10">Simpan Pengaturan</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Row 2: Recent Orders List (Full Width) -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg mt-8">
        <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 text-slate-800 dark:text-white border-b border-slate-200/60 dark:border-slate-800 relative overflow-hidden flex items-center justify-between">
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-slate-700 dark:text-white">
                <svg width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                </svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold tracking-wide">Daftar Order Terkini</h3>
                <p class="text-slate-500 dark:text-indigo-200 text-xs mt-1">Menampilkan daftar order yang dibuat dalam sistem.</p>
            </div>
            <button onclick="window.location.reload()" class="relative z-10 p-2 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/20 text-slate-700 dark:text-white border border-slate-200 dark:border-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                </svg>
            </button>
        </div>

        <!-- Date Filter Form -->
        <div class="p-6 bg-slate-50/50 dark:bg-slate-950/20 border-b border-slate-200/60 dark:border-slate-800">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-2 px-4 text-xs text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-2 px-4 text-xs text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200">
                </div>
                <div>
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-600/10">Filter Pesanan</button>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Driver</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rute (Jemput → Tujuan)</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tarif Cust</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Net Driver</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pot Admin</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Waktu</th>
                        <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody" class="divide-y divide-slate-150 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="p-4 font-mono font-semibold text-indigo-650 dark:text-indigo-400">#{{ $order->id }}</td>
                            <td class="p-4 font-medium">{{ $order->driver->name ?? 'N/A' }}</td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800 dark:text-slate-200 truncate max-w-xs" title="{{ $order->origin }}">{{ $order->origin }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs" title="{{ $order->destination }}">→ {{ $order->destination }}</div>
                            </td>
                            <td class="p-4 font-semibold text-slate-900 dark:text-slate-200">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                            <td class="p-4 font-semibold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($order->driver_fare, 0, ',', '.') }}</td>
                            <td class="p-4 font-semibold text-rose-600 dark:text-rose-400">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</td>
                            <td class="p-4">
                                @if($order->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-500/10 text-amber-800 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">Pending</span>
                                @elseif($order->status === 'accepted')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 dark:bg-indigo-500/10 text-indigo-855 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20">Accepted</span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 dark:bg-rose-500/10 text-rose-800 dark:text-rose-455 border border-rose-200 dark:border-rose-500/20">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-slate-500">{{ $order->created_at->diffForHumans() }}</td>
                            <td class="p-4 text-center">
                                <button onclick="viewOrderDetail({{ $order->id }})" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-650 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors">Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-450 dark:text-slate-500 text-sm">Belum ada orderan yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->

    <!-- Order Detail Modal -->
    <div id="orderDetailModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all duration-300" style="max-width: 512px;">
            <div class="p-6 text-slate-900 dark:text-white flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold">Detail Orderan <span id="detail_order_id"></span></h3>
                <button onclick="closeOrderDetailModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-6">
                <div class="space-y-3">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Titik Jemput (Origin)</span>
                        <span id="detail_origin" class="text-sm font-semibold text-slate-800 dark:text-slate-200"></span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Titik Tujuan (Destination)</span>
                        <span id="detail_destination" class="text-sm font-semibold text-slate-800 dark:text-slate-200"></span>
                    </div>
                </div>
                <div class="border-t border-slate-150 dark:border-slate-800 pt-4 grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Driver</span>
                        <span id="detail_driver_name" class="text-sm font-semibold text-slate-805 dark:text-slate-200"></span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Status</span>
                        <div id="detail_status_container" class="mt-1"></div>
                    </div>
                </div>
                <div class="border-t border-slate-150 dark:border-slate-800 pt-4 grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Nama Penumpang</span>
                        <span id="detail_passenger_name" class="text-sm font-semibold text-slate-800 dark:text-slate-200"></span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-500">Metode Bayar</span>
                        <span id="detail_payment_type" class="text-sm font-semibold text-slate-800 dark:text-slate-200"></span>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-950/60 rounded-2xl p-4 space-y-2 border border-slate-150 dark:border-slate-800">
                    <span class="block text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 mb-1">Rincian Komisi</span>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-550 dark:text-slate-400">Tarif Penumpang (Customer Pays):</span>
                        <span id="detail_price" class="font-bold text-slate-800 dark:text-slate-200"></span>
                    </div>
                    <div class="flex justify-between text-xs text-rose-600 dark:text-rose-400">
                        <span>Potongan Admin (Platform Cut):</span>
                        <span id="detail_admin_fee" class="font-semibold"></span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-emerald-600 dark:text-emerald-450 border-t border-slate-200 dark:border-slate-800 pt-2">
                        <span>Pendapatan Bersih Driver:</span>
                        <span id="detail_driver_fare"></span>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-slate-50 dark:bg-slate-950/30 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-3">
                <button id="repeatOrderBtn" onclick="triggerRepeatOrder()" class="hidden px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold shadow-md transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.656 48.656 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                    </svg>
                    Pesan Ulang
                </button>
                <button onclick="closeOrderDetailModal()" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md hover:bg-indigo-700 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Custom Detach Modal -->
    <div id="detachModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Container -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-slate-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-800">
                <div class="bg-white dark:bg-slate-900 px-6 pb-6 pt-8 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start">
                        <!-- Icon Warning -->
                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 dark:bg-rose-950 text-rose-600 dark:text-rose-455 sm:mx-0 sm:h-12 sm:w-12 border border-rose-200 dark:border-rose-900/50">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title">Konfirmasi Detach</h3>
                            <div class="mt-3">
                                <p class="text-sm text-slate-500 dark:text-slate-400">Apakah Anda yakin ingin memutuskan (detach) pengemudi ini? Driver akan otomatis terputus dari sistem admin dan dialihkan ke status offline secara realtime.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" id="confirmDetachBtn" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors">Ya, Detach</button>
                    <button type="button" onclick="closeDetachModal()" class="inline-flex w-full justify-center rounded-xl bg-slate-100 dark:bg-slate-800 px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-200 sm:w-auto transition-colors">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to handle AJAX Order Creation & Google Maps Integration -->
    <script>
        // Google Maps integration variables
        let map;
        let originMarker = null;
        let destinationMarker = null;
        let directionsService;
        let directionsRenderer;
        let geocoder;
        let originAutocomplete;
        let destinationAutocomplete;
        let pendingPoint = null;

        // Helper function for currency formatting
        function formatRupiah(number) {
            return 'Rp ' + parseFloat(number || 0).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }
        
        // Dynamic Script Loader for Google Maps JS API
        window.addEventListener('DOMContentLoaded', () => {
            const configKey = "{{ config('services.google.maps_api_key') }}";
            const storedKey = localStorage.getItem('google_maps_api_key');
            const mapsApiKey = configKey || storedKey;
            
            if (!mapsApiKey) {
                // Show prompt card to let user insert key temporarily
                const configCard = document.getElementById('apiKeyConfigCard');
                configCard.classList.remove('hidden');
                
                document.getElementById('saveApiKeyBtn').addEventListener('click', () => {
                    const enteredKey = document.getElementById('tempApiKeyInput').value.trim();
                    if (enteredKey) {
                        localStorage.setItem('google_maps_api_key', enteredKey);
                        window.location.reload();
                    }
                });
            } else {
                loadGoogleMapsScript(mapsApiKey);
            }
        });

        function loadGoogleMapsScript(key) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${key}&libraries=places,geometry&callback=initMap`;
            script.async = true;
            script.defer = true;
            script.onerror = () => {
                alert("Gagal memuat Google Maps API. Silakan periksa koneksi internet atau Kunci API Anda.");
            };
            document.head.appendChild(script);
        }

        // Initialize Google Map
        function initMap() {
            // Default center: Jember, East Java
            const defaultCenter = { lat: -8.184486, lng: 113.668076 };
            
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: defaultCenter,
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#7c8b9a"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{"color": "#c7e2ef"}]
                    }
                ]
            });
            
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                draggable: true,
                suppressMarkers: false
            });
            
            // Listen to route/endpoint dragging and recalculate
            directionsRenderer.addListener('directions_changed', () => {
                const directions = directionsRenderer.getDirections();
                if (directions && directions.routes && directions.routes[0]) {
                    const route = directions.routes[0].legs[0];
                    
                    document.getElementById('origin').value = route.start_address;
                    document.getElementById('destination').value = route.end_address;
                    
                    if (originMarker) originMarker.setPosition(route.start_location);
                    if (destinationMarker) destinationMarker.setPosition(route.end_location);
                    
                    const distanceMeters = route.distance.value;
                    const distanceKm = distanceMeters / 1000;
                    const ceilKm = Math.ceil(distanceKm);
                    
                    let price = 8000;
                    if (ceilKm > 3) {
                        price = 8000 + (ceilKm - 3) * 3000;
                    }
                    
                    document.getElementById('price').value = price;
                    showFareBreakdown(distanceKm, ceilKm, price);
                    
                    document.getElementById('mapStatusOverlay').classList.remove('hidden');
                    document.getElementById('mapStatusText').textContent = `Jarak: ${distanceKm.toFixed(2)} km (${ceilKm} km)`;
                }
            });
            
            geocoder = new google.maps.Geocoder();
            
            map.addListener('click', (event) => {
                const clickedLocation = event.latLng;
                if (pendingPoint === 'A') {
                    if (originMarker) originMarker.setMap(null);
                    originMarker = createMarker(clickedLocation, 'A');
                    reverseGeocode(clickedLocation, 'origin');
                    pendingPoint = null;
                    document.getElementById('instructionText').innerHTML = 'Klik peta untuk menentukan <b>Titik B (Tujuan)</b> atau isi kolom tujuan.';
                } else if (pendingPoint === 'B') {
                    if (destinationMarker) destinationMarker.setMap(null);
                    destinationMarker = createMarker(clickedLocation, 'B');
                    reverseGeocode(clickedLocation, 'destination');
                    pendingPoint = null;
                } else {
                    handleMapClick(clickedLocation);
                }
            });
            
            document.getElementById('pickOriginOnMapBtn').addEventListener('click', () => {
                pendingPoint = 'A';
                document.getElementById('instructionText').innerHTML = 'Silakan klik di peta untuk menentukan <b>Titik A (Jemput)</b>.';
                document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
            });
            
            document.getElementById('pickDestOnMapBtn').addEventListener('click', () => {
                pendingPoint = 'B';
                document.getElementById('instructionText').innerHTML = 'Silakan klik di peta untuk menentukan <b>Titik B (Tujuan)</b>.';
                document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
            });
            
            initAutocompletes();
            document.getElementById('resetMarkersBtn').addEventListener('click', resetRouting);
        }

        function initAutocompletes() {
            const originInput = document.getElementById('origin');
            const destInput = document.getElementById('destination');
            
            originAutocomplete = new google.maps.places.Autocomplete(originInput);
            destinationAutocomplete = new google.maps.places.Autocomplete(destInput);
            
            originAutocomplete.bindTo('bounds', map);
            destinationAutocomplete.bindTo('bounds', map);
            
            originAutocomplete.addListener('place_changed', () => {
                const place = originAutocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    return;
                }
                
                if (!originMarker) {
                    originMarker = createMarker(place.geometry.location, 'A');
                } else {
                    originMarker.setPosition(place.geometry.location);
                    originMarker.setMap(map);
                }
                
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                
                updateRouting();
            });
            
            destinationAutocomplete.addListener('place_changed', () => {
                const place = destinationAutocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    return;
                }
                
                if (!destinationMarker) {
                    destinationMarker = createMarker(place.geometry.location, 'B');
                } else {
                    destinationMarker.setPosition(place.geometry.location);
                    destinationMarker.setMap(map);
                }
                
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                
                updateRouting();
            });
        }

        function createMarker(position, label) {
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                label: label,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            
            marker.addListener('dragend', () => {
                reverseGeocode(marker.getPosition(), label === 'A' ? 'origin' : 'destination');
            });
            
            return marker;
        }

        function handleMapClick(latLng) {
            const instructionText = document.getElementById('instructionText');
            
            if (!originMarker) {
                originMarker = createMarker(latLng, 'A');
                reverseGeocode(latLng, 'origin');
                instructionText.innerHTML = 'Klik peta untuk meletakkan <b>Titik B (Tujuan)</b>.';
            } else if (!destinationMarker) {
                destinationMarker = createMarker(latLng, 'B');
                reverseGeocode(latLng, 'destination');
                updateRouting();
            } else {
                resetRouting();
                originMarker = createMarker(latLng, 'A');
                reverseGeocode(latLng, 'origin');
                instructionText.innerHTML = 'Klik peta untuk meletakkan <b>Titik B (Tujuan)</b>.';
            }
        }

        function reverseGeocode(latLng, inputId) {
            geocoder.geocode({ location: latLng }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    document.getElementById(inputId).value = results[0].formatted_address;
                    if (originMarker && destinationMarker) {
                        updateRouting();
                    }
                } else {
                    console.error('Geocoder failed due to: ' + status);
                }
            });
        }

        function showFareBreakdown(distanceKm, ceilKm, price) {
            const fareBreakdown = document.getElementById('fareBreakdown');
            fareBreakdown.classList.remove('hidden');
            if (ceilKm <= 3) {
                fareBreakdown.innerHTML = `
                    <div class="font-bold flex justify-between"><span>Jarak Aktual:</span> <span>${distanceKm.toFixed(2)} Km</span></div>
                    <div class="font-bold flex justify-between text-indigo-650 dark:text-indigo-400"><span>Jarak Bulat:</span> <span>${ceilKm} Km</span></div>
                    <hr class="my-1 border-slate-200 dark:border-indigo-900">
                    <div class="flex justify-between font-bold text-indigo-700 dark:text-indigo-300 text-sm mt-0.5"><span>Tarif Flat (≤ 3 Km):</span> <span>Rp 8.000</span></div>
                `;
            } else {
                const extraKm = ceilKm - 3;
                const extraPrice = extraKm * 3000;
                fareBreakdown.innerHTML = `
                    <div class="font-bold flex justify-between"><span>Jarak Aktual:</span> <span>${distanceKm.toFixed(2)} Km</span></div>
                    <div class="font-bold flex justify-between text-indigo-650 dark:text-indigo-400"><span>Jarak Bulat:</span> <span>${ceilKm} Km</span></div>
                    <hr class="my-1 border-slate-200 dark:border-indigo-900">
                    <div class="flex justify-between"><span>3 Km Pertama (Flat):</span> <span>Rp 8.000</span></div>
                    <div class="flex justify-between"><span>Sisa ${extraKm} Km (${extraKm} x Rp 3.000):</span> <span>${formatRupiah(extraPrice)}</span></div>
                    <hr class="my-1 border-slate-200 dark:border-indigo-900">
                    <div class="flex justify-between font-bold text-indigo-700 dark:text-indigo-300 text-sm mt-0.5"><span>Total Tarif:</span> <span>${formatRupiah(price)}</span></div>
                `;
            }
        }

        function updateRouting() {
            if (!originMarker || !destinationMarker) return;
            
            const request = {
                origin: originMarker.getPosition(),
                destination: destinationMarker.getPosition(),
                travelMode: 'DRIVING'
            };
            
            const statusOverlay = document.getElementById('mapStatusOverlay');
            const statusText = document.getElementById('mapStatusText');
            statusOverlay.classList.remove('hidden');
            statusText.textContent = 'Menghitung rute...';
            
            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    originMarker.setMap(null);
                    destinationMarker.setMap(null);
                    
                    const distanceMeters = result.routes[0].legs[0].distance.value;
                    const distanceKm = distanceMeters / 1000;
                    const ceilKm = Math.ceil(distanceKm);
                    let price = 8000;
                    if (ceilKm > 3) {
                        price = 8000 + (ceilKm - 3) * 3000;
                    }
                    
                    document.getElementById('price').value = price;
                    showFareBreakdown(distanceKm, ceilKm, price);
                    
                    statusText.textContent = `Jarak: ${distanceKm.toFixed(2)} km (${ceilKm} km)`;
                    document.getElementById('resetMarkersBtn').classList.remove('hidden');
                    document.getElementById('instructionText').innerHTML = 'Rute berhasil dibuat! Geser penanda atau ubah alamat untuk memperbarui.';
                } else {
                    statusText.textContent = 'Gagal menghitung rute.';
                    console.error('Directions request failed due to ' + status);
                }
            });
        }

        function resetRouting() {
            if (originMarker) originMarker.setMap(null);
            if (destinationMarker) destinationMarker.setMap(null);
            
            originMarker = null;
            destinationMarker = null;
            
            directionsRenderer.setDirections(null);
            
            document.getElementById('origin').value = '';
            document.getElementById('destination').value = '';
            document.getElementById('price').value = '';
            
            document.getElementById('fareBreakdown').classList.add('hidden');
            document.getElementById('resetMarkersBtn').classList.add('hidden');
            document.getElementById('mapStatusOverlay').classList.add('hidden');
            document.getElementById('instructionText').innerHTML = 'Klik peta untuk meletakkan <b>Titik A (Jemput)</b>.';
            
            map.setZoom(12);
        }

        // Form Submission logic
        document.getElementById('createOrderForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const responseMsg = document.getElementById('responseMessage');
            const form = e.target;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            `;
            
            responseMsg.className = 'hidden';
            
            const formData = {
                origin: document.getElementById('origin').value,
                destination: document.getElementById('destination').value,
                price: document.getElementById('price').value,
                driver_id: document.getElementById('driver_id').value,
                passenger_name: document.getElementById('passenger_name').value,
                payment_type: document.getElementById('payment_type').value,
                _token: form.querySelector('input[name="_token"]').value
            };
            
            try {
                const response = await fetch('{{ url('api/admin/create-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData._token
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    responseMsg.className = 'block rounded-2xl p-4 text-sm bg-emerald-50 dark:bg-emerald-955/50 text-emerald-800 dark:text-emerald-300 border border-emerald-250 dark:border-emerald-900 space-y-1';
                    
                    let notificationStatus = '';
                    if (result.data.notification_sent) {
                        notificationStatus = '⚡ Notifikasi OneSignal berhasil dikirim ke driver!';
                    } else {
                        notificationStatus = `⚠️ Order dibuat, namun notifikasi gagal dikirim: ${result.data.notification_error}`;
                    }
                    
                    responseMsg.innerHTML = `
                        <div class="font-bold">Order Berhasil Dibuat!</div>
                        <div>ID Order: #${result.data.order.id}</div>
                        <div class="text-xs mt-1 font-semibold">${notificationStatus}</div>
                    `;
                    
                    form.reset();
                    resetRouting();
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    responseMsg.className = 'block rounded-2xl p-4 text-sm bg-rose-50 dark:bg-rose-955/50 text-rose-800 dark:text-rose-350 border border-rose-250 dark:border-rose-900';
                    let errorsHtml = '';
                    if (result.errors) {
                        errorsHtml = '<ul class="list-disc pl-5 mt-1">';
                        for (const field in result.errors) {
                            errorsHtml += `<li>${result.errors[field].join(', ')}</li>`;
                        }
                        errorsHtml += '</ul>';
                    }
                    responseMsg.innerHTML = `
                        <div class="font-bold">${result.message || 'Gagal membuat order'}</div>
                        ${errorsHtml}
                    `;
                }
            } catch (error) {
                responseMsg.className = 'block rounded-2xl p-4 text-sm bg-rose-50 dark:bg-rose-955/50 text-rose-800 dark:text-rose-350 border border-rose-250 dark:border-rose-900';
                responseMsg.innerHTML = `<div class="font-bold">Error: ${error.message}</div>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <span class="relative z-10 flex items-center gap-2">
                        Kirim Orderan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                `;
            }
        });

        // Detach Driver & details logic
        async function refreshOrdersData() {
            try {
                const response = await fetch(window.location.href);
                if (response.ok) {
                    const htmlText = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(htmlText, 'text/html');
                    
                    const newTableBody = doc.getElementById('ordersTableBody');
                    const currentTableBody = document.getElementById('ordersTableBody');
                    if (newTableBody && currentTableBody) {
                        currentTableBody.innerHTML = newTableBody.innerHTML;
                    }
                    
                    const newDriverList = doc.getElementById('driverListContainer');
                    const currentDriverList = document.getElementById('driverListContainer');
                    if (newDriverList && currentDriverList) {
                        currentDriverList.innerHTML = newDriverList.innerHTML;
                    }

                    const newDriverSelect = doc.getElementById('driver_id');
                    const currentDriverSelect = document.getElementById('driver_id');
                    if (newDriverSelect && currentDriverSelect) {
                        const currentValue = currentDriverSelect.value;
                        currentDriverSelect.innerHTML = newDriverSelect.innerHTML;
                        currentDriverSelect.value = currentValue;
                    }
                }
            } catch (e) {
                console.error("Auto refresh failed", e);
            }
        }

        let pendingDetachDriverId = null;
        
        function detachDriver(driverId) {
            pendingDetachDriverId = driverId;
            document.getElementById('detachModal').classList.remove('hidden');
        }

        function closeDetachModal() {
            document.getElementById('detachModal').classList.add('hidden');
            pendingDetachDriverId = null;
        }

        document.getElementById('confirmDetachBtn').addEventListener('click', async () => {
            if (!pendingDetachDriverId) return;
            const driverId = pendingDetachDriverId;
            closeDetachModal();
            
            try {
                const response = await fetch('{{ url('api/admin/driver/detach') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ driver_id: driverId })
                });
                const result = await response.json();
                if (result.success) {
                    refreshOrdersData();
                } else {
                    alert(result.message || "Gagal melakukan detach.");
                }
            } catch (e) {
                console.error("Error detaching driver:", e);
            }
        });

        // Commission rounded options toggle
        function toggleRoundingOption() {
            const type = document.getElementById('commission_type').value;
            const container = document.getElementById('roundOptionContainer');
            if (type === 'percentage') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        // Details Modal logic
        window.currentSelectedOrder = null;

        async function viewOrderDetail(orderId) {
            try {
                const res = await fetch(`{{ url('admin/orders') }}/${orderId}`);
                const result = await res.json();
                if (result.success) {
                    const order = result.data;
                    window.currentSelectedOrder = order;
                    document.getElementById('detail_order_id').innerText = `#${order.id}`;
                    document.getElementById('detail_origin').innerText = order.origin;
                    document.getElementById('detail_destination').innerText = order.destination;
                    document.getElementById('detail_driver_name').innerText = order.driver ? order.driver.name : 'Belum diambil';
                    document.getElementById('detail_passenger_name').innerText = order.passenger_name || 'N/A';
                    document.getElementById('detail_payment_type').innerText = order.payment_type === 'qris' ? '📱 QRIS (Midtrans)' : '💵 Tunai (Cash)';
                    
                    document.getElementById('detail_price').innerText = formatRupiah(order.price);
                    document.getElementById('detail_admin_fee').innerText = `- ${formatRupiah(order.admin_fee || 0)}`;
                    document.getElementById('detail_driver_fare').innerText = formatRupiah(order.driver_fare || 0);

                    let badgeHtml = '';
                    if (order.status === 'pending') {
                        badgeHtml = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-500/10 text-amber-800 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">Pending</span>';
                    } else if (order.status === 'accepted') {
                        badgeHtml = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 dark:bg-indigo-500/10 text-indigo-855 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20">Accepted</span>';
                    } else if (order.status === 'completed') {
                        badgeHtml = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Completed</span>';
                    } else {
                        badgeHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 dark:bg-rose-500/10 text-rose-800 dark:text-rose-455 border border-rose-200 dark:border-rose-500/20">${order.status}</span>`;
                    }
                    document.getElementById('detail_status_container').innerHTML = badgeHtml;
                    document.getElementById('repeatOrderBtn').classList.remove('hidden');
                    document.getElementById('orderDetailModal').classList.remove('hidden');
                }
            } catch (e) {
                console.error("Gagal memuat detail order:", e);
            }
        }

        function closeOrderDetailModal() {
            document.getElementById('orderDetailModal').classList.add('hidden');
            document.getElementById('repeatOrderBtn').classList.add('hidden');
            window.currentSelectedOrder = null;
        }

        function triggerRepeatOrder() {
            if (!window.currentSelectedOrder) return;
            const order = window.currentSelectedOrder;

            document.getElementById('origin').value = order.origin;
            document.getElementById('destination').value = order.destination;
            document.getElementById('price').value = Math.round(order.price);
            document.getElementById('passenger_name').value = order.passenger_name || '';
            document.getElementById('payment_type').value = order.payment_type || 'cash';

            const driverSelect = document.getElementById('driver_id');
            driverSelect.value = '';
            for (let option of driverSelect.options) {
                if (option.value == order.driver_id) {
                    driverSelect.value = order.driver_id;
                    break;
                }
            }

            closeOrderDetailModal();
            updateBreakdownPreview();

            const orderFormElement = document.getElementById('createOrderForm');
            if (orderFormElement) {
                orderFormElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const formCard = orderFormElement.closest('.bg-white');
                if (formCard) {
                    formCard.classList.add('ring-4', 'ring-indigo-500/30');
                    setTimeout(() => {
                        formCard.classList.remove('ring-4', 'ring-indigo-500/30');
                    }, 1500);
                }
            }
        }

        function updateBreakdownPreview() {
            const priceVal = parseFloat(document.getElementById('price').value) || 0;
            const type = "{{ $settings['commission_type'] ?? 'percentage' }}";
            const val = parseFloat("{{ $settings['commission_value'] ?? '10' }}") || 0;
            const roundDown = "{{ $settings['round_hundreds_down'] ?? 'true' }}" === 'true';

            let adminFee = 0;
            if (type === 'percentage') {
                adminFee = priceVal * (val / 100);
                if (roundDown) {
                    adminFee = Math.floor(adminFee / 100) * 100;
                }
            } else {
                adminFee = val;
            }
            const driverFare = Math.max(0, priceVal - adminFee);

            const breakdownEl = document.getElementById('fareBreakdown');
            if (priceVal > 0) {
                breakdownEl.classList.remove('hidden');
                breakdownEl.innerHTML = `
                    <div class="flex justify-between"><span>Tarif Penumpang:</span><span class="font-bold text-slate-900 dark:text-slate-100">${formatRupiah(priceVal)}</span></div>
                    <div class="flex justify-between text-rose-600 dark:text-rose-400"><span>Potongan Admin (${type === 'percentage' ? val + '%' : 'Nominal'}):</span><span>- ${formatRupiah(adminFee)}</span></div>
                    <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-bold"><span>Pendapatan Driver:</span><span>${formatRupiah(driverFare)}</span></div>
                `;
            } else {
                breakdownEl.classList.add('hidden');
            }
        }

        document.getElementById('price').addEventListener('input', updateBreakdownPreview);
    </script>
</x-app-layout>
