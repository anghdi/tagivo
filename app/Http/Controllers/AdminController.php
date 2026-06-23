<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the login passcode form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate the admin passcode.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'passcode' => 'required|string',
        ]);

        $correctPasscode = config('services.admin.key');

        if ($validated['passcode'] === $correctPasscode) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Dashboard Admin Tagivo.');
        }

        return redirect()->back()
            ->withInput()
            ->withErrors(['passcode' => 'Kode sandi admin salah!']);
    }

    /**
     * Display the Admin Statistics Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Get overall metrics
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('grand_total');
        
        $uniqueSenders = Invoice::distinct('sender_name')->count('sender_name');
        $uniqueClients = Invoice::distinct('client_name')->count('client_name');

        // Status breakdowns
        $statusCounts = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $paidCount = $statusCounts['paid'] ?? 0;
        $unpaidCount = $statusCounts['unpaid'] ?? 0;
        $overdueCount = $statusCounts['overdue'] ?? 0;

        // 2. Fetch list of invoices with search filtering & pagination
        $query = Invoice::withCount('items')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $invoices = $query->paginate(10)->withQueryString();

        // 3. Trend metrics for last 7 days
        $trendData = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count'),
            DB::raw('sum(grand_total) as total')
        )
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // Fill in missing dates to make the chart smooth
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $dayLabel = now()->subDays($i)->isoFormat('dddd'); // e.g. "Senin"
            
            $found = $trendData->firstWhere('date', $dateStr);
            
            $chartData[] = [
                'date' => $dateStr,
                'label' => $dayLabel,
                'count' => $found ? $found->count : 0,
                'total' => $found ? floatval($found->total) : 0,
            ];
        }

        return view('admin.dashboard', compact(
            'totalInvoices',
            'totalRevenue',
            'uniqueSenders',
            'uniqueClients',
            'paidCount',
            'unpaidCount',
            'overdueCount',
            'invoices',
            'chartData'
        ));
    }

    /**
     * Update the status of an invoice dynamically.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:unpaid,paid,overdue',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status invoice #' . $invoice->invoice_number . ' berhasil diubah.',
            'new_status' => $invoice->status,
        ]);
    }

    /**
     * Log out of the admin panel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Berhasil keluar dari admin.');
    }
}
