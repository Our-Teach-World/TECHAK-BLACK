<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PhonePeService;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PhonePeController extends Controller
{
    protected $phonePeService;

    public function __construct(PhonePeService $phonePeService)
    {
        $this->phonePeService = $phonePeService;
    }

    /**
     * Handle PhonePe webhook callback (POST request with callback data)
     * Updated to use PhonePe v2 SDK verifyCallbackResponse
     */
    public function callback(Request $request)
    {
        try {
            // Get headers and payload
            $headers = $request->headers->all();
            $payload = $request->all();

            // Verify callback using PhonePe v2 SDK
            $verificationResult = $this->phonePeService->verifyCallbackResponse($headers, $payload);

            if (!$verificationResult['success']) {
                Log::error('PhonePe Callback Verification Failed', [
                    'error' => $verificationResult['error'],
                ]);
                return response()->json(['status' => 'failed', 'error' => 'Verification failed'], 400);
            }

            $callbackType = $verificationResult['type'];
            $callbackPayload = $verificationResult['payload'];

            // Handle callback based on type
            if ($callbackType === 'CHECKOUT_ORDER_COMPLETED') {
                return $this->handleOrderCompleted($callbackPayload);
            } elseif ($callbackType === 'CHECKOUT_ORDER_FAILED') {
                return $this->handleOrderFailed($callbackPayload);
            } elseif ($callbackType === 'PG_REFUND_COMPLETED') {
                return $this->handleRefundCompleted($callbackPayload);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('PhonePe Callback Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'failed'], 500);
        }
    }

    /**
     * Handle successful order payment
     */
    private function handleOrderCompleted($payload)
    {
        $merchantOrderId = $payload->getOriginalMerchantOrderId() ?? $payload->getMerchantOrderId();
        $order = Order::where('phonepe_merchant_transaction_id', $merchantOrderId)->first();

        if (!$order) {
            Log::error('Order not found in payment callback', ['merchant_order_id' => $merchantOrderId]);
            return response()->json(['status' => 'failed', 'error' => 'Order not found'], 404);
        }

        // Update order status
        $order->update([
            'payment_status' => 'success',
            'transaction_id' => $payload->getTransactionId() ?? $payload->getRefundId(),
            'payment_response' => json_encode($payload),
        ]);

        // Send confirmation emails
        Mail::to($order->email)->send(new OrderConfirmation($order));
        Mail::to(config('mail.from.address'))->send(new AdminOrderNotification($order));

        Log::info('Order Payment Completed', [
            'order_id' => $order->id,
            'transaction_id' => $payload->getTransactionId() ?? 'N/A',
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle failed order payment
     */
    private function handleOrderFailed($payload)
    {
        $merchantOrderId = $payload->getOriginalMerchantOrderId() ?? $payload->getMerchantOrderId();
        $order = Order::where('phonepe_merchant_transaction_id', $merchantOrderId)->first();

        if (!$order) {
            Log::error('Order not found in failed callback', ['merchant_order_id' => $merchantOrderId]);
            return response()->json(['status' => 'failed', 'error' => 'Order not found'], 404);
        }

        $order->update([
            'payment_status' => 'failed',
            'payment_response' => json_encode($payload),
        ]);

        Log::warning('Order Payment Failed', [
            'order_id' => $order->id,
            'error_code' => $payload->getErrorCode(),
            'error_message' => $payload->getDetailedErrorCode(),
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle successful refund
     */
    private function handleRefundCompleted($payload)
    {
        $merchantOrderId = $payload->getOriginalMerchantOrderId() ?? null;
        $order = Order::where('phonepe_merchant_transaction_id', $merchantOrderId)->first();

        if ($order) {
            $order->update(['payment_status' => 'refunded']);
            Log::info('Order Refunded', ['order_id' => $order->id]);
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle PhonePe redirect after payment (GET request from user browser)
     * Updated to use PhonePe v2 SDK getOrderStatus
     */
    public function redirect(Request $request)
    {
        $merchantOrderId = $request->input('merchantOrderId');

        if (!$merchantOrderId) {
            Log::warning('PhonePe redirect without merchantOrderId');
            return redirect()->route('payment.failed');
        }

        // Check order status using SDK
        $statusResponse = $this->phonePeService->checkOrderStatus($merchantOrderId);

        $order = Order::where('phonepe_merchant_transaction_id', $merchantOrderId)->first();

        if (!$order) {
            Log::error('Order not found in redirect', ['merchant_order_id' => $merchantOrderId]);
            return redirect()->route('payment.failed');
        }

        // Check if payment was successful
        if ($statusResponse['success'] && $statusResponse['state'] === 'COMPLETED') {
            return redirect()->route('payment.success', ['order' => $order->id]);
        }

        return redirect()->route('payment.failed');
    }

    /**
     * Show payment success page
     */
    public function success(Order $order)
    {
        if ($order->payment_status !== 'success') {
            abort(404);
        }

        return view('payment-success', compact('order'));
    }

    /**
     * Show payment failed page
     */
    public function failed()
    {
        return view('payment-failed');
    }

    // simulate() removed for production
}
