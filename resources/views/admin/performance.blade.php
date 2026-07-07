<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent tracking-tight">
            {{ __('Driver Performance Leaderboard') }}
        </h2>
    </x-slot>

    <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <div class="p-6 bg-gradient-to-br from-slate-900 to-indigo-950 text-white relative overflow-hidden">
            <h3 class="text-lg font-bold tracking-wide">Peringkat Driver Teratas</h3>
            <p class="text-indigo-200 text-xs mt-1">Daftar performa driver berdasarkan jumlah order terselesaikan dan rating rata-rata dari customer.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/50 border-b border-slate-800">
                        <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Peringkat</th>
                        <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Driver</th>
                        <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">No. HP</th>
                        <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Order Selesai</th>
                        <th class="p-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Rating Driver</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                    @forelse($drivers as $index => $driver)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-4 text-center">
                                @if($index == 0)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-black text-sm shadow-lg shadow-amber-500/20">1</span>
                                @elseif($index == 1)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-300 text-slate-950 font-black text-sm shadow-lg shadow-slate-300/20">2</span>
                                @elseif($index == 2)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-700 text-slate-100 font-black text-sm shadow-lg shadow-amber-700/20">3</span>
                                @else
                                    <span class="text-slate-500 font-bold">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-slate-200">{{ $driver->name }}</div>
                                <div class="text-[10px] text-slate-500">DRV-{{ str_pad($driver->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="p-4">{{ $driver->phone }}</td>
                            <td class="p-4 text-center font-bold text-slate-200">{{ $driver->orders_count }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-1">
                                    @if($driver->orders_avg_rating_driver)
                                        <div class="flex items-center text-amber-400 font-bold">
                                            <span>{{ number_format($driver->orders_avg_rating_driver, 1) }}</span>
                                            <svg class="w-4 h-4 ml-1 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </div>
                                    @else
                                        <span class="text-slate-500 text-xs">Belum ada rating</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500 text-sm">Tidak ada data performa driver saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
