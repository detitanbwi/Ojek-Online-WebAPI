<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-500 to-pink-500 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Financial Management') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        
        <!-- Date Filter & Balance Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Saldo Card (Col-span 1) -->
            <div class="bg-white dark:bg-[#151B2C] text-slate-900 dark:text-slate-100 border border-slate-200/60 dark:border-transparent rounded-3xl p-8 relative overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl flex flex-col justify-between">
                <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-emerald-605 dark:text-emerald-500">
                    <svg width="150" height="150" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400">Total Pendapatan Admin</div>
                    <div class="text-4xl font-black text-slate-900 dark:text-white mt-2">Rp {{ number_format($adminBalance, 0, ',', '.') }}</div>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-6">Total akumulasi potongan komisi dikurangi penarikan pengemudi pada rentang tanggal.</p>
            </div>

            <!-- Date Filter (Col-span 2) -->
            <div class="lg:col-span-2 bg-white dark:bg-[#151B2C] text-slate-900 dark:text-slate-100 border border-slate-200/60 dark:border-transparent rounded-3xl p-8 shadow-lg flex flex-col justify-center">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-455 mb-4">Filter Periode Finansial</h3>
                <form method="GET" action="{{ route('admin.finance.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
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
                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-600/10">Filter Data</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Log Transaksi -->
        <div class="bg-white dark:bg-[#151B2C] text-slate-900 dark:text-slate-100 border border-slate-200/60 dark:border-transparent rounded-3xl overflow-hidden transition-all duration-300 shadow-lg hover:shadow-xl">
            <div class="p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-indigo-950 text-slate-900 dark:text-white border-b border-slate-200/60 dark:border-slate-800 relative overflow-hidden flex items-center justify-between">
                <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-slate-700 dark:text-white">
                    <svg width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-lg font-bold tracking-wide">Arus Kas & Transaksi</h3>
                    <p class="text-indigo-650 dark:text-indigo-200 text-xs mt-1">Daftar rekonsiliasi arus transaksi keuangan dalam ekosistem Wirojek.</p>
                </div>
                <button onclick="window.location.reload()" class="relative z-10 p-2 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/20 text-slate-700 dark:text-white border border-slate-200 dark:border-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                    </svg>
                </button>
            </div>

            <!-- Table controls -->
            <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50 dark:bg-slate-950/20 border-b border-slate-200/60 dark:border-slate-800">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-550 dark:text-slate-400">
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
                    <input type="text" id="searchInput" placeholder="Cari transaksi..."
                        class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 py-2 pl-4 pr-10 text-xs text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:ring-indigo-500 transition-all duration-200">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table id="financeTable" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200/60 dark:border-slate-800 text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider select-none">
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="ref">Ref ID <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="order">Order ID <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="driver">Driver <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="type">Tipe <span class="sort-icon"></span></th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="amount">Nominal <span class="sort-icon"></span></th>
                            <th class="p-4">Deskripsi</th>
                            <th class="p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-900/60 transition-colors" data-sort="time">Waktu <span class="sort-icon"></span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-300">
                        @forelse($transactions as $tx)
                            <tr class="hover:bg-slate-100/50 dark:hover:bg-[#1C243A]/30 transition-colors even:bg-slate-50 dark:even:bg-[#1C243A]/40 border-b border-slate-200/60 dark:border-slate-800"
                                data-ref="{{ $tx->reference_id }}"
                                data-order="{{ $tx->order_id ?? 0 }}"
                                data-driver="{{ strtolower($tx->driver->name ?? '') }}"
                                data-type="{{ $tx->type }}"
                                data-amount="{{ $tx->amount }}"
                                data-time="{{ $tx->created_at->timestamp }}">
                                <td class="p-4 font-mono font-bold text-indigo-650 dark:text-indigo-400">{{ $tx->reference_id }}</td>
                                <td class="p-4 font-mono text-slate-500 dark:text-slate-400">
                                    @if($tx->order_id)
                                        #{{ $tx->order_id }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-slate-800 dark:text-slate-200">{{ $tx->driver->name ?? '-' }}</td>
                                <td class="p-4">
                                    @if($tx->type === 'commission_in')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-950/50 dark:text-green-400">Commission In</span>
                                    @elseif($tx->type === 'withdrawal_out')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-950/50 dark:text-red-400">Withdrawal Out</span>
                                    @elseif($tx->type === 'qris_in')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-950/50 dark:text-blue-400">QRIS In</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">{{ ucfirst($tx->type) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 font-bold @if(in_array($tx->type, ['commission_in', 'qris_in'])) text-emerald-600 dark:text-emerald-400 @else text-rose-600 dark:text-rose-400 @endif">
                                    @if(in_array($tx->type, ['commission_in', 'qris_in'])) + @else - @endif Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-xs text-slate-500 dark:text-slate-400">{{ $tx->description }}</td>
                                <td class="p-4 text-xs text-slate-450 dark:text-slate-500">{{ $tx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr class="no-data-row">
                                <td colspan="7" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Belum ada transaksi terekam.</td>
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
            const table = document.getElementById('financeTable');
            const tbody = table.querySelector('tbody');
            const originalRows = Array.from(tbody.querySelectorAll('tr:not(.no-data-row)'));
            const maxEntriesSelect = document.getElementById('maxEntriesSelect');
            const searchInput = document.getElementById('searchInput');
            const prevPageBtn = document.getElementById('prevPageBtn');
            const nextPageBtn = document.getElementById('nextPageBtn');
            const pageNumbersContainer = document.getElementById('pageNumbers');
            const summaryContainer = document.getElementById('paginationSummary');
            
            let filteredRows = [...originalRows];
            let currentPage = 1;
            let maxEntries = parseInt(maxEntriesSelect.value);
            let currentSortColumn = null;
            let currentSortOrder = 'asc'; // asc or desc

            // Search filtering
            function filterRows() {
                const query = searchInput.value.toLowerCase().trim();
                filteredRows = originalRows.filter(row => {
                    return row.getAttribute('data-ref').toLowerCase().includes(query) ||
                           row.getAttribute('data-driver').includes(query) ||
                           row.getAttribute('data-type').toLowerCase().includes(query);
                });
                currentPage = 1;
                renderTable();
            }

            // Client side sorting
            function sortRows(column, order) {
                filteredRows.sort((a, b) => {
                    let valA, valB;
                    if (column === 'ref') {
                        valA = a.getAttribute('data-ref');
                        valB = b.getAttribute('data-ref');
                    } else if (column === 'order') {
                        valA = parseInt(a.getAttribute('data-order'));
                        valB = parseInt(b.getAttribute('data-order'));
                    } else if (column === 'driver') {
                        valA = a.getAttribute('data-driver');
                        valB = b.getAttribute('data-driver');
                    } else if (column === 'type') {
                        valA = a.getAttribute('data-type');
                        valB = b.getAttribute('data-type');
                    } else if (column === 'amount') {
                        valA = parseFloat(a.getAttribute('data-amount'));
                        valB = parseFloat(b.getAttribute('data-amount'));
                    } else if (column === 'time') {
                        valA = parseInt(a.getAttribute('data-time'));
                        valB = parseInt(b.getAttribute('data-time'));
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
                            <td colspan="7" class="p-8 text-center text-slate-400 dark:text-slate-500 text-sm">Belum ada transaksi terekam.</td>
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
                        currentSortOrder = (column === 'ref' || column === 'driver') ? 'asc' : 'desc';
                    }

                    // Update UI sort indicators
                    table.querySelectorAll('thead th .sort-icon').forEach(icon => icon.textContent = '');
                    const icon = th.querySelector('.sort-icon');
                    icon.innerHTML = currentSortOrder === 'asc' ? ' &#9650;' : ' &#9660;';

                    sortRows(column, currentSortOrder);
                });
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
