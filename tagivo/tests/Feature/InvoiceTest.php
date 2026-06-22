<?php

use App\Models\Invoice;

test('landing page displays the invoice generator form with a default invoice number', function () {
    $response = $this->get(route('invoices.index'));

    $response->assertStatus(200);
    $response->assertViewHas('defaultInvoiceNumber');
    $response->assertSee('Buat Invoice Baru');
});

test('storing invoice validates input data correctly', function () {
    $response = $this->postJson(route('invoices.store'), []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['invoice_number', 'sender_name', 'client_name', 'invoice_date', 'items']);
});

test('storing invoice creates records and redirects to preview page', function () {
    // We mock/create the data
    $data = [
        'invoice_number' => 'INV-' . date('Ymd') . '-TEST01',
        'sender_name' => 'John Doe Corp',
        'sender_email' => 'john@doe.com',
        'sender_address' => '123 Sender St',
        'client_name' => 'Jane Smith Ltd',
        'client_email' => 'jane@smith.com',
        'client_address' => '456 Client Rd',
        'invoice_date' => date('Y-m-d'),
        'due_date' => date('Y-m-d', strtotime('+7 days')),
        'tax_percentage' => 10,
        'discount_amount' => 5000,
        'items' => [
            [
                'item_name' => 'Web Design Service',
                'quantity' => 1,
                'unit_price' => 100000,
            ],
            [
                'item_name' => 'Hosting Setup',
                'quantity' => 2,
                'unit_price' => 25000,
            ]
        ]
    ];

    $response = $this->postJson(route('invoices.store'), $data);

    $response->assertStatus(200);
    $response->assertJsonStructure(['success', 'message', 'redirect_url']);
    
    $this->assertDatabaseHas('invoices', [
        'invoice_number' => 'INV-' . date('Ymd') . '-TEST01',
        'sender_name' => 'John Doe Corp',
        'client_name' => 'Jane Smith Ltd',
        'subtotal' => 150000,
        'grand_total' => 159500, // (150000 - 5000) * 1.1 = 159500
    ]);
    
    $invoice = Invoice::where('invoice_number', 'INV-' . date('Ymd') . '-TEST01')->first();
    $this->assertNotNull($invoice);
    $this->assertCount(2, $invoice->items);
});

test('invoice public show page displays details of the invoice', function () {
    $invoice = Invoice::create([
        'invoice_number' => 'INV-SHOW-TEST',
        'view_slug' => 'abcde12345abcde12345abcde1234512',
        'sender_name' => 'Sender',
        'client_name' => 'Client',
        'invoice_date' => date('Y-m-d'),
        'subtotal' => 10000,
        'grand_total' => 10000,
        'status' => 'unpaid',
    ]);

    $invoice->items()->create([
        'item_name' => 'Test Item',
        'quantity' => 1,
        'unit_price' => 10000,
        'total_price' => 10000,
    ]);

    $response = $this->get(route('invoices.show', $invoice->view_slug));

    $response->assertStatus(200);
    $response->assertSee('INV-SHOW-TEST');
    $response->assertSee('Sender');
    $response->assertSee('Client');
    $response->assertSee('Test Item');
});

test('invoice PDF download generates pdf file stream', function () {
    $invoice = Invoice::create([
        'invoice_number' => 'INV-PDF-TEST',
        'view_slug' => 'abcdef12345abcde12345abcde123451',
        'sender_name' => 'Sender PDF',
        'client_name' => 'Client PDF',
        'invoice_date' => date('Y-m-d'),
        'subtotal' => 20000,
        'grand_total' => 20000,
        'status' => 'unpaid',
    ]);

    $invoice->items()->create([
        'item_name' => 'Test Item PDF',
        'quantity' => 1,
        'unit_price' => 20000,
        'total_price' => 20000,
    ]);

    $response = $this->get(route('invoices.pdf', $invoice->view_slug));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});
