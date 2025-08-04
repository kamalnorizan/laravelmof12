<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index() {
        // $invoices = Invoice::latest()->get();
        // return response()->json($invoices);

        // $user = User::orderBy('id', 'desc')->get();
        // return response()->json($user);

        return view('invoices.index'); // Assuming you have a view for listing invoices
    }

    public function show(Invoice $invoice) {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return response()->json($invoice);
    }
}
