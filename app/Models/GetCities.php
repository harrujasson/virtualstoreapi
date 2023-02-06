<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class GetCities extends Model{
  
   
   protected $table="tbl_cities";
   protected $fillable=[
       'name'
   ];   
   
}
