<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Get_country extends Model{
  
   
   protected $table="tbl_countries";
   protected $fillable=[
       'name',
       'sortname'
   ];   
   
}
