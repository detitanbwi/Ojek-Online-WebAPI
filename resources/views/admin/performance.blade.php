<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-500 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Driver Performance Leaderboard') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        <!-- Date Filter Card -->
        <div class="bg-white dark:bg-[#151B2C] text-slate-900 dark:text-slate-100 border border-slate-200/60 dark:border-transparent rounded-3xl p-6 shadow-lg">
            <form method="GET" action="{{ route('admin.performance.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                        class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 py-2.5 px-4 text-sm text-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-indigo-500 transition-all duration-200">
                </div>
                <div>
                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-600/10">Filter Performa</button>
                </div>
            </form>
        </div>

        <!-- Rank Podiums -->
        @if($drivers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end pt-4">
                <!-- Juara 2 (Podium Kiri) -->
                @if($drivers->count() > 1)
                    @php $d2 = $drivers[1]; @endphp
                    <div class="bg-white dark:bg-[#151B2C] border border-slate-200/60 dark:border-transparent rounded-3xl p-6 shadow-md hover:shadow-lg transition-all text-center order-2 md:order-1 transform md:translate-y-4">
                        <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl font-black text-slate-800 dark:text-slate-350 border-2 border-slate-300 dark:border-slate-705 shadow-inner">2</div>
                        <h4 class="mt-4 font-bold text-slate-900 dark:text-slate-100 text-lg truncate">{{ $d2->name }}</h4>
                        <div class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider mt-1">Juara 2 (Silver)</div>
                        <div class="mt-4 flex justify-around text-sm border-t border-slate-100 dark:border-slate-805 pt-4">
                            <div>
                                <span class="block text-xs text-slate-400 font-bold">Orders</span>
                                <span class="font-extrabold text-slate-800 dark:text-slate-200">{{ $d2->orders_count }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 font-bold">Rating</span>
                                <span class="font-extrabold text-orange-600 dark:text-yellow-400 flex items-center justify-center gap-0.5">
                                    {{ $d2->orders_avg_rating_driver ? number_format($d2->orders_avg_rating_driver, 1) : '-' }} ⭐
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Juara 1 (Podium Tengah - Paling Tinggi) -->
                @php $d1 = $drivers[0]; @endphp
                <div class="bg-gradient-to-b from-amber-50 to-white dark:from-amber-955/20 dark:to-[#151B2C] border-2 border-amber-300 dark:border-amber-500/30 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all text-center order-1 md:order-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 left-0 bg-gradient-to-r from-amber-500 to-yellow-500 text-[10px] text-slate-950 font-black tracking-widest py-1.5 uppercase">Podium Utama</div>
                    <div class="w-20 h-20 mx-auto rounded-full bg-amber-100 dark:bg-amber-950/50 flex items-center justify-center text-3xl font-black text-amber-800 dark:text-amber-400 border-2 border-amber-400 shadow-md mt-4">1</div>
                    <h4 class="mt-4 font-black text-slate-900 dark:text-white text-xl truncate">{{ $d1->name }}</h4>
                    <div class="text-[10px] text-amber-705 dark:text-amber-400 uppercase font-extrabold tracking-wider mt-1">Juara 1 (Gold)</div>
                    <div class="mt-6 flex justify-around text-sm border-t border-amber-200/40 dark:border-amber-800/20 pt-4">
                        <div>
                            <span class="block text-xs text-slate-400 font-bold">Orders</span>
                            <span class="font-extrabold text-slate-800 dark:text-slate-200">{{ $d1->orders_count }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 font-bold">Rating</span>
                            <span class="font-extrabold text-orange-600 dark:text-yellow-400 flex items-center justify-center gap-0.5">
                                {{ $d1->orders_avg_rating_driver ? number_format($d1->orders_avg_rating_driver, 1) : '-' }} ⭐
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Juara 3 (Podium Kanan) -->
                @if($drivers->count() > 2)
                    @php $d3 = $drivers[2]; @endphp
                    <div class="bg-white dark:bg-[#151B2C] border border-slate-200/60 dark:border-transparent rounded-3xl p-6 shadow-md hover:shadow-lg transition-all text-center order-3 md:order-3 transform md:translate-y-6">
                        <div class="w-16 h-16 mx-auto rounded-full bg-orange-100/50 dark:bg-orange-950/20 flex items-center justify-center text-2xl font-black text-orange-850 dark:text-orange-400 border-2 border-orange-300 dark:border-orange-500/20 shadow-inner">3</div>
                        <h4 class="mt-4 font-bold text-slate-900 dark:text-slate-100 text-lg truncate">{{ $d3->name }}</h4>
                        <div class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider mt-1">Juara 3 (Bronze)</div>
                        <div class="mt-4 flex justify-around text-sm border-t border-slate-100 dark:border-slate-805 pt-4">
                            <div>
                                <span class="block text-xs text-slate-400 font-bold">Orders</span>
                                <span class="font-extrabold text-slate-800 dark:text-slate-200">{{ $d3->orders_count }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 font-bold">Rating</span>
                                <span class="font-extrabold text-orange-600 dark:text-yellow-400 flex items-center justify-center gap-0.5">
                                    {{ $d3->orders_avg_rating_driver ? number_format($d3->orders_avg_rating_driver, 1) : '-' }} ⭐
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Leaderboard Table Card -->
        <div class="bg-white dark:bg-[#151B2C] text-slate-900 dark:text-slate-100 border border-slate-200/60 dark:border-transparent rounded-3xl overflow-hidden transition-all duration-300 shadow-lg hover:shadow-xl">
            <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 border-b border-slate-200/60 dark:border-slate-800 text-slate-900 dark:text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-slate-700 dark:text-white">
                    <svg width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.173-.437.681-.437.854 0l1.96 4.93 5.38.442c.472.039.66.618.314.934l-4.02 3.67 1.05 5.3c.092.463-.41.83-.816.596L12 16.864l-4.837 2.796c-.407.234-.908-.133-.817-.597l1.05-5.3-4.02-3.67c-.347-.316-.16-.895.314-.934l5.38-.443 1.96-4.93z" />
                    </svg>
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold tracking-wide">Peringkat Seluruh Driver</h3>
                        <p class="text-indigo-650 dark:text-indigo-200 text-xs mt-1">Daftar performa driver berdasarkan rating tertinggi dan jumlah order terselesaikan.</p>
                    </div>
                    <!-- Instant Sorting Controls -->
                    <div class="flex items-center gap-2">
                        <button type="button" id="sortByRatingBtn" class="px-4 py-2 text-xs font-bold rounded-2xl bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 border border-indigo-200/50 dark:border-indigo-900 text-indigo-700 dark:text-indigo-400 transition-colors shadow-sm">
                            Urutkan Rating
                        </button>
                        <button type="button" id="sortByOrdersBtn" class="px-4 py-2 text-xs font-bold rounded-2xl bg-indigo-50 dark:bg-indigo-950/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 border border-indigo-200/50 dark:border-indigo-900 text-indigo-700 dark:text-indigo-400 transition-colors shadow-sm">
                            Urutkan Order Selesai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table controls -->
            <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50 dark:bg-slate-950/20 border-b border-slate-200/60 dark:border-slate-800">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400">
                    <span>Tampilkan</span>
                    <select id="maxEntriesSelect" class="rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-1.5 px-3 text-xs text-slate-900 dark:text-slate-100 focus:ring-indigo-500 transition-all duration-200">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entri</span>
                </div>
                <div class="relative w-full sm:max-w-xs">
                    <input type="text" id="searchInput" placeholder="Cari driver..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-2 pl-4 pr-10 text-xs text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:ring-indigo-500 transition-all duration-200">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table id="performanceTable" class="w-full text-left border-collapse border-slate-200 dark:border-slate-800">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider select-none">
                            <th class="p-4 text-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="rank">Peringkat <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="name">Driver <span class="sort-icon"></span></th>
                            <th class="p-4">No. HP</th>
                            <th class="p-4 text-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="orders">Order Selesai <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="rating">Rating Driver <span class="sort-icon"></span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                        @forelse($drivers as $index => $driver)
                            <tr class="hover:bg-slate-100/50 dark:hover:bg-[#1C243A]/30 transition-colors even:bg-slate-50 dark:even:bg-[#1C243A]/40 border-b border-slate-200 dark:border-slate-800"
                                data-rank="{{ $index + 1 }}"
                                data-name="{{ strtolower($driver->name) }}"
                                data-orders="{{ $driver->orders_count }}"
                                data-rating="{{ $driver->orders_avg_rating_driver ?? 0 }}">
                                <td class="p-4 text-center">
                                    @if($index == 0)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-955/40 dark:text-amber-400 font-black text-sm shadow-sm border border-amber-250 dark:border-amber-800/40">1</span>
                                    @elseif($index == 1)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-800 dark:bg-slate-800/40 dark:text-slate-350 font-black text-sm shadow-sm border border-slate-200 dark:border-slate-700/40">2</span>
                                    @elseif($index == 2)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-850 dark:bg-orange-955/30 dark:text-orange-400 font-black text-sm shadow-sm border border-orange-200/50 dark:border-orange-900/30">3</span>
                                    @else
                                        <span class="text-slate-500 font-bold">#{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-slate-900 dark:text-slate-100">{{ $driver->name }}</div>
                                    <div class="text-[10px] text-slate-500">DRV-{{ str_pad($driver->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="p-4">{{ $driver->phone }}</td>
                                <td class="p-4 text-center font-bold text-slate-900 dark:text-slate-100">{{ $driver->orders_count }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1">
                                        @if($driver->orders_avg_rating_driver)
                                            <div class="flex items-center text-orange-600 dark:text-yellow-400 font-bold">
                                                <span>{{ number_format($driver->orders_avg_rating_driver, 1) }}</span>
                                                <svg class="w-4 h-4 ml-1 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </div>
                                        @else
                                            <span class="text-slate-400 dark:text-slate-500 text-xs">Belum ada rating</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row">
                                <td colspan="5" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Tidak ada data performa driver saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table pagination -->
            <div id="paginationControls" class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50 dark:bg-slate-950/20 border-t border-slate-200/60 dark:border-slate-800 text-xs font-bold text-slate-500 dark:text-slate-400">
                <div id="paginationSummary">Showing 0 to 0 of 0 entries</div>
                <div class="flex items-center gap-1.5">
                    <button type="button" id="prevPageBtn" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 disabled:opacity-50 disabled:pointer-events-none transition-all">Prev</button>
                    <div id="pageNumbers" class="flex gap-1"></div>
                    <button type="button" id="nextPageBtn" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 disabled:opacity-50 disabled:pointer-events-none transition-all">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-Side Sorting, Pagination & Searching JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('performanceTable');
            const tbody = table.querySelector('tbody');
            const originalRows = Array.from(tbody.querySelectorAll('tr:not(.no-data-row)'));
            const maxEntriesSelect = document.getElementById('maxEntriesSelect');
            const searchInput = document.getElementById('searchInput');
            const prevPageBtn = document.getElementById('prevPageBtn');
            const nextPageBtn = document.getElementById('nextPageBtn');
            const pageNumbersContainer = document.getElementById('pageNumbers');
            const summaryContainer = document.getElementById('paginationSummary');
            
            const sortByRatingBtn = document.getElementById('sortByRatingBtn');
            const sortByOrdersBtn = document.getElementById('sortByOrdersBtn');

            let filteredRows = [...originalRows];
            let currentPage = 1;
            let maxEntries = parseInt(maxEntriesSelect.value);
            let currentSortColumn = null;
            let currentSortOrder = 'asc';

            // Search filtering
            function filterRows() {
                const query = searchInput.value.toLowerCase().trim();
                filteredRows = originalRows.filter(row => {
                    return row.getAttribute('data-name').includes(query);
                });
                currentPage = 1;
                renderTable();
            }

            // Client side sorting
            function sortRows(column, order) {
                filteredRows.sort((a, b) => {
                    let valA, valB;
                    if (column === 'rank') {
                        valA = parseInt(a.getAttribute('data-rank'));
                        valB = parseInt(b.getAttribute('data-rank'));
                    } else if (column === 'name') {
                        valA = a.getAttribute('data-name');
                        valB = b.getAttribute('data-name');
                    } else if (column === 'orders') {
                        valA = parseInt(a.getAttribute('data-orders'));
                        valB = parseInt(b.getAttribute('data-orders'));
                    } else if (column === 'rating') {
                        valA = parseFloat(a.getAttribute('data-rating'));
                        valB = parseFloat(b.getAttribute('data-rating'));
                    }

                    if (typeof valA === 'string') {
                        return order === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                    } else {
                        return order === 'asc' ? valA - valB : valB - valA;
                    }
                });
                renderTable();
            }

            // Render page display
            function renderTable() {
                tbody.innerHTML = '';
                const totalEntries = filteredRows.length;
                
                if (totalEntries === 0) {
                    tbody.innerHTML = `
                        <tr class="no-data-row">
                            <td colspan="5" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Tidak ada data performa driver saat ini.</td>
                        </tr>
                    `;
                    summaryContainer.textContent = 'Showing 0 to 0 of 0 entries';
                    prevPageBtn.disabled = true;
                    nextPageBtn.disabled = true;
                    pageNumbersContainer.innerHTML = '';
                    return;
                }

                const totalPages = Math.ceil(totalEntries / maxEntries);
                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIdx = (currentPage - 1) * maxEntries;
                const endIdx = Math.min(startIdx + maxEntries, totalEntries);
                const pageRows = filteredRows.slice(startIdx, endIdx);

                pageRows.forEach(row => tbody.appendChild(row));

                summaryContainer.textContent = `Showing ${startIdx + 1} to ${endIdx} of ${totalEntries} entries`;

                // Update pagination buttons
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage === totalPages;

                // Build page numbers
                pageNumbersContainer.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `px-3 py-1.5 rounded-xl border text-xs font-bold transition-all ${i === currentPage ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10'}`;
                    btn.textContent = i;
                    btn.addEventListener('click', () => {
                        currentPage = i;
                        renderTable();
                    });
                    pageNumbersContainer.appendChild(btn);
                }
            }

            // Sorting event listeners
            table.querySelectorAll('thead th[data-sort]').forEach(th => {
                th.addEventListener('click', () => {
                    const column = th.getAttribute('data-sort');
                    if (currentSortColumn === column) {
                        currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                    } else {
                        currentSortColumn = column;
                        currentSortOrder = column === 'name' ? 'asc' : 'desc';
                    }

                    // Update UI sort indicators
                    table.querySelectorAll('thead th .sort-icon').forEach(icon => icon.textContent = '');
                    const icon = th.querySelector('.sort-icon');
                    icon.innerHTML = currentSortOrder === 'asc' ? ' &#9650;' : ' &#9660;';

                    sortRows(column, currentSortOrder);
                });
            });

            // Instant Sorting Buttons
            sortByRatingBtn.addEventListener('click', () => {
                currentSortColumn = 'rating';
                currentSortOrder = 'desc';
                sortRows('rating', 'desc');
                table.querySelectorAll('thead th .sort-icon').forEach(icon => icon.textContent = '');
                table.querySelector('thead th[data-sort="rating"] .sort-icon').innerHTML = ' &#9660;';
            });

            sortByOrdersBtn.addEventListener('click', () => {
                currentSortColumn = 'orders';
                currentSortOrder = 'desc';
                sortRows('orders', 'desc');
                table.querySelectorAll('thead th .sort-icon').forEach(icon => icon.textContent = '');
                table.querySelector('thead th[data-sort="orders"] .sort-icon').innerHTML = ' &#9660;';
            });

            // Entry changes
            maxEntriesSelect.addEventListener('change', () => {
                maxEntries = parseInt(maxEntriesSelect.value);
                currentPage = 1;
                renderTable();
            });

            // Search inputs
            searchInput.addEventListener('input', filterRows);

            // Next/Prev events
            prevPageBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });
            nextPageBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(filteredRows.length / maxEntries);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            // Init call
            renderTable();
        });
    </script>
</x-app-layout>
