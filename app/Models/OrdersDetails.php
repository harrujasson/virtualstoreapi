<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model{

   protected $table="order_details";
   protected $fillable=[
       'order_id',
       'product_id',
       'product_name',
       'price',
       'qty',
       'tax',
       'tax_rate',
       'total',
       'product_variations',
       'order_return',
       'product_attachments'
   ];


}
