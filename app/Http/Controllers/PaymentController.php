<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentItemResource;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PharIo\Manifest\Author;

class PaymentController extends Controller
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
        $this->callback_url = config('app.duitku_callback_url');
        $this->return_url = config('app.duitku_return_url');
        $this->expiry_period = 60 * 24;
    }
    public function getPaymentMethod(Request $request)
    {
        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchant_code . $request->amount . $datetime . $this->api_key);

        $params = array(
            'merchantcode' => $this->merchant_code,
            'amount' => $request->amount,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);

        return response([
            'payment_methods' => $response['paymentFee']
        ]);
    }

    public function createPayment(Request $request)
    {
        //
        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchant_code . $request->project_amount_given . $datetime . $this->api_key);
        $paymentMethod = $request->paymentMethod;

        $params = array(
            'merchantcode' => $this->merchant_code,
            'amount' => $request->project_amount_given,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);


        $a = array_filter($response['paymentFee'], function ($item) {
            global $request;
            return $item['paymentMethod'] == $request->paymentMethod;
        });
        $paymentMethodSelected = reset($a);



        $merchantCode = $this->merchant_code;
        $project = Project::find($request->project_id);


        // Generate Merchant Oder Id
        $now = Carbon::now('Asia/Jakarta');
        $project_id_code = str_pad($project->id, 3, "8", STR_PAD_LEFT);
        $year_code = $now->format('y');
        $month_code = $now->format('m');
        $day_code = $now->format('d');
        $hour_code = $now->format('h');
        $minute_code = $now->format('i');
        $second_code = $now->format('s');
        //
        $merchantOrderId = $project_id_code . $second_code . $minute_code . $hour_code . $day_code . $month_code . $year_code;

        $productDetails = $project->name;
        $email = Auth::user()->email;

        $merchantUserInfo = Auth::user()->id;
        $customerVaName = Auth::user()->full_name;
        $phoneNumber = Auth::user()->phone_number;

        $itemDetails = [
            [
                "name" => 'Nominal Wakaf Yang Diberikan',
                "quantity" => 1,
                'price' => $request->project_amount_given
            ],
            [
                "name" => 'Biaya Pemeliharaan Sistem',
                "quantity" => 1,
                'price' => $project->maintenance_fee
            ],
        ];
        $paymentAmount = $request->project_amount_given + $project->maintenance_fee;


        $returnUrl = $this->return_url;
        $callbackUrl = $this->callback_url;
        $signature = md5($this->merchant_code . $merchantOrderId . $paymentAmount . $this->api_key);
        $expiryPeriod = $this->expiry_period;

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'merchantUserInfo' => $merchantUserInfo,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'itemDetails' => $itemDetails,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod
        );
        $url = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            //            'Content-Length: ' . strlen($params)
        ])->post($url, $params);

        if ($response->successful() && $response['statusCode'] == "00" && $response['statusMessage'] === "SUCCESS") {
            $result = json_decode($response, true);
            $payment = Payment::create(
                [
                    "user_id" => Auth::user()->id,
                    "project_id" => $project->id,
                    "merchant_code" => $merchantCode,
                    "merchant_order_id" => $merchantOrderId,
                    "reference" => $result['reference'],
                    "payment_url" => $result['paymentUrl'],
                    "project_amount_given" => $request->project_amount_given,
                    "maintenance_fee" => $project->maintenance_fee,
                    "payment_fee" => $paymentMethodSelected['totalFee'],
                    "amount" => $result['amount'],
                    "va_number" => $result['vaNumber'],
                    "payment_method" => $paymentMethod,
                    "payment_method_name" => $paymentMethodSelected['paymentName'],
                    "payment_image" => $paymentMethodSelected['paymentImage'],
                    "expiry_period" => $this->expiry_period
                ]
            );

            return response([
                'result' => $result,
                'payment' => $payment
            ], 201);
        } else {
            $result = json_decode($response);
            // return "Server Error: " . $result->Message;
            return response([
                'status' => 'errors',
                'message' => $result->Message
            ], 500);
        }
        // return $result;
    }

    // public function checkPaymentStatus(Request $request)
    // {
    //     $merchantCode = $this->merchant_code;
    //     $apiKey = $this->api_key;
    //     $merchantOrderId = $request->merchant_order_id;

    //     $signature = md5($merchantCode . $merchantOrderId . $apiKey);

    //     $params = array(
    //         'merchantCode' => $merchantCode,
    //         'merchantOrderId' => $merchantOrderId,
    //         'signature' => $signature
    //     );

    //     $params_string = json_encode($params);
    //     $url = 'https://sandbox.duitku.com/webapi/api/merchant/transactionStatus';

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Content-Length: ' . strlen($params_string)
    //     ])->post($url, $params);

    //     if ($response->successful()) {
    //         $result = json_decode($response, true);
    //     } else {
    //         $result = json_decode($response);
    //         return "Server Error: " . $result->Message;
    //     }
    //     return $result;
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->getRoleNames()[0] === 'admin') {
            $payments = Payment::all();
            return response(
                $payments
            );
        } else {
            $payments = Payment::where('user_id', '=', Auth::user()->id)->get();
            return response(
                PaymentItemResource::collection($payments)
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
