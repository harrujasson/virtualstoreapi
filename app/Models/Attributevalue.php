<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Attributevalue extends Model{
  
   
   protected $table="attribute_value";
   protected $fillable=[
       'attribute_id','data','name'
   ];
   
}
