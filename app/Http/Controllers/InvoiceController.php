<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Invoice;

use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Http\Requests\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    public function index(InvoiceService $invoiceService) {
        // $invoices = Invoice::latest()->get();
        // return response()->json($invoices);

        // $user = User::orderBy('id', 'desc')->get();
        // return response()->json($user);

        $unpaidInvoices = $invoiceService->unpaidInvoices();
        $invoices = $invoiceService->getAllInvoices();

        return view('invoices.index', compact('invoices')); // Assuming you have a view for listing invoices
    }

    public function create() {
        return view('invoices.create'); // Assuming you have a view for creating invoices

    }

    public function store(StoreInvoiceRequest $request, InvoiceService $invoiceService) {

        $invoice = $invoiceService->createInvoice($request->all());
        $invNum = $invoiceService->generateInvoiceNumber();
        return redirect()->route('invoices.show', $invoice);
    }

    public function show(Invoice $invoice) {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return response()->json($invoice);
    }


}
