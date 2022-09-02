<?php

namespace App\Http\Resources;

use App\Http\Controllers\TransactionController;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $payments = Payment::where('project_id', '=', $this->id)->get();
        $amount_collected = $payments->sum('project_amount_given') ?? 0;
        $amount_collected_percent = $amount_collected / $this->target_amount * 100;

        return [
            'id' => $this->id,
            'category' => $this->category->name,
            'location' => $this->location,
            'name' => $this->name,
            "target_amount" => $this->target_amount,
            "days_left" => now()->diffInDays($this->end_date),
            "amount_collected" => $amount_collected,
            "amount_collected_percent" => $amount_collected_percent,
            "backers_count" => $payments->count() ?? 0,
            'picture_url' => asset('assets/img/projects/pictures') . '/' . $this->picture_url,
        ];
    }
}
