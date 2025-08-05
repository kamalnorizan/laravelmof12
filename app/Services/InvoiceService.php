<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function unpaidInvoices() {
        return Invoice::whereIn('status', [0,2])->get();
    }
}
