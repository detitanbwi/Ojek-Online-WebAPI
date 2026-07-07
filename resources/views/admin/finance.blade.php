<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Financial Management') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        
        <!-- Saldo Card -->
        <div class="max-w-md bg-gradient-to-br from-emerald-950 to-slate-900 border border-emerald-900/50 rounded-3xl p-8 relative overflow-hidden shadow-2xl">
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4 scale-150 text-emerald-400">
                <svg width="150" height="150" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            
            <div class="text-xs uppercase font-extrabold tracking-wider text-emerald-400">Total Pendapatan Admin</div>
            <div class="text-4xl font-black text-slate-100 mt-2">Rp {{ number_format($adminBalance, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-4">Total akumulasi potongan komisi dari orderan driver yang berstatus selesai.</p>
        </div>

        <!-- Log Transaksi -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="p-6 bg-gradient-to-br from-slate-900 to-indigo-950 text-white relative overflow-hidden">
                <h3 class="text-lg font-bold tracking-wide">Arus Kas & Transaksi</h3>
                <p class="text-indigo-200 text-xs mt-1">Daftar rekonsiliasi arus transaksi keuangan dalam ekosistem Wirojek.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950/50 border-b border-slate-800">
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Ref ID</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Order ID</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Driver</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nominal</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Deskripsi</th>
                            <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                        @forelse($transactions as $tx)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 font-mono font-bold text-indigo-400">{{ $tx->reference_id }}</td>
                                <td class="p-4 font-mono text-slate-400">
                                    @if($tx->order_id)
                                        #{{ $tx->order_id }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-slate-200">{{ $tx->driver->name ?? '-' }}</td>
                                <td class="p-4">
                                    @if($tx->type === 'commission_in')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Commission In</span>
                                    @elseif($tx->type === 'withdrawal_out')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-450 border border-rose-500/20">Withdrawal Out</span>
                                    @elseif($tx->type === 'qris_in')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">QRIS In</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">{{ ucfirst($tx->type) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 font-bold @if(in_array($tx->type, ['commission_in', 'qris_in'])) text-emerald-450 @else text-rose-450 @endif">
                                    @if(in_array($tx->type, ['commission_in', 'qris_in'])) + @else - @endif Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-xs text-slate-400">{{ $tx->description }}</td>
                                <td class="p-4 text-xs text-slate-500">{{ $tx->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-500 text-sm">Belum ada transaksi terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
