<?php

namespace App\Services;

use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Support\Str;

class InvoiceService
{
    protected InvoiceRepositoryInterface $invoiceRepository;

    /**
     * Create a new InvoiceService instance.
     *
     * @param InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Get an invoice by its slug.
     *
     * @param string $slug
     * @return Invoice|null
     */
    public function getInvoiceBySlug(string $slug): ?Invoice
    {
        return $this->invoiceRepository->findBySlug($slug);
    }

    /**
     * Create a new invoice.
     *
     * @param array $data
     * @return Invoice
     */
    public function createInvoice(array $data): Invoice
    {
        // 1. Generate unique slug
        $data['view_slug'] = Str::random(32);

        // 2. Perform Server-Side calculations to ensure data integrity
        $subtotal = 0;
        $processedItems = [];

        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $quantity = floatval($item['quantity'] ?? 0);
                $unitPrice = floatval($item['unit_price'] ?? 0);
                $totalPrice = $quantity * $unitPrice;

                $subtotal += $totalPrice;

                $processedItems[] = [
                    'item_name' => $item['item_name'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ];
            }
        }

        $data['items'] = $processedItems;
        $data['subtotal'] = $subtotal;

        $discountAmount = floatval($data['discount_amount'] ?? 0);
        $taxPercentage = floatval($data['tax_percentage'] ?? 0);

        $taxableAmount = max(0, $subtotal - $discountAmount);
        $taxAmount = $taxableAmount * ($taxPercentage / 100);
        $grandTotal = $taxableAmount + $taxAmount;

        $data['grand_total'] = $grandTotal;
        $data['status'] = $data['status'] ?? 'unpaid';

        return $this->invoiceRepository->create($data);
    }

    /**
     * Generate the next default invoice number.
     * Format: INV-YYYYMMDD-XXXX
     *
     * @return string
     */
    public function generateNextInvoiceNumber(): string
    {
        $datePrefix = 'INV-' . date('Ymd');
        $latestInvoiceNumber = $this->invoiceRepository->getLatestInvoiceNumber();

        if ($latestInvoiceNumber && str_starts_with($latestInvoiceNumber, $datePrefix)) {
            // Extract the sequence number
            $parts = explode('-', $latestInvoiceNumber);
            $sequence = intval(end($parts));
            $nextSequence = str_pad(string: $sequence + 1, length: 4, pad_string: '0', pad_type: STR_PAD_LEFT);
            return $datePrefix . '-' . $nextSequence;
        }

        return $datePrefix . '-0001';
    }
}
