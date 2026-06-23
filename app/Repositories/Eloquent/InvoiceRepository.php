<?php

namespace App\Repositories\Eloquent;

use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * Find an invoice by its view slug, including its items.
     *
     * @param string $slug
     * @return Invoice|null
     */
    public function findBySlug(string $slug): ?Invoice
    {
        return Invoice::with('items')->where('view_slug', $slug)->first();
    }

    /**
     * Create a new invoice with its items.
     *
     * @param array $data
     * @return Invoice
     */
    public function create(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::create([
                'invoice_number' => $data['invoice_number'],
                'view_slug' => $data['view_slug'],
                'sender_name' => $data['sender_name'],
                'sender_email' => $data['sender_email'] ?? null,
                'sender_address' => $data['sender_address'] ?? null,
                'client_name' => $data['client_name'],
                'client_email' => $data['client_email'] ?? null,
                'client_address' => $data['client_address'] ?? null,
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'] ?? null,
                'tax_percentage' => $data['tax_percentage'] ?? 0,
                'discount_amount' => $data['discount_amount'] ?? 0,
                'subtotal' => $data['subtotal'] ?? 0,
                'grand_total' => $data['grand_total'] ?? 0,
                'status' => $data['status'] ?? 'unpaid',
                'bank_name' => $data['bank_name'] ?? null,
                'account_number' => $data['account_number'] ?? null,
                'account_holder' => $data['account_holder'] ?? null,
            ]);

            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $invoice->items()->create([
                        'item_name' => $item['item_name'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total_price'],
                    ]);
                }
            }

            return $invoice;
        });
    }

    /**
     * Get the latest invoice number to help auto-generation.
     *
     * @return string|null
     */
    public function getLatestInvoiceNumber(): ?string
    {
        return Invoice::latest('id')->value('invoice_number');
    }
}
