<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class AttributeSize extends Model{


   protected $table="attribute_size";
   protected $fillable=[
    'name',
    'label',
    'status'
   ];

   function options_value(){
        return $this->hasMany('App\Model\AttributeSizeOption', 'attribute_size_id', 'id');
   }
}
