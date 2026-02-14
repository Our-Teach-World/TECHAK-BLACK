<?php

namespace App\Services;

use App\Models\Order;
use PhonePe\payments\v2\standardCheckout\StandardCheckoutClient;
use PhonePe\payments\v2\models\request\builders\StandardCheckoutPayRequestBuilder;
use PhonePe\common\exceptions\PhonePeException;
use Illuminate\Support\Facades\Log;

class PhonePeService
{
    protected $client;
    protected $merchantId;
    protected $redirectUrl;

    public function __construct()
    {
        try {
            // Production environment only
            $env = \PhonePe\Env::PRODUCTION;

            $this->client = StandardCheckoutClient::getInstance(
                env('PHONEPE_CLIENT_ID'),
                env('PHONEPE_CLIENT_VERSION'),
                env('PHONEPE_CLIENT_SECRET'),
                $env,
                env('PHONEPE_PUBLISH_EVENTS', false)
            );

            $this->merchantId = env('PHONEPE_MERCHANT_ID');
            $this->redirectUrl = env('PHONEPE_REDIRECT_URL');

            Log::info('PhonePe Service Initialized', [
                'env' => 'PRODUCTION',
                'merchant_id' => $this->merchantId,
            ]);
        } catch (PhonePeException $e) {
            Log::error('PhonePe SDK Initialization Error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            throw $e;
        }
    }

    /**
     * Initiate payment using PhonePe v2 SDK
     * 
     * @param Order $order
     * @return array
     */
    public function initiatePayment(Order $order)
    {
        try {
            $payRequest = StandardCheckoutPayRequestBuilder::builder()
                ->merchantOrderId($order->phonepe_merchant_transaction_id)
                ->amount((int)($order->amount * 100)) // Convert to paisa
                ->redirectUrl($this->redirectUrl)
                ->build();

            // Initiate payment
            $payResponse = $this->client->pay($payRequest);

            Log::info('PhonePe Payment Initiated', [
                'order_id' => $order->id,
                'merchant_order_id' => $order->phonepe_merchant_transaction_id,
                'state' => $payResponse->getState(),
            ]);

            return [
                'success' => true,
                'state' => $payResponse->getState(),
                'redirect_url' => $payResponse->getRedirectUrl(),
                'order_id' => $payResponse->getOrderId(),
                'expire_at' => $payResponse->getExpireAt(),
            ];
        } catch (PhonePeException $e) {
            Log::error('PhonePe Payment Initiation Failed', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'data' => $e->getData() ?? [],
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check order status using PhonePe v2 SDK
     * 
     * @param string $merchantOrderId
     * @return array
     */
    public function checkOrderStatus($merchantOrderId)
    {
        try {
            $statusResponse = $this->client->getOrderStatus($merchantOrderId, true);

            Log::info('PhonePe Order Status Checked', [
                'merchant_order_id' => $merchantOrderId,
                'state' => $statusResponse->getState(),
            ]);

            return [
                'success' => true,
                'state' => $statusResponse->getState(),
                'order_id' => $statusResponse->getOrderId(),
                'amount' => $statusResponse->getAmount(),
                'merchant_id' => $statusResponse->getMerchantId(),
                'error_code' => $statusResponse->getErrorCode(),
                'payment_details' => $statusResponse->getPaymentDetails(),
            ];
        } catch (PhonePeException $e) {
            Log::error('PhonePe Order Status Check Failed', [
                'merchant_order_id' => $merchantOrderId,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify callback response from PhonePe webhook
     * Uses X-VERIFY header for signature verification
     * 
     * @param array $headers
     * @param array $payload
     * @return array|null
     */
    public function verifyCallbackResponse($headers, $payload)
    {
        try {
            // PhonePe v2 SDK verifyCallbackResponse handles signature verification automatically
            // It validates using X-VERIFY header which contains the signature
            $callbackResponse = $this->client->verifyCallbackResponse(
                $headers,
                $payload
            );

            Log::info('PhonePe Callback Verified', [
                'type' => $callbackResponse->getType(),
            ]);

            return [
                'success' => true,
                'type' => $callbackResponse->getType(),
                'payload' => $callbackResponse->getPayload(),
            ];
        } catch (PhonePeException $e) {
            Log::error('PhonePe Callback Verification Failed', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Initiate refund using PhonePe v2 SDK
     * 
     * @param string $merchantOrderId
     * @param string $merchantRefundId
     * @param int $amount (in paisa)
     * @return array
     */
    public function initiateRefund($merchantOrderId, $merchantRefundId, $amount)
    {
        try {
            $refundRequest = \PhonePe\payments\v2\standardCheckout\models\request\StandardCheckoutRefundRequestBuilder::builder()
                ->originalMerchantOrderId($merchantOrderId)
                ->merchantRefundId($merchantRefundId)
                ->amount($amount)
                ->build();

            $refundResponse = $this->client->refund($refundRequest);

            Log::info('PhonePe Refund Initiated', [
                'merchant_order_id' => $merchantOrderId,
                'merchant_refund_id' => $merchantRefundId,
                'state' => $refundResponse->getState(),
            ]);

            return [
                'success' => true,
                'state' => $refundResponse->getState(),
                'refund_id' => $refundResponse->getRefundId(),
            ];
        } catch (PhonePeException $e) {
            Log::error('PhonePe Refund Initiation Failed', [
                'merchant_order_id' => $merchantOrderId,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
