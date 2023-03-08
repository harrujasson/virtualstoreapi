<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Paymentorder extends Model{
   use Notifiable;
   protected $table="paymentorder"; 
   protected $fillable=[
       'record_id', 
       'table_name', 
       'table_field',
       'order_amount',
       'recv_amount',
       'recv_date',
       'status',
       'error_msg',  
       'pay_id',
       'transaction_id'
   ];

}
