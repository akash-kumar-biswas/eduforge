<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SSLCommerzService
{
    private $storeId;
    private $storePassword;
    private $apiUrl;
    private $isSandbox;

    public function __construct()
    {
        $this->storeId = env('SSLCOMMERZ_STORE_ID');
        $this->storePassword = env('SSLCOMMERZ_STORE_PASSWORD');
        $this->isSandbox = env('SSLCOMMERZ_SANDBOX', true);

        // Set API URL based on environment
        if ($this->isSandbox) {
            $this->apiUrl = 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php';
        } else {
            $this->apiUrl = 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';
        }
    }

    /**
     * Initialize payment session with SSLCOMMERZ
     */
    public function initiatePayment($data)
    {
        $postData = [
            // Merchant Information
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,

            // Transaction Information
            'total_amount' => $data['total_amount'],
            'currency' => 'BDT',
            'tran_id' => $data['tran_id'],
            'product_category' => 'Education',
            'product_name' => $data['product_name'] ?? 'Course Purchase',
            'product_profile' => 'general',

            // Customer Information
            'cus_name' => $data['cus_name'],
            'cus_email' => $data['cus_email'] ?? 'customer@example.com',
            'cus_phone' => $data['cus_phone'],
            'cus_add1' => $data['cus_add1'] ?? 'Dhaka',
            'cus_city' => $data['cus_city'] ?? 'Dhaka',
            'cus_country' => 'Bangladesh',
            'cus_postcode' => $data['cus_postcode'] ?? '1000',

            // Shipment Information (Required by SSLCOMMERZ)
            'shipping_method' => 'NO',
            'ship_name' => $data['cus_name'],
            'ship_add1' => $data['cus_add1'] ?? 'Dhaka',
            'ship_city' => $data['cus_city'] ?? 'Dhaka',
            'ship_country' => 'Bangladesh',
            'ship_postcode' => $data['cus_postcode'] ?? '1000',

            // URLs
            // Use payment.complete as the browser-facing success URL so the
            // user's browser is redirected to a route that can perform the
            // final login (token or tran_id fallback) and show the dashboard.
            'success_url' => route('payment.complete'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'ipn_url' => route('payment.ipn'),

            // Additional Information
            'value_a' => $data['student_id'] ?? '',
            'value_b' => $data['payment_method'] ?? '',
            'value_c' => $data['cart_items'] ?? '',
        ];

        try {
            $response = Http::asForm()->post($this->apiUrl, $postData);

            $result = $response->json();

            if (isset($result['status']) && $result['status'] === 'SUCCESS') {
                return [
                    'success' => true,
                    'gateway_url' => $result['GatewayPageURL'],
                    'session_key' => $result['sessionkey'] ?? null,
                ];
            }

            return [
                'success' => false,
                'message' => $result['failedreason'] ?? 'Payment initialization failed',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate payment from SSLCOMMERZ
     */
    public function validatePayment($valId)
    {
        $validationUrl = $this->isSandbox
            ? 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php'
            : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';

        $postData = [
            'val_id' => $valId,
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
        ];

        try {
            $response = Http::asForm()->post($validationUrl, $postData);
            $result = $response->json();

            if (isset($result['status']) && $result['status'] === 'VALID') {
                return [
                    'success' => true,
                    'data' => $result,
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment validation failed',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
