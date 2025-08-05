<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Invoice;

use Illuminate\Http\Request;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function index() {
        // $invoices = Invoice::latest()->get();
        // return response()->json($invoices);

        // $user = User::orderBy('id', 'desc')->get();
        // return response()->json($user);

        $invoices = (new InvoiceService())->unpaidInvoices();

        return view('invoices.index', compact('invoices')); // Assuming you have a view for listing invoices
    }

    public function create() {
        return view('invoices.create'); // Assuming you have a view for creating invoices

    }

    public function store(Request $request) {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|in:unpaid,paid',
        ]);

        $invoice = new Invoice();
        $invoice->id = Uuid::uuid4();
        $invoice->customer_name = $request->input('customer_name');
        $invoice->customer_email = $request->input('customer_email');
        $invoice->status = $request->input('status') === 'paid' ? 1 : 0; // Convert to integer status
        $invoice->user_id = 1;
        $invoice->save(); // Save the invoice to the database

        return redirect()->route('invoices.show', $invoice);
    }

    public function show(Invoice $invoice) {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return response()->json($invoice);
    }
}
