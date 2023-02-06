<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Review extends Model{
  
   
   protected $table="review";
 
   protected $fillable=[
       'name','email','comment','rating','picture','product_id','approve'
   ];   
   
}
