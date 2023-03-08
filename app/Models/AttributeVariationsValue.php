<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AttributeVariationsValue extends Model{
  
   
   protected $table="attribute_variations_value";
   protected $fillable=[
       'product_id','attribute_id','attr_value_name','attr_value_name_price','attr_value_name_picture','attr_value_name_label'
   ]; 
}
