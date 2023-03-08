<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model{
  
   
   protected $table="home_slider";
   protected $fillable=[
       'ip_address','picture'
   ];   
   
}
