<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;


class OrderDetails extends JsonResource
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
            'order_id' => encode($this->order_id),
            'product_id' => encode($this->product_id),
            'product_name' => $this->product_name,
            'price' => $this->price,            
            'qty' => $this->qty,
            'tax'=>  $this->tax,
            'tax_rate'=>  $this->tax_rate,
            'total'=>  $this->total,
            'order_return'=>  $this->order_return,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
