<?php

namespace App\Http\Resources;

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
        $amount_collected = 4500000;
        $amount_collected_percent = $amount_collected / $this->target_amount * 100;

        $first_choice_amount = $this->first_choice_amount;
        $second_choice_amount = $this->second_choice_amount;
        $third_choice_amount = $this->third_choice_amount;
        $fourth_choice_amount = $this->fourth_choice_amount;
        $choices_amount = array_filter([$first_choice_amount, $second_choice_amount, $third_choice_amount, $fourth_choice_amount], function ($item) {
            return $item > 0;
        });

        $backers = [
            [
                "name" => "Rusman Mustofa",
                "amount" => 150000,
                "date" => "10 menit yang lalu"
            ],
            [
                "name" => "Iqbal Andi Ramadan",
                "amount" => 200000,
                "date" => "2 hari yang lalu"
            ],
            [
                "name" => "Ibrohim Mulyadi",
                "amount" => 50000,
                "date" => "15 Sepetember 2022"
            ],
        ];

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
            "category" => $this->category->category,
            "name" => $this->name,
            "description" => $this->description,

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
            "choices_amount" => $choices_amount,

            "backers" => $backers,
            "updates" => $this->updates,
        ];
    }
}
