<?php

namespace App\Http\Resources;

use App\Helpers\OnaizaDuitku;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $status = OnaizaDuitku::checkPaymentStatus($this->merchant_order_id);
        return [
            "project_name" => $this->project->name,
            "merchant_order_id" => $this->merchant_order_id,
            "payment_url" => $this->payment_url,
            "amount" => $this->amount,
            "created_at" => $this->created_at,
            "status" => $status
        ];
    }
}
