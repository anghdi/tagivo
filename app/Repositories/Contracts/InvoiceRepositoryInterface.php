<?php

namespace App\Repositories\Contracts;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    /**
     * Find an invoice by its view slug, including its items.
     *
     * @param string $slug
     * @return Invoice|null
     */
    public function findBySlug(string $slug): ?Invoice;

    /**
     * Create a new invoice with its items.
     *
     * @param array $data
     * @return Invoice
     */
    public function create(array $data): Invoice;

    /**
     * Get the latest invoice number to help auto-generation.
     *
     * @return string|null
     */
    public function getLatestInvoiceNumber(): ?string;
}
