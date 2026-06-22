<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .invoice-box {
            max-width: 100%;
            margin: auto;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
            padding-bottom: 25px;
        }
        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #4f46e5;
        }
        .invoice-title {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
        }
        .invoice-num {
            text-align: right;
            font-size: 12px;
            font-weight: bold;
            color: #64748b;
            margin-top: 3px;
        }
        .meta-table {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }
        .meta-table td {
            padding: 12px 15px;
            width: 25%;
            vertical-align: top;
        }
        .meta-label {
            display: block;
            font-size: 8px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 11px;
            font-weight: bold;
            color: #334155;
        }
        .address-table td {
            width: 50%;
            padding-bottom: 30px;
            vertical-align: top;
        }
        .address-label {
            font-size: 8px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .address-name {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .address-details {
            font-size: 10px;
            color: #64748b;
            line-height: 1.5;
        }
        .items-table {
            margin-bottom: 30px;
        }
        .items-table th {
            border-bottom: 2px solid #e2e8f0;
            padding: 8px 0;
            font-size: 9px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
        }
        .items-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 10px 0;
            font-size: 11px;
        }
        .item-name {
            font-weight: bold;
            color: #334155;
        }
        .totals-container {
            width: 100%;
            margin-top: 15px;
        }
        .totals-table {
            width: 250px;
            margin-left: auto;
        }
        .totals-table td {
            padding: 5px 0;
            font-size: 11px;
        }
        .totals-label {
            color: #64748b;
        }
        .totals-value {
            text-align: right;
            font-weight: bold;
            color: #334155;
        }
        .grand-total-row td {
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            font-weight: bold;
        }
        .grand-total-label {
            font-size: 13px;
            color: #0f172a;
        }
        .grand-total-value {
            font-size: 15px;
            color: #4f46e5;
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 4px;
            border: 1px solid;
            margin-top: 3px;
        }
        .badge-unpaid {
            background-color: #fffbeb;
            color: #b45309;
            border-color: #fde68a;
        }
        .badge-paid {
            background-color: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .badge-overdue {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- Logo & Title -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo">TAGIVO <span style="font-size: 10px; color: #64748b; font-weight: normal; vertical-align: middle; margin-left: 2px;">by Khuncode</span></div>
                </td>
                <td>
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-num">#{{ $invoice->invoice_number }}</div>
                    @php
                        $badgeClass = [
                            'unpaid' => 'badge-unpaid',
                            'paid' => 'badge-paid',
                            'overdue' => 'badge-overdue'
                        ];
                        $statusText = [
                            'unpaid' => 'Belum Dibayar',
                            'paid' => 'Sudah Lunas',
                            'overdue' => 'Jatuh Tempo'
                        ];
                        $class = $badgeClass[$invoice->status] ?? $badgeClass['unpaid'];
                        $text = $statusText[$invoice->status] ?? $statusText['unpaid'];
                    @endphp
                    <div style="text-align: right;">
                        <span class="badge {{ $class }}">{{ $text }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Metadata Summary Box -->
        <table class="meta-table">
            <tr>
                <td>
                    <span class="meta-label">Tanggal Terbit</span>
                    <span class="meta-value">{{ $invoice->invoice_date->format('d M Y') }}</span>
                </td>
                <td>
                    <span class="meta-label">Jatuh Tempo</span>
                    <span class="meta-value">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</span>
                </td>
                <td>
                    <span class="meta-label">Subtotal</span>
                    <span class="meta-value">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="meta-label">Total Tagihan</span>
                    <span class="meta-value" style="color: #4f46e5;">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                </td>
            </tr>
        </table>

        <!-- Sender & Client Addresses -->
        <table class="address-table">
            <tr>
                <td>
                    <div class="address-label">Diterbitkan Oleh</div>
                    <div class="address-name">{{ $invoice->sender_name }}</div>
                    <div class="address-details">
                        @if($invoice->sender_email)
                            {{ $invoice->sender_email }}<br>
                        @endif
                        @if($invoice->sender_address)
                            {!! nl2br(e($invoice->sender_address)) !!}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="address-label">Ditagihkan Kepada</div>
                    <div class="address-name">{{ $invoice->client_name }}</div>
                    <div class="address-details">
                        @if($invoice->client_email)
                            {{ $invoice->client_email }}<br>
                        @endif
                        @if($invoice->client_address)
                            {!! nl2br(e($invoice->client_address)) !!}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Invoice Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 55%; text-align: left;">Deskripsi / Layanan</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 15%; text-align: right;">Harga Satuan</th>
                    <th style="width: 20%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td class="item-name">{{ $item->item_name }}</td>
                    <td style="text-align: center;">{{ number_format($item->quantity, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Invoice Totals -->
        <div class="totals-container">
            <table class="totals-table">
                <tr>
                    <td class="totals-label">Subtotal</td>
                    <td class="totals-value">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->discount_amount > 0)
                <tr>
                    <td class="totals-label">Diskon</td>
                    <td class="totals-value" style="color: #ef4444;">- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($invoice->tax_percentage > 0)
                <tr>
                    <td class="totals-label">Pajak ({{ $invoice->tax_percentage }}%)</td>
                    <td class="totals-value">
                        @php
                            $taxableAmount = max(0, $invoice->subtotal - $invoice->discount_amount);
                            $taxAmount = $taxableAmount * ($invoice->tax_percentage / 100);
                        @endphp
                        Rp {{ number_format($taxAmount, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
                <tr class="grand-total-row">
                    <td class="grand-total-label">Total Tagihan</td>
                    <td class="grand-total-value">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
