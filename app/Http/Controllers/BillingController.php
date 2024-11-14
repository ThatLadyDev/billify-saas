<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Actions\GetTenant;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\ProcessPaymentRequest;
use App\Http\Requests\CreateSubscriptionRequest;

class BillingController extends Controller
{
    public function createInvoice(CreateInvoiceRequest $request)
    {
        $subscription = Subscription::where('uuid', $request->subscription)->first('id');
        $invoice = Invoice::create([
            'uuid' => Str::uuid(),
            'subscription_id' => $subscription->id,
            'amount' => $request->amount,
            'status' => Invoice::STATUS_PENDING
        ]);

        return response()->json($invoice, 201);
    }

    public function createSubscription(CreateSubscriptionRequest $request, GetTenant $getTenant)
    {
        $tenant = $getTenant->execute($request->tenant);

        $subscription = Subscription::create([
            'uuid' => Str::uuid(),
            'tenant' => $tenant['uuid'],
            'plan' => $request->plan,
            'status' => Subscription::STATUS_ACTIVE,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json($subscription, 201);
    }

    public function processPayment(ProcessPaymentRequest $request, $invoiceId)
    {
        // Find the invoice
        $invoice = Invoice::find($request->invoice_id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => Payment::STATUS_COMPLETED, 
        ]);

        // Update the invoice status
        $invoice->status = Invoice::STATUS_PAID;
        $invoice->save();

        return response()->json($payment, 201);
    }
}
