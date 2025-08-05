<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\Invoice;

class InvoiceService
{
    public function getAllInvoices() {
        return Invoice::all();
    }

    public function unpaidInvoices() {
        return Invoice::whereIn('status', [0,2])->get();
    }

    public function createInvoice(array $data) {
        $invoice = new Invoice();
        $invoice->id = Uuid::uuid4();
        $invoice->customer_name = $data['customer_name'];
        $invoice->customer_email = $data['customer_email'];
        $invoice->status = $data['status'] === 'paid' ? 1 : 0;
        $invoice->user_id = 1;
        $invoice->save();

        return $invoice;
    }

    public function generateInvoiceNumber(){
        // Logic to generate a unique invoice number
        // This could be a simple incrementing number, or a more complex logic
        // For example, you could use the current timestamp or a UUID
        return 'INV-' . date('Ymd') . '-' . Uuid::uuid4()->toString();
    }
}
