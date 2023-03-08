<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model{
   
   protected $table="shipping";
   protected $fillable=[       
       'order_id',
       'user_id',
       'ship_name',
       'ship_street',
       'ship_address',
       'ship_city',
       'ship_state',
       'ship_country',
       'ship_postcode' ,       
   ];
   
}
