<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class GetState extends Model{
  
   
   protected $table="tbl_states";
   protected $fillable=[
       'name'
   ];   
   
}
