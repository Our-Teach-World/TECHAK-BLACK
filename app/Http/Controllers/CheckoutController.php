<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Services\PhonePeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $phonePeService;

    public function __construct(PhonePeService $phonePeService)
    {
        $this->phonePeService = $phonePeService;
    }

    /**
     * Show the checkout form.
     */
    public function show(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        return view('checkout', compact('service'));
    }

    /**
     * Process the checkout and initiate PhonePe payment
     * Updated to use PhonePe v2 SDK
     */
    public function process(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15|regex:/^[0-9]{10}$/',
        ]);

        try {
            // Create order with unique merchant transaction ID
            $order = Order::create([
                'service_id' => $service->id,
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'amount' => $service->price,
                'phonepe_merchant_transaction_id' => 'TXN' . time() . rand(10000, 99999),
                'payment_status' => 'pending',
            ]);

            // Initiate payment via PhonePe v2 SDK
            $paymentResponse = $this->phonePeService->initiatePayment($order);

            if (!$paymentResponse['success']) {
                Log::error('Payment initiation failed', [
                    'order_id' => $order->id,
                    'error' => $paymentResponse['error'] ?? 'Unknown error',
                ]);
                return redirect()->route('checkout', ['service' => $service->id])
                    ->with('error', 'Payment initiation failed. Please try again.');
            }

            // Redirect to PhonePe payment gateway
            return redirect($paymentResponse['redirect_url']);
        } catch (\Exception $e) {
            Log::error('Checkout process error', [
                'service_id' => $service->id,
                'message' => $e->getMessage(),
            ]);
            return redirect()->route('checkout', ['service' => $service->id])
                ->with('error', 'An error occurred. Please try again.');
        }
    }
}
