<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model{
  
   
   protected $table="product_attribute";
   protected $fillable=[
       'product_id','attribute_id','attribute_value'
   ];
   
}
