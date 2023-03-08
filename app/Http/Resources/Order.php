<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Http\Resources\OrderDetails as OrderDetailsResource;
use App\Http\Resources\Ship as ShipResource;

class Order extends JsonResource
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
            'mid' => encode($this->mid),
            'client_id' => encode($this->user_id),
            'total' => $this->total,
            'tax' => $this->tax,            
            'payment_type' => $this->payment_type,
            'payment_status'=>  $this->payment_status,
            'product_ship_to'=>  $this->product_ship_to,
            'order_note'=>  $this->order_note,
            'comment'=>  $this->comment,
            'transaction_id'=>  $this->transaction_id,
            'cancel'=>  $this->cancel,
            'deliver_charge'=>  $this->deliver_charge,
            'order_details'=>OrderDetailsResource::collection(\App\Models\OrdersDetails::where('order_id',  $this->id)->orderBy('id','desc')->get()),
            'ship_details'=>ShipResource::collection(\App\Models\Shipping::where('order_id',  $this->id)->orderBy('id','desc')->get()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
