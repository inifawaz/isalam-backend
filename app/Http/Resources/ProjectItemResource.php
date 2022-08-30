<?php

namespace App\Http\Resources;

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
        $amount_collected = 4500000;
        $amount_collected_percent = $amount_collected / $this->target_amount * 100;

        return [
            'id' => $this->id,
            'category' => $this->category->category,
            'name' => $this->name,
            "target_amount" => $this->target_amount,
            "days_left" => now()->diffInDays($this->end_date),
            "amount_collected" => $amount_collected,
            "amount_collected_percent" => $amount_collected_percent,
            'picture_url' => asset('assets/img/projects/pictures') . '/' . $this->picture_url,
        ];
    }
}
