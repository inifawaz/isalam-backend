<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $api_key;
    private $merchant_code;


    public function __construct()
    {
        $this->api_key = config('app.duitku_api_key');
        $this->merchant_code = config('app.duitku_merchant_code');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $api_key = $this->api_key;

        $merchantCode = $request->merchantCode;
        $amount = $request->amount;
        $merchantOrderId = $request->merchantOrderId;
        $productDetail = $request->productDetail;
        $additionalParam = $request->additionalParam;
        $paymentMethod = $request->paymentCode;
        $resultCode = $request->resultCode;
        $merchantUserId = $request->merchantUserId;
        $reference = $request->reference;
        $signature = $request->signature;
        $spUserHash = $request->spUserHash;

        if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
            $params = $merchantCode . $merchantOrderId . $amount . $api_key;
            $calcSignature = md5($params);

            if ($signature == $calcSignature) {
                $payment = Payment::where('reference', '=', $reference)->first();
                $transaction = Transaction::create(
                    [
                        "user_id" => Auth::user()->id,
                        "project_id" => $payment->project_id,
                        "merchant_code" => $merchantCode,
                        "merchant_order_id" => $merchantOrderId,
                        "reference" => $reference,
                        "payment_url" => $payment->payment_url,
                        "project_amount_given" => $payment->project_amount_given,
                        "maintenance_fee" => $payment->maintenance_fee,
                        "payment_fee" => $payment->payment_fee,
                        "amount" => $amount,
                        "va_number" => $payment['va_number'],
                        "payment_method" => $payment->payment_method,
                        "payment_method_name" => $payment->payment_method_name,
                        "payment_image" => $payment->payment_image,
                    ]
                );
            } else {
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);
                throw new Exception('Bad Signature');
            }
        } else {
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);
            throw new Exception('Bad Parameter');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
