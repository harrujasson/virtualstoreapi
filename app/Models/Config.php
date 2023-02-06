<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Config extends Model{


   protected $table="config_store";
   protected $fillable=[
       'store_name',
       'logo',
       'address',
       'invoice_logo',
       'invoice_address',
       'status',
       'phone',
       'email',
       'pickup_from',
       'pickup_to',
       'deliver_charge',
       'user_id',
       'status'
   ];
   

}
