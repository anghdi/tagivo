@extends('layouts.app')

@section('title', 'Admin Dashboard - Tagivo by Khuncode')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Header Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data tagihan, status pembayaran, dan analisis statistik platform Tagivo.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form action="{{ route('admin.logout') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold rounded-xl text-xs transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Toast Notification (AJAX updates) -->
    <div id="toast" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none p-4 rounded-xl bg-slate-900 text-white text-xs font-semibold shadow-xl flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span id="toastMessage">Pesan Toast</span>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Invoices -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Invoice</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ number_format($totalInvoices, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Card 2: Total Revenue -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perputaran Nilai</span>
                <span class="text-xl font-extrabold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Card 3: Unique Senders -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pengirim Unik (Bisnis)</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ number_format($uniqueSenders, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Card 4: Unique Clients -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Klien Terdaftar Unik</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ number_format($uniqueClients, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Status Breakdowns & Trend Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Status Breakdowns -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="text-base font-bold text-slate-900">Pembagian Status Invoice</h3>
                <p class="text-xs text-slate-400 font-medium">Metrik status pembayaran invoice terkini dalam database.</p>
            </div>
            
            <div class="space-y-4">
                <!-- Paid -->
                <div class="flex items-center justify-between p-3 bg-emerald-50/50 border border-emerald-100 rounded-2xl">
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Sudah Lunas</span>
                    <span class="px-3 py-1 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-sm">{{ number_format($paidCount, 0, ',', '.') }}</span>
                </div>
                <!-- Unpaid -->
                <div class="flex items-center justify-between p-3 bg-amber-50/50 border border-amber-100 rounded-2xl">
                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Belum Dibayar</span>
                    <span class="px-3 py-1 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-sm">{{ number_format($unpaidCount, 0, ',', '.') }}</span>
                </div>
                <!-- Overdue -->
                <div class="flex items-center justify-between p-3 bg-rose-50/50 border border-rose-100 rounded-2xl">
                    <span class="text-xs font-bold text-rose-800 uppercase tracking-wider">Jatuh Tempo</span>
                    <span class="px-3 py-1 rounded-xl bg-rose-100 text-rose-800 font-extrabold text-sm">{{ number_format($overdueCount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="border-t border-slate-50 pt-4 flex justify-between items-center text-xs font-semibold text-slate-400">
                <span>Rasio Lunas</span>
                @php
                    $ratio = $totalInvoices > 0 ? ($paidCount / $totalInvoices) * 100 : 0;
                @endphp
                <span class="text-emerald-600 font-extrabold">{{ number_format($ratio, 1) }}%</span>
            </div>
        </div>

        <!-- Right 2-Columns: Trend Chart (7 Days) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6">
            <div>
                <h3 class="text-base font-bold text-slate-900">Tren Pembuatan Invoice (7 Hari Terakhir)</h3>
                <p class="text-xs text-slate-400 font-medium">Banyaknya invoice yang dibuat secara harian dalam seminggu ke belakang.</p>
            </div>

            <!-- CSS Bar Chart Grid -->
            <div class="flex justify-between items-end gap-2 h-48 border-b border-slate-100 pb-4">
                @php
                    $maxCount = collect($chartData)->max('count') ?: 1;
                @endphp
                @foreach($chartData as $day)
                    @php
                        $percentage = ($day['count'] / $maxCount) * 100;
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                        <!-- Bar segment -->
                        <div class="w-full max-w-[40px] bg-gradient-to-t from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-violet-600 rounded-t-lg transition-all duration-300 relative shadow-sm" style="height: {{ max(4, $percentage) }}%;">
                            <!-- Tooltip on hover -->
                            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white font-bold text-[10px] py-1 px-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-10 shadow-lg">
                                {{ $day['count'] }} Invoice <br>
                                Rp {{ number_format($day['total'], 0, ',', '.') }}
                            </div>
                        </div>
                        <!-- Date / Day Label -->
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider select-none text-center">
                            {{ substr($day['label'], 0, 3) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Invoices List & Management Panel -->
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        
        <!-- Filter Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-base font-bold text-slate-900">Daftar Invoice Terkini</h3>
            
            <!-- Search & Filters -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative flex-grow max-w-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No, Pengirim, Klien..." class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                </div>
                <div class="flex gap-2">
                    <select name="status" class="block w-32 px-2.5 py-2 border border-slate-200 rounded-xl text-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                        <option value="">Semua Status</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Jatuh Tempo</option>
                    </select>
                    <button type="submit" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition duration-150">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition duration-150 flex items-center justify-center">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Desktop Table (Hidden on Mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50">
                        <th class="py-3.5 px-6">No Invoice</th>
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Pengirim (Bisnis)</th>
                        <th class="py-3.5 px-6">Penerima (Klien)</th>
                        <th class="py-3.5 px-6">Item</th>
                        <th class="py-3.5 px-6 text-right">Total Tagihan</th>
                        <th class="py-3.5 px-6 text-center">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($invoices as $invoice)
                    <tr class="text-xs text-slate-600 hover:bg-slate-50/20 transition-colors font-medium">
                        <!-- Invoice Number link -->
                        <td class="py-4 px-6">
                            <a href="{{ route('invoices.show', $invoice->view_slug) }}" target="_blank" class="font-bold text-indigo-600 hover:underline">
                                #{{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td class="py-4 px-6 text-slate-500">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                        <td class="py-4 px-6 text-slate-800 font-bold">{{ $invoice->sender_name }}</td>
                        <td class="py-4 px-6">{{ $invoice->client_name }}</td>
                        <td class="py-4 px-6 text-slate-400">{{ $invoice->items_count }} item</td>
                        <td class="py-4 px-6 text-right font-bold text-slate-800">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                        <!-- Dynamic Status Dropdown -->
                        <td class="py-4 px-6 text-center">
                            <select onchange="changeInvoiceStatus(this, {{ $invoice->id }})" class="status-select select-field font-semibold text-[10px] uppercase tracking-wider px-2 py-1 rounded-lg border focus:outline-none transition duration-150 cursor-pointer text-center
                                {{ $invoice->status === 'paid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                {{ $invoice->status === 'unpaid' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                {{ $invoice->status === 'overdue' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                            ">
                                <option value="unpaid" {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Lunas</option>
                                <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Jatuh Tempo</option>
                            </select>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 font-semibold">
                            Tidak ada invoice ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List (Hidden on Desktop) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($invoices as $invoice)
            <div class="p-5 space-y-3">
                <div class="flex justify-between items-center">
                    <a href="{{ route('invoices.show', $invoice->view_slug) }}" target="_blank" class="font-bold text-indigo-600 text-sm hover:underline">
                        #{{ $invoice->invoice_number }}
                    </a>
                    <span class="text-[10px] text-slate-400 font-medium">{{ $invoice->invoice_date->format('d/m/Y') }}</span>
                </div>
                
                <div class="space-y-1 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Pengirim:</span>
                        <span class="font-bold text-slate-800">{{ $invoice->sender_name }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Penerima:</span>
                        <span class="font-medium text-slate-700">{{ $invoice->client_name }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Jumlah:</span>
                        <span class="text-slate-400">{{ $invoice->items_count }} item</span>
                    </div>
                    <div class="flex justify-between text-slate-500 pt-1">
                        <span>Total Tagihan:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Status Selector for Mobile -->
                <div class="flex justify-between items-center pt-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status:</span>
                    <select onchange="changeInvoiceStatus(this, {{ $invoice->id }})" class="status-select font-semibold text-[10px] uppercase tracking-wider px-2.5 py-1.5 rounded-lg border focus:outline-none transition duration-150 cursor-pointer
                        {{ $invoice->status === 'paid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                        {{ $invoice->status === 'unpaid' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                        {{ $invoice->status === 'overdue' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                    ">
                        <option value="unpaid" {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Jatuh Tempo</option>
                    </select>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 font-semibold">
                Tidak ada invoice ditemukan.
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-100">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function changeInvoiceStatus(selectElement, id) {
    const status = selectElement.value;

    // Toast message setup
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    // Make AJAX POST request to update status
    fetch(`/admin/invoice/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Terjadi kesalahan koneksi.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update styling of the select dropdown
            selectElement.className = 'status-select font-semibold text-[10px] uppercase tracking-wider px-2 py-1 rounded-lg border focus:outline-none transition duration-150 cursor-pointer text-center';
            if (data.new_status === 'paid') {
                selectElement.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
            } else if (data.new_status === 'unpaid') {
                selectElement.classList.add('bg-amber-50', 'text-amber-700', 'border-amber-200');
            } else if (data.new_status === 'overdue') {
                selectElement.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-200');
            }

            // Display success Toast
            toastMessage.textContent = data.message;
            toast.classList.replace('translate-y-20', 'translate-y-0');
            toast.classList.replace('opacity-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.replace('translate-y-0', 'translate-y-20');
                toast.classList.replace('opacity-100', 'opacity-0');
            }, 3000);
        } else {
            alert('Gagal memperbarui status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan sistem.');
    });
}
</script>
@endsection
