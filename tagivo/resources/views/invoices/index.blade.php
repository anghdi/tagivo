@extends('layouts.app')

@section('title', 'Buat Invoice Baru - Tagivo by Khuncode')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-3xl font-extrabold tracking-headline text-ink sm:text-4xl">Buat Invoice Baru</h1>
        <p class="mt-2 text-sm text-ink-muted sm:text-base">Isi formulir di bawah ini untuk membuat invoice profesional secara instan. Tanpa registrasi.</p>
    </div>

    <!-- Alert Container for Errors -->
    <div id="errorAlert" class="hidden mb-6 p-4 bg-rose-500/10 border-l-4 border-rose-500 rounded-r-xl shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-rose-400">Mohon perbaiki kesalahan berikut:</h3>
                <ul id="errorList" class="mt-1 text-xs text-rose-300 list-disc pl-5 space-y-1"></ul>
            </div>
        </div>
    </div>

    <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Grid Layout: Form & Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left 2-Columns: Invoice details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Card Container representing a real paper invoice -->
                <div class="bg-surface-1 border border-hairline rounded-2xl shadow-2xl overflow-hidden backdrop-blur-md">
                    <!-- Top Decorator Bar -->
                    <div class="h-[3px] bg-gradient-to-r from-primary to-primary-hover shadow-[0_1px_15px_rgba(94,106,210,0.4)]"></div>
                    
                    <div class="p-6 sm:p-8 space-y-8">
                        <!-- Invoice Header Info -->
                        <div class="flex flex-col md:flex-row gap-6 justify-between items-start">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-eyebrow text-ink-subtle mb-1.5">Nomor Invoice</label>
                                <div class="relative rounded-xl shadow-sm max-w-xs">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-ink-tertiary text-sm font-semibold">#</span>
                                    </div>
                                    <input type="text" name="invoice_number" id="invoice_number" value="{{ $defaultInvoiceNumber }}" class="block w-full pl-8 pr-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white font-semibold placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" required>
                                </div>
                            </div>
                            
                            <!-- Date fields -->
                            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                                <div class="flex-1">
                                    <label class="block text-xs font-bold uppercase tracking-eyebrow text-ink-subtle mb-1.5">Tanggal</label>
                                    <input type="date" name="invoice_date" id="invoice_date" value="{{ date('Y-m-d') }}" class="block w-full px-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" required>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-bold uppercase tracking-eyebrow text-ink-subtle mb-1.5">Jatuh Tempo</label>
                                    <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="block w-full px-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Sender & Client details Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-hairline pt-8">
                            <!-- Sender (Bisnis Anda) -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-lg bg-primary/10 flex items-center justify-center text-primary-hover">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-ink uppercase tracking-wider">Pengirim (Bisnis Anda)</h3>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Nama Perusahaan / Freelancer</label>
                                    <input type="text" name="sender_name" id="sender_name" placeholder="Contoh: PT Kreatif Mandiri" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Surel (Email)</label>
                                    <input type="email" name="sender_email" id="sender_email" placeholder="kreatif@mandiri.com" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Alamat Lengkap</label>
                                    <textarea name="sender_address" id="sender_address" rows="3" placeholder="Jl. Sudirman No. 12, Jakarta" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm"></textarea>
                                </div>
                            </div>

                            <!-- Client (Penerima) -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-lg bg-semantic-success/15 flex items-center justify-center text-semantic-success">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-ink uppercase tracking-wider">Penerima (Klien)</h3>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Nama Klien / Perusahaan</label>
                                    <input type="text" name="client_name" id="client_name" placeholder="Contoh: Budi Santoso" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Surel (Email)</label>
                                    <input type="email" name="client_email" id="client_email" placeholder="budi@klien.com" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Alamat Lengkap</label>
                                    <textarea name="client_address" id="client_address" rows="3" placeholder="Gedung Cyber 2 Lantai 10, Jakarta" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method / Bank Details Section -->
                        <div class="border-t border-hairline pt-8 space-y-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-6 h-6 rounded-lg bg-primary/10 flex items-center justify-center text-primary-hover">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-ink uppercase tracking-wider">Metode Pembayaran (Transfer Bank)</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Nama Bank</label>
                                    <input type="text" name="bank_name" id="bank_name" placeholder="Contoh: Bank BCA" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Nomor Rekening</label>
                                    <input type="text" name="account_number" id="account_number" placeholder="Contoh: 1234567890" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Atas Nama</label>
                                    <input type="text" name="account_holder" id="account_holder" placeholder="Contoh: PT Kreatif Mandiri" class="block w-full px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Item Lines Section -->
                        <div class="border-t border-hairline pt-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-ink uppercase tracking-wider">Item Tagihan</h3>
                                <button type="button" id="addItemBtn" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 hover:bg-primary/20 border border-primary/20 text-primary-hover font-semibold rounded-xl text-xs transition duration-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Baris
                                </button>
                            </div>

                            <!-- Mobile View (Card List) and Desktop View (Table Layout) -->
                            <!-- Table container (Desktop) -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-hairline text-xs font-bold uppercase tracking-eyebrow text-ink-subtle">
                                            <th class="py-3 pr-4 w-1/2">Deskripsi / Layanan</th>
                                            <th class="py-3 px-2 w-28 text-center">Qty</th>
                                            <th class="py-3 px-2 w-48 text-right">Harga Satuan</th>
                                            <th class="py-3 pl-4 w-36 text-right">Total</th>
                                            <th class="py-3 pl-4 w-10 text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="desktopItemRows" class="divide-y divide-hairline/30">
                                        <!-- Template Row injected by JS -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Card List container (Mobile) -->
                            <div id="mobileItemCards" class="block md:hidden space-y-4">
                                <!-- Mobile Items injected by JS -->
                            </div>
                        </div>

                        <!-- Extra inputs (Tax & Discount) -->
                        <div class="border-t border-hairline pt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-eyebrow text-ink-subtle mb-1.5">Diskon Potongan (Rupiah)</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-ink-subtle text-sm font-semibold">Rp</span>
                                    </div>
                                    <input type="number" name="discount_amount" id="discount_amount" min="0" value="0" step="1000" class="block w-full pl-10 pr-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-eyebrow text-ink-subtle mb-1.5">Pajak (%)</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <input type="number" name="tax_percentage" id="tax_percentage" min="0" max="100" value="0" step="0.1" class="block w-full px-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-ink-subtle text-sm font-semibold">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column: Summary & Actions -->
            <div class="space-y-6 lg:sticky lg:top-24">
                <!-- Summary Card -->
                <div class="bg-surface-1 border border-hairline rounded-2xl shadow-xl p-6 space-y-6">
                    <h3 class="text-xs font-bold text-ink uppercase tracking-eyebrow border-b border-hairline pb-4">Ringkasan Total</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-ink-muted font-medium">
                            <span>Subtotal</span>
                            <span id="summarySubtotal" class="text-ink">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-ink-muted font-medium">
                            <span>Diskon</span>
                            <span id="summaryDiscount" class="text-rose-400">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-ink-muted font-medium">
                            <span>Pajak</span>
                            <span id="summaryTax" class="text-ink">Rp 0</span>
                        </div>
                        <div class="border-t border-hairline pt-3 flex justify-between text-base font-bold text-ink">
                            <span>Total Bayar</span>
                            <span id="summaryGrandTotal" class="text-primary-hover font-extrabold text-lg">Rp 0</span>
                        </div>
                    </div>

                    <!-- Submit action -->
                    <button type="submit" id="submitBtn" class="w-full flex items-center justify-center gap-2 px-4 py-3.5 bg-primary hover:bg-primary-hover active:bg-primary-focus text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-200 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan &amp; Buat Tautan
                    </button>
                    
                    <p class="text-center text-xs text-ink-subtle font-medium">
                        Setelah disimpan, Anda akan diarahkan ke halaman pratinjau yang siap dibagikan kepada klien.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const desktopBody = document.getElementById('desktopItemRows');
    const mobileContainer = document.getElementById('mobileItemCards');
    const addItemBtn = document.getElementById('addItemBtn');
    const invoiceForm = document.getElementById('invoiceForm');
    const errorAlert = document.getElementById('errorAlert');
    const errorList = document.getElementById('errorList');
    const submitBtn = document.getElementById('submitBtn');

    // Decimal formatter for currency
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    let rowCounter = 0;

    // Helper: Create unique ID for form inputs synchronization
    function createItemRow() {
        const id = rowCounter++;
        
        // 1. Create Desktop Row Markup
        const tr = document.createElement('tr');
        tr.className = 'border-b border-hairline/30 hover:bg-surface-2/20 transition-colors group align-top';
        tr.id = `desktop-row-${id}`;
        tr.innerHTML = `
            <td class="py-4 pr-4">
                <input type="text" name="items[${id}][item_name]" class="item-name block w-full px-3 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" placeholder="Nama Barang atau Layanan" required>
            </td>
            <td class="py-4 px-2 text-center">
                <input type="number" name="items[${id}][quantity]" class="item-quantity block w-full px-2 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white text-center focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" min="0.01" step="any" value="1" required>
            </td>
            <td class="py-4 px-2 text-right">
                <div class="relative rounded-xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                        <span class="text-ink-subtle text-xs">Rp</span>
                    </div>
                    <input type="number" name="items[${id}][unit_price]" class="item-price block w-full pl-8 pr-2 py-2.5 bg-surface-2 border border-hairline rounded-xl text-white text-right focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm" min="0" step="any" value="0" required>
                </div>
            </td>
            <td class="py-4 pl-4 text-right align-middle text-sm font-semibold text-ink-muted">
                <span class="item-total-display">Rp 0</span>
            </td>
            <td class="py-4 pl-4 text-center align-middle">
                <button type="button" class="delete-row-btn text-ink-subtle hover:text-rose-400 transition-colors duration-150 p-1.5 hover:bg-rose-500/10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        `;

        // 2. Create Mobile Card Markup
        const card = document.createElement('div');
        card.className = 'p-5 bg-surface-2 border border-hairline rounded-xl shadow-xs relative space-y-3';
        card.id = `mobile-card-${id}`;
        card.innerHTML = `
            <div class="absolute top-4 right-4">
                <button type="button" class="delete-row-btn text-ink-subtle hover:text-rose-450 transition-colors duration-150 p-1.5 hover:bg-rose-500/10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
            <div>
                <label class="block text-xs font-semibold text-ink-subtle mb-1">Deskripsi / Layanan</label>
                <input type="text" class="item-name block w-full px-3 py-2.5 bg-surface-3 border border-hairline rounded-xl text-white placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 transition duration-150 sm:text-sm" placeholder="Nama Barang atau Layanan" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Jumlah (Qty)</label>
                    <input type="number" class="item-quantity block w-full px-3 py-2.5 bg-surface-3 border border-hairline rounded-xl text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 transition duration-150 sm:text-sm" min="0.01" step="any" value="1" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-ink-subtle mb-1">Harga Satuan</label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                            <span class="text-ink-subtle text-xs">Rp</span>
                        </div>
                        <input type="number" class="item-price block w-full pl-8 pr-2 py-2.5 bg-surface-3 border border-hairline rounded-xl text-white text-right focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 transition duration-150 sm:text-sm" min="0" step="any" value="0" required>
                    </div>
                </div>
            </div>
            <div class="border-t border-hairline pt-2 flex justify-between items-center">
                <span class="text-xs font-semibold text-ink-subtle uppercase">Subtotal Item</span>
                <span class="item-total-display text-sm font-bold text-ink-muted">Rp 0</span>
            </div>
        `;

        desktopBody.appendChild(tr);
        mobileContainer.appendChild(card);

        // Bind events for sync
        bindSyncEvents(id);
        
        // Recalculate everything
        calculateTotals();
    }

    // Bind sync events between Desktop inputs and Mobile inputs
    function bindSyncEvents(id) {
        const dRow = document.getElementById(`desktop-row-${id}`);
        const mCard = document.getElementById(`mobile-card-${id}`);

        const dName = dRow.querySelector('.item-name');
        const mName = mCard.querySelector('.item-name');

        const dQty = dRow.querySelector('.item-quantity');
        const mQty = mCard.querySelector('.item-quantity');

        const dPrice = dRow.querySelector('.item-price');
        const mPrice = mCard.querySelector('.item-price');

        // Bidirectional syncing
        // 1. Name sync
        dName.addEventListener('input', () => { mName.value = dName.value; });
        mName.addEventListener('input', () => { dName.value = mName.value; });

        // 2. Quantity sync
        dQty.addEventListener('input', () => {
            mQty.value = dQty.value;
            calculateRowTotal(id);
        });
        mQty.addEventListener('input', () => {
            dQty.value = mQty.value;
            calculateRowTotal(id);
        });

        // 3. Price sync
        dPrice.addEventListener('input', () => {
            mPrice.value = dPrice.value;
            calculateRowTotal(id);
        });
        mPrice.addEventListener('input', () => {
            dPrice.value = mPrice.value;
            calculateRowTotal(id);
        });

        // Delete actions
        dRow.querySelector('.delete-row-btn').addEventListener('click', () => deleteRow(id));
        mCard.querySelector('.delete-row-btn').addEventListener('click', () => deleteRow(id));
    }

    function deleteRow(id) {
        // Ensure at least 1 item exists before deleting
        const totalRows = desktopBody.children.length;
        if (totalRows <= 1) {
            alert('Invoice minimal harus memiliki 1 item.');
            return;
        }

        const dRow = document.getElementById(`desktop-row-${id}`);
        const mCard = document.getElementById(`mobile-card-${id}`);

        if (dRow) dRow.remove();
        if (mCard) mCard.remove();

        calculateTotals();
    }

    // Calculates and updates the total of a single item row/card
    function calculateRowTotal(id) {
        const dRow = document.getElementById(`desktop-row-${id}`);
        const mCard = document.getElementById(`mobile-card-${id}`);

        const qty = parseFloat(dRow.querySelector('.item-quantity').value) || 0;
        const price = parseFloat(dRow.querySelector('.item-price').value) || 0;
        const rowTotal = qty * price;

        const formatted = formatter.format(rowTotal);

        dRow.querySelector('.item-total-display').textContent = formatted;
        mCard.querySelector('.item-total-display').textContent = formatted;

        calculateTotals();
    }

    // Calculates subtotals, tax, discount, grand total
    function calculateTotals() {
        let subtotal = 0;
        const rows = desktopBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            subtotal += qty * price;
        });

        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const taxPercent = parseFloat(document.getElementById('tax_percentage').value) || 0;

        const taxableAmount = Math.max(0, subtotal - discount);
        const tax = taxableAmount * (taxPercent / 100);
        const grandTotal = taxableAmount + tax;

        // Update displays
        document.getElementById('summarySubtotal').textContent = formatter.format(subtotal);
        document.getElementById('summaryDiscount').textContent = `- ${formatter.format(discount)}`;
        document.getElementById('summaryTax').textContent = formatter.format(tax);
        document.getElementById('summaryGrandTotal').textContent = formatter.format(grandTotal);
    }

    // Bind listeners to global tax/discount inputs
    document.getElementById('discount_amount').addEventListener('input', calculateTotals);
    document.getElementById('tax_percentage').addEventListener('input', calculateTotals);

    // Initial setup: Add one row on page load
    createItemRow();

    // Event listener: Add item button
    addItemBtn.addEventListener('click', createItemRow);

    // Form Submission Interception (AJAX)
    invoiceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button & show loading state
        submitBtn.disabled = true;
        const originalBtnContent = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;

        // Clear error alert
        errorAlert.classList.add('hidden');
        errorList.innerHTML = '';

        // Collect Form Data
        const formData = new FormData(invoiceForm);

        fetch(invoiceForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                // If validation failed
                return response.json().then(errData => {
                    throw errData;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                throw { message: 'Terjadi kesalahan sistem.' };
            }
        })
        .catch(errors => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;
            
            errorAlert.classList.remove('hidden');
            
            if (errors.errors) {
                // Laravel validation structure
                Object.keys(errors.errors).forEach(key => {
                    errors.errors[key].forEach(msg => {
                        const li = document.createElement('li');
                        li.textContent = msg;
                        errorList.appendChild(li);
                    });
                });
            } else {
                const li = document.createElement('li');
                li.textContent = errors.message || 'Terjadi kesalahan tidak terduga.';
                errorList.appendChild(li);
            }
            
            // Scroll to error alert
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});
</script>
@endsection
