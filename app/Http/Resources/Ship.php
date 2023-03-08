<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Http\Resources\OrderDetails as OrderDetailsResource;


class Ship extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => encode($this->id),            
            'order_id' => encode($this->order_id),
            'client_id' => encode($this->user_id),
            'name' => $this->ship_name,
            'street' => $this->ship_street,            
            'address' => $this->ship_address,
            'city'=>  $this->ship_city,
            'state'=>  $this->ship_state,
            'country'=>  $this->ship_country,
            'postcode'=>  $this->ship_postcode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
