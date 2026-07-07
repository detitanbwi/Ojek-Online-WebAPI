<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-555 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Account Manager') }}
        </h2>
    </x-slot>

    <!-- Session Messages -->
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        
        <!-- Tab Switcher Buttons -->
        <div class="flex border-b border-slate-200 dark:border-slate-800 gap-4">
            <button onclick="switchTab('customers')" id="tabBtn_customers" 
                class="pb-4 text-sm font-bold border-b-2 border-indigo-650 dark:border-indigo-500 text-indigo-600 dark:text-indigo-455 transition-all duration-150">
                Daftar Customer
            </button>
            <button onclick="switchTab('drivers')" id="tabBtn_drivers" 
                class="pb-4 text-sm font-bold border-b-2 border-transparent text-slate-550 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-all duration-150">
                Daftar Driver
            </button>
        </div>

        <!-- Tab 1: Daftar Customer -->
        <div id="tabContent_customers" class="block">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950/30 border-b border-slate-200/60 dark:border-slate-800 text-slate-900 dark:text-white relative overflow-hidden">
                    <h3 class="text-lg font-bold tracking-wide">Daftar Customer</h3>
                    <p class="text-slate-500 dark:text-indigo-200 text-xs mt-1">Daftar customer terdaftar yang memesan layanan Ojek Online.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200/60 dark:border-slate-800">
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ID</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Terdaftar Pada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                            @forelse($customers as $customer)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="p-4 font-mono text-indigo-600 dark:text-indigo-400 font-bold">#{{ $customer->id }}</td>
                                    <td class="p-4 font-bold text-slate-900 dark:text-slate-200">{{ $customer->name }}</td>
                                    <td class="p-4">{{ $customer->email }}</td>
                                    <td class="p-4 text-xs text-slate-400 dark:text-slate-500">{{ $customer->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Belum ada customer terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Daftar Driver -->
        <div id="tabContent_drivers" class="hidden">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950/30 border-b border-slate-200/60 dark:border-slate-800 text-slate-900 dark:text-white relative overflow-hidden flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold tracking-wide">Daftar Driver</h3>
                        <p class="text-slate-500 dark:text-indigo-200 text-xs mt-1">Kelola pendaftaran akun driver, password, email, dan pantau saldo dompet mereka.</p>
                    </div>
                    <button onclick="openAddDriverModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-extrabold rounded-2xl text-white dark:text-slate-950 bg-indigo-600 dark:bg-emerald-400 hover:bg-indigo-700 dark:hover:bg-emerald-300 shadow-lg shadow-indigo-600/20 dark:shadow-emerald-400/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Driver Baru
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200/60 dark:border-slate-800">
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ID Driver</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No. HP</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Layanan</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Saldo Wallet</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status Online</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                            @forelse($drivers as $driver)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="p-4 font-mono font-bold text-slate-400 dark:text-slate-550">DRV-{{ str_pad($driver->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="p-4 font-bold text-slate-900 dark:text-slate-200">{{ $driver->name }}</td>
                                    <td class="p-4">{{ $driver->email ?? 'Belum diset' }}</td>
                                    <td class="p-4">{{ $driver->phone }}</td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold {{ $driver->vehicle_type === 'wiro_ride' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-indigo-500/10 text-indigo-500 border border-indigo-500/20' }}">
                                            {{ $driver->vehicle_type === 'wiro_ride' ? 'WiroRide (Motor)' : 'WiroCar (Mobil)' }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-semibold text-emerald-600 dark:text-emerald-450">Rp {{ number_format($driver->balance, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        @if($driver->status_online)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                                                Online
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">Offline</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center space-x-2">
                                        <button onclick="openEditDriverModal({{ json_encode($driver) }})" class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-xl text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors">Edit</button>
                                        <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-xl text-rose-600 dark:text-rose-455 bg-rose-50 dark:bg-rose-955/30 hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-colors">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Belum ada driver yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modals -->

    <!-- Add Driver Modal -->
    <div id="addDriverModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all duration-300" style="max-width: 450px;">
            <div class="p-6 text-slate-900 dark:text-white flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold">Daftarkan Driver Baru</h3>
                <button onclick="closeAddDriverModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.drivers.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nomor HP</label>
                    <input type="text" name="phone" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Kendaraan / Layanan</label>
                    <select name="vehicle_type" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                        <option value="wiro_ride">WiroRide (Motor)</option>
                        <option value="wiro_car">WiroCar (Mobil)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password Akun</label>
                    <input type="password" name="password" required minlength="6" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddDriverModal()" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20">Daftarkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Driver Modal -->
    <div id="editDriverModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all duration-300" style="max-width: 450px;">
            <div class="p-6 text-slate-900 dark:text-white flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold">Edit Akun Driver</h3>
                <button onclick="closeEditDriverModal()" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="editDriverForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" id="edit_driver_name" name="name" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" id="edit_driver_email" name="email" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nomor HP</label>
                    <input type="text" id="edit_driver_phone" name="phone" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipe Kendaraan / Layanan</label>
                    <select id="edit_driver_vehicle_type" name="vehicle_type" required class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                        <option value="wiro_ride">WiroRide (Motor)</option>
                        <option value="wiro_car">WiroCar (Mobil)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-550 dark:text-slate-400 uppercase tracking-wider mb-2">Saldo Dompet (Rupiah)</label>
                    <input type="number" id="edit_driver_balance" name="balance" required min="0" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-emerald-600 dark:text-emerald-450 font-bold focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-550 dark:text-slate-400 uppercase tracking-wider mb-2">Password Baru (Biarkan kosong jika tetap)</label>
                    <input type="password" name="password" minlength="6" class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500" placeholder="Kosongkan jika tidak diganti">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditDriverModal()" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts to handle Tabs -->
    <script>
        function switchTab(tab) {
            const btnCustomers = document.getElementById('tabBtn_customers');
            const btnDrivers = document.getElementById('tabBtn_drivers');
            const contentCustomers = document.getElementById('tabContent_customers');
            const contentDrivers = document.getElementById('tabContent_drivers');

            if (tab === 'customers') {
                btnCustomers.className = "pb-4 text-sm font-bold border-b-2 border-indigo-650 dark:border-indigo-500 text-indigo-600 dark:text-indigo-455 transition-all duration-150";
                btnDrivers.className = "pb-4 text-sm font-bold border-b-2 border-transparent text-slate-550 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-all duration-150";

                contentCustomers.classList.remove('hidden');
                contentCustomers.classList.add('block');
                contentDrivers.classList.add('hidden');
                contentDrivers.classList.remove('block');
            } else {
                btnDrivers.className = "pb-4 text-sm font-bold border-b-2 border-indigo-650 dark:border-indigo-500 text-indigo-600 dark:text-indigo-455 transition-all duration-150";
                btnCustomers.className = "pb-4 text-sm font-bold border-b-2 border-transparent text-slate-550 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-all duration-150";

                contentDrivers.classList.remove('hidden');
                contentDrivers.classList.add('block');
                contentCustomers.classList.add('hidden');
                contentCustomers.classList.remove('block');
            }
        }

        function openAddDriverModal() {
            document.getElementById('addDriverModal').classList.remove('hidden');
        }
        function closeAddDriverModal() {
            document.getElementById('addDriverModal').classList.add('hidden');
        }

        function openEditDriverModal(driver) {
            document.getElementById('editDriverForm').action = `/admin/drivers/${driver.id}`;
            document.getElementById('edit_driver_name').value = driver.name;
            document.getElementById('edit_driver_email').value = driver.email || '';
            document.getElementById('edit_driver_phone').value = driver.phone;
            document.getElementById('edit_driver_balance').value = driver.balance;
            document.getElementById('edit_driver_vehicle_type').value = driver.vehicle_type || 'wiro_ride';
            document.getElementById('editDriverModal').classList.remove('hidden');
        }
        function closeEditDriverModal() {
            document.getElementById('editDriverModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
