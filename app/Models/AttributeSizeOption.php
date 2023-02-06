<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class AttributeSizeOption extends Model{


   protected $table="attribute_size_options";
   protected $fillable=[
       'name','attribute_size_id'
   ];
}
