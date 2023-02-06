<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TrackOrder extends Model{


   protected $table="order_tracking";
   protected $fillable=[
       'type','post_by','track_type','track_message','item_id'
   ];

}
