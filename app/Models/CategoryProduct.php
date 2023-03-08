<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model{
  
   
   protected $table="product_category";
   protected $fillable=[
       'product_id','category_id'
   ];
   
}
