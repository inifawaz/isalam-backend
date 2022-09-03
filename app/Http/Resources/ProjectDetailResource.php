<?php

namespace App\Http\Resources;

use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDetailResource extends JsonResource
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

        $first_choice_amount = $this->first_choice_amount;
        $second_choice_amount = $this->second_choice_amount;
        $third_choice_amount = $this->third_choice_amount;
        $fourth_choice_amount = $this->fourth_choice_amount;
        $choice_amount = array_filter([$first_choice_amount, $second_choice_amount, $third_choice_amount, $fourth_choice_amount], function ($item) {
            return $item > 0;
        });

        $backers = array();
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $backers[] = [
                "name" => $user->full_name,
                "project_amount_given" => $payment->project_amount_given,
                "paid_at" => Carbon::parse($payment->created_at)->diffForHumans()

            ];
        }

        // $updates = [
        //     [
        //         "date" => "2 Agustus 2022",
        //         "content" => "Praesent iaculis tincidunt condimentum. Donec eget turpis in risus semper pellentesque in sit amet ligula. Aenean ac dapibus magna. Suspendisse laoreet ut magna eu molestie. Praesent vitae ex et orci gravida tincidunt. Maecenas viverra, magna a convallis fermentum, turpis leo consequat orci, sed euismod diam erat eu felis. In faucibus volutpat venenatis. Vivamus tincidunt ex nec neque volutpat dapibus. Aliquam ullamcorper lobortis massa id cursus.Curabitur tempor augue eget ipsum ornare lobortis. Pellentesque eget"
        //     ],
        //     [
        //         "date" => "10 Agustus 2022",
        //         "content" => "Praesent iaculis tincidunt condimentum. Donec eget turpis in risus semper pellentesque in sit amet ligula. Aenean ac dapibus magna. Suspendisse laoreet ut magna eu molestie. Praesent vitae ex et orci gravida tincidunt. Maecenas viverra, magna a convallis fermentum, turpis leo consequat orci, sed euismod diam erat eu felis. In faucibus volutpat venenatis. Vivamus tincidunt ex nec neque volutpat dapibus. Aliquam ullamcorper lobortis massa id cursus.Curabitur tempor augue eget ipsum ornare lobortis. Pellentesque eget"
        //     ],
        //     [
        //         "date" => "17 Agustus 2022",
        //         "content" => "Praesent iaculis tincidunt condimentum. Donec eget turpis in risus semper pellentesque in sit amet ligula. Aenean ac dapibus magna. Suspendisse laoreet ut magna eu molestie. Praesent vitae ex et orci gravida tincidunt. Maecenas viverra, magna a convallis fermentum, turpis leo consequat orci, sed euismod diam erat eu felis. In faucibus volutpat venenatis. Vivamus tincidunt ex nec neque volutpat dapibus. Aliquam ullamcorper lobortis massa id cursus.Curabitur tempor augue eget ipsum ornare lobortis. Pellentesque eget"
        //     ]
        // ];


        return [
            "id" => $this->id,
            "category" => $this->category->name,
            "name" => $this->name,
            "description" => $this->description,
            "location" => $this->location,
            'picture_url' => asset('assets/img/projects/pictures') . '/' . $this->picture_url,
            "instagram_url" => $this->instagram_url,
            "facebook_url" => $this->facebook_url,
            "twitter_url" => $this->twitter_url,

            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "days_left" => now()->diffInDays($this->end_date),


            "maintenance_fee" => $this->maintenance_fee,
            "target_amount" => $this->target_amount,
            "amount_collected" => $amount_collected,
            "amount_collected_percent" => $amount_collected_percent,
            "choice_amount" => $choice_amount,
            "days_left" => now()->diffInDays($this->end_date),

            "backers_count" => count($backers),
            "updates" => $this->updates,
            "backers" => $backers


        ];
    }
}
