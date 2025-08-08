<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QueueTutorialController extends Controller
{
    public function testmail() {
        Mail::to('test@gmail.com')->send(new \App\Mail\PaymentSuccessfulMail());

        // for($i = 0; $i < 100; $i++) {
        //     \App\Jobs\StuckJob::dispatch();
        // }

        return redirect()->route('invoices.index')->with('success', 'Test email sent successfully!');
    }
}
