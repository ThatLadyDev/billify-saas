<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\ProcessPaymentRequest;
use App\Http\Requests\CreateSubscriptionRequest;

class BillingController extends Controller
{
    public function createInvoice(CreateInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->only('tenant_id', 'amount'));
        return response()->json($invoice, 201);
    }

    public function createSubscription(CreateSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->only('tenant_id', 'plan', 'start_date', 'end_date'));
        return response()->json($subscription, 201);
    }

    public function processPayment(ProcessPaymentRequest $request, $invoiceId)
    {
        $payment = Payment::create([
            'invoice_id' => $invoiceId,
            'amount' => $request->amount,
            'method' => $request->method,
        ]);
        return response()->json($payment, 201);
    }
}
