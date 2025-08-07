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
    public function index(InvoiceService $invoiceService)
    {
        // $invoices = Invoice::latest()->get();
        // return response()->json($invoices);

        // $user = User::orderBy('id', 'desc')->get();
        // return response()->json($user);

        $unpaidInvoices = $invoiceService->unpaidInvoices();
        $invoices = $invoiceService->getAllInvoices();

        return view('invoices.index', compact('invoices')); // Assuming you have a view for listing invoices
    }

    public function create()
    {
        return view('invoices.create'); // Assuming you have a view for creating invoices

    }

    public function store(StoreInvoiceRequest $request, InvoiceService $invoiceService)
    {

        $invoice = $invoiceService->createInvoice($request->all());
        $invNum = $invoiceService->generateInvoiceNumber();
        return redirect()->route('invoices.show', $invoice);
    }

    public function show(Invoice $invoice)
    {
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return response()->json($invoice);
    }


    public function payinvoice(Invoice $invoice)
    {
        $dataApi = array(
            'userSecretKey' => env('TOYYIBPAY_API_KEY'),
            'categoryCode' => env('TOYYIBPAY_KODLARAVEL'),
            'billName' => 'Pembayaran Bil Laravel MOF',
            'billDescription' => 'Pembayaran Bil Laravel MOF',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => 1500 * 100,
            'billReturnUrl' => route('invoice.redirect', ['invoice' => $invoice->id]),
            'billCallbackUrl' => route('invoice.callback', ['invoice' => $invoice->id]),
            'billExternalReferenceNo' => $invoice->id,
            'billTo' => $invoice->customer_name,
            'billEmail' => $invoice->customer_email,
            'billPhone' => '0123456789',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => '0',
            'billContentEmail' => 'Terima kasih kerana telah membuat pembayaran Bil laravel MOF!',
            'billChargeToCustomer' => 0,
            'billExpiryDate' => now()->addDays(20)->format('Y-m-d H:i:s'),
            'billExpiryDays' => 20
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, env('TOYYIBPAY_URL') . '/index.php/api/createBill');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataApi);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        if ($result === false) {
            return response()->json(['success'=>false,'error' => 'Failed to connect to ToyyibPay API'], 500);
        }
        $obj = json_decode($result);

        // return response()->json($obj);

        $invoice->fpxPaymentLink = $obj[0]->BillCode;
        $invoice->save();
        $data['url'] = env('TOYYIBPAY_URL') . '/' . $invoice->fpxPaymentLink;
        $data['obj'] = $obj;
        return response()->json([
            'success' => true,
            'message' => 'Bil berjaya dijana',
            'billcode' => $obj[0]->BillCode,
            'data' => $data
        ]);
    }


}
