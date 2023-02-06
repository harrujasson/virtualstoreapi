<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model{
   
   protected $table="orders";
   protected $fillable=[       
       'user_id',
       'mid',
       'total',
       'tax',
       'payment_type',
       'payment_status',
       'status',
       'product',
       'product_ship_to',
       'order_note',
       'comment',
       'transaction_id',
       'cancel',
       'deliver_charge',
       'mid'
       
   ];
   
   function order_details(){
       return $this->hasMany('App\Models\OrdersDetails','order_id','id');
   }
   function shipping(){
       return $this->belongsTo('App\Models\Shipping','id','order_id');
   }
   function user(){
       return $this->hasOne('App\Models\User','id','user_id');
   }
   
}
