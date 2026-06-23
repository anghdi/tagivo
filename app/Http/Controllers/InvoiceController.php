<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    /**
     * Create a new InvoiceController instance.
     *
     * @param InvoiceService $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display the landing page with the invoice generator form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $defaultInvoiceNumber = $this->invoiceService->generateNextInvoiceNumber();
        return view('invoices.index', compact('defaultInvoiceNumber'));
    }

    /**
     * Store a newly created invoice in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number'  => 'required|string|max:255|unique:invoices,invoice_number',
            'sender_name'     => 'required|string|max:255',
            'sender_email'    => 'nullable|email|max:255',
            'sender_address'  => 'nullable|string',
            'client_name'     => 'required|string|max:255',
            'client_email'    => 'nullable|email|max:255',
            'client_address'  => 'nullable|string',
            'invoice_date'    => 'required|date',
            'due_date'        => 'nullable|date|after_or_equal:invoice_date',
            'tax_percentage'  => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'bank_name'       => 'nullable|string|max:255',
            'account_number'  => 'nullable|string|max:255',
            'account_holder'  => 'nullable|string|max:255',
            'items'           => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity'  => 'required|numeric|min:0.01',
            'items.*.unit_price'=> 'required|numeric|min:0',
        ]);

        $invoice = $this->invoiceService->createInvoice($validated);

        $redirectUrl = route('invoices.show', $invoice->view_slug);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat.',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Invoice berhasil dibuat.');
    }

    /**
     * Display the specified invoice (Client Web View).
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        $invoice = $this->invoiceService->getInvoiceBySlug($slug);

        if (!$invoice) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Download the specified invoice as a PDF.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(string $slug)
    {
        $invoice = $this->invoiceService->getInvoiceBySlug($slug);

        if (!$invoice) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        // Render PDF with dompdf. Using a custom clean PDF view 'invoices.pdf'.
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
                  ->setPaper('a4', 'portrait');

        $filename = 'invoice_' . strtolower(str_replace(' ', '_', $invoice->invoice_number)) . '.pdf';

        return $pdf->download($filename);
    }
}
