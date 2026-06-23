<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'view_slug',
        'sender_name',
        'sender_email',
        'sender_address',
        'client_name',
        'client_email',
        'client_address',
        'invoice_date',
        'due_date',
        'tax_percentage',
        'discount_amount',
        'subtotal',
        'grand_total',
        'status',
        'bank_name',
        'account_number',
        'account_holder',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'tax_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    /**
     * Get the items for the invoice.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
