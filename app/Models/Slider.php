<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model{
  
   
   protected $table="slider";
   protected $fillable=[
       'title','picture','link','subtitle','button_text','slide_type', 'picture_mobile', 'status'
   ];   
   
}
