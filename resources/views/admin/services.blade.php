<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-800 dark:text-slate-100 tracking-tight">
            {{ __('Layanan Wirojek') }}
        </h2>
    </x-slot>

    <!-- Session Messages -->
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-rose-800 dark:text-rose-350 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        
        <!-- Table Card of Services -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
            <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950/30 border-b border-slate-200/60 dark:border-slate-800 text-slate-900 dark:text-white relative overflow-hidden flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold tracking-wide">Daftar Layanan</h3>
                    <p class="text-slate-550 dark:text-indigo-200 text-xs mt-1">Atur tarif dasar, tarif per KM, jarak flat, dan persentase komisi per layanan.</p>
                </div>
                <button onclick="openAddServiceModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-extrabold rounded-2xl text-white dark:text-slate-950 bg-indigo-600 dark:bg-emerald-400 hover:bg-indigo-700 dark:hover:bg-emerald-300 shadow-lg shadow-indigo-600/20 dark:shadow-emerald-400/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Layanan Baru
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center w-16">Ikon</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Layanan</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tipe Layanan (Slug)</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tarif Dasar</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tarif Per KM</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jarak Flat Awal</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Potongan Komisi</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                        @forelse($services as $service)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-center">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto overflow-hidden bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                        @if($service->service_type === 'wiro_ride')
                                            <img src="{{ asset('assets/images/wiro_ride.png') }}" class="w-10 h-10 object-contain" alt="WiroRide">
                                        @elseif($service->service_type === 'wiro_car')
                                            <img src="{{ asset('assets/images/wiro_car.png') }}" class="w-10 h-10 object-contain" alt="WiroCar">
                                        @else
                                            <img src="{{ asset('assets/images/wiro_ride.png') }}" class="w-10 h-10 object-contain" alt="Vehicle">
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-slate-900 dark:text-slate-200">{{ $service->name }}</td>
                                <td class="p-4 font-mono text-xs text-indigo-600 dark:text-indigo-400">{{ $service->service_type }}</td>
                                <td class="p-4 font-semibold">Rp {{ number_format($service->base_price, 0, ',', '.') }}</td>
                                <td class="p-4 font-semibold text-emerald-600 dark:text-emerald-450">Rp {{ number_format($service->price_per_km, 0, ',', '.') }} / KM</td>
                                <td class="p-4">{{ $service->free_flat_km }} KM</td>
                                <td class="p-4 font-bold text-indigo-650 dark:text-indigo-400">{{ $service->admin_commission_pct }}%</td>
                                <td class="p-4 text-center space-x-2">
                                    <button onclick="openEditServiceModal({{ json_encode($service) }})" class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors">Ubah</button>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-xl text-rose-600 dark:text-rose-455 bg-rose-50 dark:bg-rose-955/30 hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-colors">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Belum ada layanan terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->

    <!-- Add Service Modal -->
    <div id="addServiceModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all duration-300" style="max-width: 450px;">
            <div class="p-6 text-slate-900 dark:text-white flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold">Tambah Layanan Baru</h3>
                <button onclick="closeAddServiceModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="addServiceForm" action="{{ route('admin.services.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Layanan (Slug / Unique)</label>
                    <input type="text" name="service_type" required placeholder="Contoh: wiro_ride" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Layanan</label>
                    <input type="text" name="name" required placeholder="Contoh: WiroRide" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tarif Dasar (Rp)</label>
                        <input type="text" name="base_price" required oninput="formatRupiahInput(this)" placeholder="8.000" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tarif per KM (Rp)</label>
                        <input type="text" name="price_per_km" required oninput="formatRupiahInput(this)" placeholder="2.000" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Jarak Flat Awal (KM)</label>
                        <input type="number" step="0.1" name="free_flat_km" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Potongan Komisi (%)</label>
                        <input type="number" step="0.01" name="admin_commission_pct" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddServiceModal()" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all duration-300" style="max-width: 450px;">
            <div class="p-6 text-slate-900 dark:text-white flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold">Ubah Tarif Layanan</h3>
                <button onclick="closeEditServiceModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="editServiceForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Layanan</label>
                    <input type="text" id="edit_service_name" name="name" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tarif Dasar (Rp)</label>
                        <input type="text" id="edit_service_base_price" name="base_price" required oninput="formatRupiahInput(this)" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tarif per KM (Rp)</label>
                        <input type="text" id="edit_service_price_per_km" name="price_per_km" required oninput="formatRupiahInput(this)" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Jarak Flat Awal (KM)</label>
                        <input type="number" step="0.1" id="edit_service_free_flat_km" name="free_flat_km" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Potongan Komisi (%)</label>
                        <input type="number" step="0.01" id="edit_service_admin_commission_pct" name="admin_commission_pct" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditServiceModal()" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts to handle modals & dynamic thousand separator formatting -->
    <script>
        function formatRupiahInput(element) {
            let value = element.value.replace(/[^0-9]/g, '');
            element.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function formatRupiahValue(val) {
            let numStr = Math.round(val).toString();
            return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Clean dots from inputs before submitting forms
        document.getElementById('addServiceForm').addEventListener('submit', function() {
            let bp = this.querySelector('input[name="base_price"]');
            let pk = this.querySelector('input[name="price_per_km"]');
            bp.value = bp.value.replace(/\./g, '');
            pk.value = pk.value.replace(/\./g, '');
        });

        document.getElementById('editServiceForm').addEventListener('submit', function() {
            let bp = this.querySelector('input[name="base_price"]');
            let pk = this.querySelector('input[name="price_per_km"]');
            bp.value = bp.value.replace(/\./g, '');
            pk.value = pk.value.replace(/\./g, '');
        });

        function openAddServiceModal() {
            document.getElementById('addServiceModal').classList.remove('hidden');
        }
        function closeAddServiceModal() {
            document.getElementById('addServiceModal').classList.add('hidden');
        }

        function openEditServiceModal(service) {
            document.getElementById('editServiceForm').action = `{{ url('admin/services') }}/${service.id}`;
            document.getElementById('edit_service_name').value = service.name;
            document.getElementById('edit_service_base_price').value = formatRupiahValue(service.base_price);
            document.getElementById('edit_service_price_per_km').value = formatRupiahValue(service.price_per_km);
            document.getElementById('edit_service_free_flat_km').value = service.free_flat_km;
            document.getElementById('edit_service_admin_commission_pct').value = service.admin_commission_pct;
            document.getElementById('editServiceModal').classList.remove('hidden');
        }
        function closeEditServiceModal() {
            document.getElementById('editServiceModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
