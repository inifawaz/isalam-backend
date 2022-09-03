<?php

namespace App\Helpers;

use App\Models\TransactionInquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Duitku
{
    private $api_key;
    private $merchant_code;
    private $callback_url;
    private $return_url;
    private $expiry_period;

    public function __construct()
    {
        $this->api_key = config('app.duitku_api_key');
        $this->merchant_code = config('app.duitku_merchant_code');
        $this->callback_url = config('app.url') . 'callback';
        $this->return_url = config('app.url') . 'return';
        $this->expiry_period = 60 * 24;
    }


    public function getPaymentMethod($amount)
    {
        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchant_code . $amount . $datetime . $this->api_key);

        $params = array(
            'merchantcode' => $this->merchant_code,
            'amount' => $amount,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);
    }

    public function checkPaymentStatus($merchantOrderId)
    {
        $merchantCode = $this->merchant_code;
        $apiKey = $this->api_key;


        $signature = md5($merchantCode . $merchantOrderId . $apiKey);

        $params = array(
            'merchantCode' => $merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'signature' => $signature
        );

        $params_string = json_encode($params);
        $url = 'https://sandbox.duitku.com/webapi/api/merchant/transactionStatus';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);

        if ($response->successful()) {
            $result = json_decode($response, true);
        } else {
            $result = json_decode($response);
            return "Server Error: " . $result->Message;
        }
        return $result;
    }
}
