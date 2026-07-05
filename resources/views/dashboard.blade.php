<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent tracking-tight">
                {{ __('Ojol Admin Dashboard') }}
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                Driver Side Control
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left/Middle: Create Order & Order History (Col-span 2) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Create Order Card -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                        <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-900 to-indigo-950 text-white relative">
                            <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-10 -translate-y-10 scale-150">
                                <svg width="200" height="200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold tracking-wide">Buat Order Baru</h3>
                            <p class="text-indigo-200 text-xs mt-1">Input rincian perjalanan untuk langsung dikirim ke driver terpilih.</p>
                        </div>
                        
                        <!-- Custom CSS for Google Autocomplete and Map Container -->
                        <style>
                            .pac-container {
                                border-radius: 1rem !important;
                                border: 1px solid #e2e8f0 !important;
                                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
                                font-family: Figtree, ui-sans-serif, system-ui, sans-serif !important;
                                padding: 0.5rem 0 !important;
                                margin-top: 4px !important;
                                z-index: 9999 !important;
                                pointer-events: auto !important;
                            }
                            .pac-item {
                                padding: 8px 16px !important;
                                font-size: 0.875rem !important;
                                color: #4a5568 !important;
                                border-top: none !important;
                                cursor: pointer !important;
                                pointer-events: auto !important;
                            }
                            .pac-item:hover {
                                background-color: #f7fafc !important;
                            }
                            .pac-item-query {
                                font-size: 0.875rem !important;
                                color: #1a202c !important;
                            }
                            .pac-matched {
                                color: #4f46e5 !important;
                                font-weight: 600 !important;
                            }
                        </style>

                        <form id="createOrderForm" class="p-6 sm:p-8 space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                
                                <!-- Form Fields (Left Column) -->
                                <div class="lg:col-span-5 space-y-6">
                                    <div>
                                        <label for="origin" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Titik Jemput (Origin)</label>
                                        <div class="relative rounded-2xl shadow-sm flex items-center">
                                            <input type="text" id="origin" name="origin" required
                                                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 pl-4 pr-32 text-gray-800 placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition-all duration-200 text-sm"
                                                placeholder="Cari lokasi atau klik Pilih di Peta...">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                                <button type="button" id="pickOriginOnMapBtn" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    Pilih di Peta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="destination" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Titik Tujuan (Destination)</label>
                                        <div class="relative rounded-2xl shadow-sm flex items-center">
                                            <input type="text" id="destination" name="destination" required
                                                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 pl-4 pr-32 text-gray-800 placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition-all duration-200 text-sm"
                                                placeholder="Cari lokasi atau klik Pilih di Peta...">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                                <button type="button" id="pickDestOnMapBtn" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    Pilih di Peta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label for="price" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tarif (Rupiah)</label>
                                            <div class="relative rounded-2xl shadow-sm">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                    <span class="text-gray-500 text-sm">Rp</span>
                                                </div>
                                                <input type="number" id="price" name="price" required min="0"
                                                    class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 pl-10 pr-4 text-gray-800 placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition-all duration-200 text-sm font-bold text-indigo-600"
                                                    placeholder="Tarif otomatis">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="driver_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih Driver</label>
                                            <select id="driver_id" name="driver_id" required
                                                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4 text-gray-800 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition-all duration-200 text-sm">
                                                <option value="">-- Pilih Driver --</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}">
                                                        {{ $driver->name }} ({{ $driver->phone }}) 
                                                        - {{ $driver->status_online ? '🟢 Online' : '⚪ Offline' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Fare Breakdown -->
                                    <div id="fareBreakdown" class="hidden rounded-2xl p-4 text-xs bg-indigo-50/80 text-indigo-900 border border-indigo-100/50 space-y-1">
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
                                <div class="lg:col-span-7 flex flex-col h-full min-h-[450px] border border-gray-100 rounded-3xl overflow-hidden relative shadow-inner bg-gray-50">
                                    <!-- API Key Configuration Panel (Visible if API key is missing) -->
                                    <div id="apiKeyConfigCard" class="hidden absolute inset-0 z-50 bg-slate-900/95 backdrop-blur-sm p-6 flex flex-col justify-center items-center text-white text-center">
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
                                    <div class="absolute top-3 left-3 right-3 bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-md border border-gray-100 flex items-center justify-between text-xs text-gray-700 z-10">
                                        <div id="mapInstruction" class="flex items-center gap-2">
                                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-ping"></span>
                                            <span id="instructionText">Klik peta untuk meletakkan <b>Titik A (Jemput)</b>.</span>
                                        </div>
                                        <button type="button" id="resetMarkersBtn" class="text-rose-600 font-bold hover:underline hidden">Reset Rute</button>
                                    </div>

                                    <!-- Floating Status Indicator -->
                                    <div id="mapStatusOverlay" class="absolute bottom-3 left-3 bg-slate-900/90 text-white px-3.5 py-2 rounded-xl text-xs font-semibold shadow-md flex items-center gap-2 z-10 hidden">
                                        <span id="mapStatusText">Menghitung rute...</span>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- Recent Orders List -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-white border-b border-gray-50 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Daftar Order Terkini</h3>
                                <p class="text-xs text-gray-500">Menampilkan 15 order terakhir yang dibuat.</p>
                            </div>
                            <button onclick="window.location.reload()" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17"/></svg>
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Driver</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rute (Jemput → Tujuan)</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tarif</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody" class="divide-y divide-gray-100 text-sm text-gray-700">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="p-4 font-mono font-semibold text-indigo-600">#{{ $order->id }}</td>
                                            <td class="p-4 font-medium">{{ $order->driver->name ?? 'N/A' }}</td>
                                            <td class="p-4">
                                                <div class="font-medium text-gray-800">{{ $order->origin }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5">→ {{ $order->destination }}</div>
                                            </td>
                                            <td class="p-4 font-semibold text-gray-900">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                            <td class="p-4">
                                                @if($order->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">Pending</span>
                                                @elseif($order->status === 'accepted')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-600/20">Accepted</span>
                                                @elseif($order->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Completed</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-8 text-center text-gray-400">Belum ada orderan yang dibuat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Driver Status & Monitor (Col-span 1) -->
                <div class="space-y-8">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-white border-b border-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">Status Driver</h3>
                            <p class="text-xs text-gray-500">Monitor driver terdaftar dan status online.</p>
                        </div>
                        
                        <div id="driverListContainer" class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
                            @forelse($drivers as $driver)
                                <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition-all duration-150">
                                    <div class="space-y-1">
                                        <div class="font-bold text-gray-800 flex items-center gap-2">
                                            {{ $driver->name }}
                                            @if($driver->status_online)
                                                <span class="flex h-2 w-2 relative">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 00.996.808H10.5a1 1 0 01.96.697l1.037 3.111a1 1 0 01-.004.814l-1.04 3.119a1 1 0 01-.962.678h-2.17a1 1 0 00-.996.808l-.548 2.2a1 1 0 01-.94.725H5a2 2 0 01-2-2V5z"/></svg>
                                            {{ $driver->phone }}
                                        </div>
                                        @if($driver->onesignal_player_id)
                                            <div class="mt-2 text-[10px] bg-gray-100 text-gray-600 px-2 py-1 rounded font-mono truncate max-w-[200px]" title="{{ $driver->onesignal_player_id }}">
                                                ID: {{ substr($driver->onesignal_player_id, 0, 15) }}...
                                            </div>
                                        @else
                                            <div class="mt-2 text-[10px] bg-red-50 text-red-500 px-2 py-1 rounded font-semibold italic">
                                                OneSignal ID belum terdaftar
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        @if($driver->status_online)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Online</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/10">Offline</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400">Belum ada driver terdaftar.</div>
                            @endforelse
                        </div>
                    </div>
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
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "off" }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [{ "visibility": "off" }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [{ "visibility": "off" }]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "off" }]
                    }
                ]
            });
            
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                draggable: true, // Allow dragging the route and endpoints!
                suppressMarkers: false
            });
            
            // Listen to route/endpoint dragging and recalculate
            directionsRenderer.addListener('directions_changed', () => {
                const directions = directionsRenderer.getDirections();
                if (directions && directions.routes && directions.routes[0]) {
                    const route = directions.routes[0].legs[0];
                    
                    // Update form values
                    document.getElementById('origin').value = route.start_address;
                    document.getElementById('destination').value = route.end_address;
                    
                    // Update internal marker positions in memory
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
                    
                    // Render fare breakdown
                    showFareBreakdown(distanceKm, ceilKm, price);
                    
                    // Update status bar
                    document.getElementById('mapStatusOverlay').classList.remove('hidden');
                    document.getElementById('mapStatusText').textContent = `Jarak: ${distanceKm.toFixed(2)} km (${ceilKm} km)`;
                }
            });
            
            geocoder = new google.maps.Geocoder();
            
            // Map click listener to set points
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
            
            // "Pilih di Peta" button event listeners
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
            
            // Autocomplete setup
            initAutocompletes();
            
            // Reset button listener
            document.getElementById('resetMarkersBtn').addEventListener('click', resetRouting);
        }

        function initAutocompletes() {
            const originInput = document.getElementById('origin');
            const destInput = document.getElementById('destination');
            
            originAutocomplete = new google.maps.places.Autocomplete(originInput);
            destinationAutocomplete = new google.maps.places.Autocomplete(destInput);
            
            // Bind to map bounds
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
                // Set point A
                originMarker = createMarker(latLng, 'A');
                reverseGeocode(latLng, 'origin');
                instructionText.innerHTML = 'Klik peta untuk meletakkan <b>Titik B (Tujuan)</b>.';
            } else if (!destinationMarker) {
                // Set point B
                destinationMarker = createMarker(latLng, 'B');
                reverseGeocode(latLng, 'destination');
                updateRouting();
            } else {
                // If both already set, reset and set point A
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
                    <div class="font-bold flex justify-between text-indigo-800"><span>Jarak Bulat:</span> <span>${ceilKm} Km</span></div>
                    <hr class="my-1 border-indigo-200">
                    <div class="flex justify-between font-bold text-indigo-900 text-sm mt-0.5"><span>Tarif Flat (≤ 3 Km):</span> <span>Rp 8.000</span></div>
                `;
            } else {
                const extraKm = ceilKm - 3;
                const extraPrice = extraKm * 3000;
                fareBreakdown.innerHTML = `
                    <div class="font-bold flex justify-between"><span>Jarak Aktual:</span> <span>${distanceKm.toFixed(2)} Km</span></div>
                    <div class="font-bold flex justify-between text-indigo-800"><span>Jarak Bulat:</span> <span>${ceilKm} Km</span></div>
                    <hr class="my-1 border-indigo-200">
                    <div class="flex justify-between"><span>3 Km Pertama (Flat):</span> <span>Rp 8.000</span></div>
                    <div class="flex justify-between"><span>Sisa ${extraKm} Km (${extraKm} x Rp 3.000):</span> <span>Rp ${extraPrice.toLocaleString('id-ID')}</span></div>
                    <hr class="my-1 border-indigo-200">
                    <div class="flex justify-between font-bold text-indigo-900 text-sm mt-0.5"><span>Total Tarif:</span> <span>Rp ${price.toLocaleString('id-ID')}</span></div>
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
                    
                    // Hide original markers because renderer shows the route markers
                    originMarker.setMap(null);
                    destinationMarker.setMap(null);
                    
                    const distanceMeters = result.routes[0].legs[0].distance.value;
                    const distanceKm = distanceMeters / 1000;
                    
                    // Formula calculation
                    // 3 Km pertama flat 8.000 rupiah, 3.001km sudah terhitung 3 Km + 1 Km (3000/km)
                    const ceilKm = Math.ceil(distanceKm);
                    let price = 8000;
                    if (ceilKm > 3) {
                        price = 8000 + (ceilKm - 3) * 3000;
                    }
                    
                    document.getElementById('price').value = price;
                    
                    // Display fare breakdown
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
            
            // Set loading state
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
                    responseMsg.className = 'block rounded-2xl p-4 text-sm bg-emerald-50 text-emerald-800 border border-emerald-200 space-y-1';
                    
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
                    
                    // Reload table and driver list after 3 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    responseMsg.className = 'block rounded-2xl p-4 text-sm bg-rose-50 text-rose-800 border border-rose-200';
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
                responseMsg.className = 'block rounded-2xl p-4 text-sm bg-rose-50 text-rose-800 border border-rose-200';
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

        // Auto refresh table & drivers list every 3 seconds
        async function refreshDashboardData() {
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
                }
            } catch (e) {
                console.error("Auto refresh failed", e);
            }
        }
        
        // Polling interval 3 seconds
        setInterval(refreshDashboardData, 3000);
    </script>
</x-app-layout>
