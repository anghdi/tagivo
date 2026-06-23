@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->invoice_number . ' - Tagivo by Khuncode')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Share & Success Alert -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border-l-4 border-emerald-500 rounded-r-xl shadow-sm print:hidden">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-semibold text-emerald-400">{{ session('success') }}</p>
                <p class="text-xs text-emerald-300 mt-1">Invoice Anda telah aman tersimpan di sistem. Gunakan tautan di bawah untuk membagikannya ke klien.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Action & Share panel (Only visible on web, hidden on Print) -->
    <div class="bg-surface-1 border border-hairline rounded-2xl shadow-xl p-6 mb-8 print:hidden flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="space-y-2 flex-grow">
            <h3 class="text-xs font-bold text-ink uppercase tracking-eyebrow">Bagikan Invoice Ini</h3>
            <div class="flex items-center gap-2">
                <input type="text" id="shareUrl" readonly value="{{ route('invoices.show', $invoice->view_slug) }}" class="flex-grow max-w-md px-3 py-2 bg-surface-2 border border-hairline rounded-xl text-ink-muted text-xs font-semibold focus:outline-none select-all">
                <button type="button" id="copyBtn" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-primary/10 hover:bg-primary/20 border border-primary/20 text-primary-hover font-bold rounded-xl text-xs transition duration-200 shadow-sm">
                    <svg id="copyIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    <span id="copyText">Salin Tautan</span>
                </button>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="https://api.whatsapp.com/send?text={{ rawurlencode('Halo, berikut adalah tagihan invoice #' . $invoice->invoice_number . ' dari kami: ' . route('invoices.show', $invoice->view_slug)) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-semantic-success hover:bg-semantic-success/90 text-white font-bold rounded-xl text-xs transition duration-200 shadow-sm">
                <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.45L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.966C16.59 2.016 14.11 1.008 11.99 1.008c-5.455 0-9.877 4.373-9.88 9.803-.001 1.77.473 3.5 1.374 5.024L2.448 20.88l5.2-.136z"/>
                </svg>
                Kirim WA
            </a>
            
            <a href="{{ route('invoices.pdf', $invoice->view_slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-primary hover:bg-primary-hover active:bg-primary-focus text-on-primary font-bold rounded-xl text-xs transition duration-200 shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh PDF
            </a>
            
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-surface-2 hover:bg-surface-3 text-ink font-bold rounded-xl text-xs transition duration-200 shadow-sm border border-hairline">
                <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2zm5-14V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Cetak
            </button>
        </div>
    </div>

    <!-- Physical Invoice Container -->
    <div class="bg-surface-1 border border-hairline rounded-2xl shadow-2xl overflow-hidden print:shadow-none print:border-none print:bg-transparent">
        
        <!-- Header Decorator (Print: hidden) -->
        <div class="h-[3px] bg-gradient-to-r from-primary to-primary-hover shadow-[0_1px_15px_rgba(94,106,210,0.4)] print:hidden"></div>

        <div class="p-6 sm:p-10 space-y-8">
            
            <!-- Logo & Title -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-headline bg-gradient-to-r from-ink to-ink-muted bg-clip-text text-transparent print:text-indigo-700">INVOICE</h2>
                    <p class="text-sm font-bold text-ink-subtle mt-1 uppercase tracking-eyebrow">NO: #{{ $invoice->invoice_number }}</p>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'unpaid' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                            'paid' => 'bg-semantic-success/15 text-semantic-success border-semantic-success/20',
                            'overdue' => 'bg-rose-500/10 text-rose-450 border-rose-500/20'
                        ];
                        $statusText = [
                            'unpaid' => 'Belum Dibayar',
                            'paid' => 'Sudah Lunas',
                            'overdue' => 'Jatuh Tempo'
                        ];

                        $color = $statusColors[$invoice->status] ?? $statusColors['unpaid'];
                        $text = $statusText[$invoice->status] ?? $statusText['unpaid'];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border {{ $color }} print:border-slate-350 print:text-slate-800 print:bg-transparent">
                        {{ $text }}
                    </span>
                </div>
            </div>

            <!-- Dates Metadata -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-surface-2 border border-hairline rounded-xl p-4 sm:p-5 print:bg-transparent print:border-slate-250">
                <div>
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">Tanggal Terbit</span>
                    <span class="text-xs font-semibold text-ink">{{ $invoice->invoice_date->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">Jatuh Tempo</span>
                    <span class="text-xs font-semibold text-ink">
                        {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">Subtotal</span>
                    <span class="text-xs font-semibold text-ink">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">Grand Total</span>
                    <span class="text-xs font-bold text-primary-hover print:text-slate-900">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Sender & Client Address columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-hairline pt-8 print:border-slate-250">
                <!-- Sender -->
                <div class="space-y-2">
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">DITERBITKAN OLEH:</span>
                    <h4 class="text-sm font-bold text-ink">{{ $invoice->sender_name }}</h4>
                    @if($invoice->sender_email)
                    <p class="text-xs text-ink-muted font-medium">{{ $invoice->sender_email }}</p>
                    @endif
                    @if($invoice->sender_address)
                    <p class="text-xs text-ink-muted font-medium whitespace-pre-line leading-relaxed">{{ $invoice->sender_address }}</p>
                    @endif
                </div>

                <!-- Recipient -->
                <div class="space-y-2">
                    <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow">DITAGIHKAN KEPADA:</span>
                    <h4 class="text-sm font-bold text-ink">{{ $invoice->client_name }}</h4>
                    @if($invoice->client_email)
                    <p class="text-xs text-ink-muted font-medium">{{ $invoice->client_email }}</p>
                    @endif
                    @if($invoice->client_address)
                    <p class="text-xs text-ink-muted font-medium whitespace-pre-line leading-relaxed">{{ $invoice->client_address }}</p>
                    @endif
                </div>
            </div>

            @if($invoice->bank_name || $invoice->account_number || $invoice->account_holder)
            <!-- Bank Details -->
            <div class="border-t border-hairline pt-8 print:border-slate-250">
                <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow mb-3">Informasi Pembayaran (Transfer Bank)</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-surface-2/40 border border-hairline rounded-xl p-4 print:bg-transparent print:border-slate-250">
                    @if($invoice->bank_name)
                    <div>
                        <span class="block text-[9px] font-bold text-ink-subtle uppercase tracking-eyebrow">Bank</span>
                        <span class="text-xs font-semibold text-ink">{{ $invoice->bank_name }}</span>
                    </div>
                    @endif
                    @if($invoice->account_number)
                    <div>
                        <span class="block text-[9px] font-bold text-ink-subtle uppercase tracking-eyebrow">No. Rekening</span>
                        <span class="text-xs font-semibold text-ink">{{ $invoice->account_number }}</span>
                    </div>
                    @endif
                    @if($invoice->account_holder)
                    <div>
                        <span class="block text-[9px] font-bold text-ink-subtle uppercase tracking-eyebrow">Atas Nama</span>
                        <span class="text-xs font-semibold text-ink">{{ $invoice->account_holder }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Invoice items -->
            <div class="border-t border-hairline pt-8 print:border-slate-250">
                <span class="block text-[10px] font-bold text-ink-subtle uppercase tracking-eyebrow mb-4">Rincian Pembayaran</span>
                
                <!-- Desktop Items (Table view - hidden on mobile) -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-hairline text-xs font-bold uppercase tracking-eyebrow text-ink-subtle print:border-slate-250">
                                <th class="py-3 pr-4 w-1/2">Deskripsi / Layanan</th>
                                <th class="py-3 px-4 w-16 text-center">Qty</th>
                                <th class="py-3 px-4 w-32 text-right">Harga Satuan</th>
                                <th class="py-3 pl-4 w-36 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-hairline/30 print:divide-slate-250">
                            @foreach($invoice->items as $item)
                            <tr class="text-sm text-ink-muted font-medium">
                                <td class="py-4 pr-4 text-ink font-semibold">{{ $item->item_name }}</td>
                                <td class="py-4 px-4 text-center">{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="py-4 pl-4 text-right font-semibold text-ink">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Items (Card list - hidden on desktop and hidden on print) -->
                <div class="block sm:hidden space-y-3 print:hidden">
                    @foreach($invoice->items as $item)
                    <div class="p-4 bg-surface-2 border border-hairline rounded-xl space-y-2">
                        <div class="font-semibold text-ink text-sm">{{ $item->item_name }}</div>
                        <div class="flex justify-between items-center text-xs text-ink-subtle">
                            <span>{{ number_format($item->quantity, 0, ',', '.') }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                            <span class="font-bold text-ink-muted text-sm">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals section -->
            <div class="border-t border-hairline pt-8 flex justify-end print:border-slate-250">
                <div class="w-full sm:w-80 space-y-3">
                    <div class="flex justify-between text-sm text-ink-muted font-medium">
                        <span>Subtotal</span>
                        <span class="text-ink">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($invoice->discount_amount > 0)
                    <div class="flex justify-between text-sm text-ink-muted font-medium">
                        <span>Diskon</span>
                        <span class="text-rose-400">- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($invoice->tax_percentage > 0)
                    <div class="flex justify-between text-sm text-ink-muted font-medium">
                        <span>Pajak ({{ $invoice->tax_percentage }}%)</span>
                        <span class="text-ink">
                            @php
                                $taxableAmount = max(0, $invoice->subtotal - $invoice->discount_amount);
                                $taxAmount = $taxableAmount * ($invoice->tax_percentage / 100);
                            @endphp
                            Rp {{ number_format($taxAmount, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                    <div class="border-t border-hairline pt-3 flex justify-between text-base font-bold text-ink print:border-slate-250">
                        <span>Total Bayar</span>
                        <span class="text-primary-hover print:text-slate-900 text-lg">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.getElementById('copyBtn');
    const shareUrl = document.getElementById('shareUrl');
    const copyIcon = document.getElementById('copyIcon');
    const copyText = document.getElementById('copyText');

    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            // Select text and copy to clipboard
            shareUrl.select();
            shareUrl.setSelectionRange(0, 99999); // For mobile devices
            
            navigator.clipboard.writeText(shareUrl.value).then(function() {
                // Success feedback
                copyText.textContent = 'Tersalin!';
                copyBtn.classList.replace('bg-primary/10', 'bg-semantic-success/15');
                copyBtn.classList.replace('text-primary-hover', 'text-semantic-success');
                copyBtn.classList.replace('border-primary/20', 'border-semantic-success/20');
                
                // Reset feedback after 2 seconds
                setTimeout(function() {
                    copyText.textContent = 'Salin Tautan';
                    copyBtn.classList.replace('bg-emerald-50/15', 'bg-primary/10');
                    copyBtn.classList.replace('bg-semantic-success/15', 'bg-primary/10');
                    copyBtn.classList.replace('text-semantic-success', 'text-primary-hover');
                    copyBtn.classList.replace('border-semantic-success/20', 'border-primary/20');
                }, 2000);
            }).catch(function(err) {
                console.error('Gagal menyalin: ', err);
            });
        });
    }
});
</script>
@endsection
