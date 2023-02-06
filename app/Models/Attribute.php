<?php

namespace App\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model{


   protected $table="attribute";
   protected $fillable=[
       'slug','name','label','parent','type'
   ];
   function attribute_value(){
       return $this->hasMany('App\Model\Attributevalue', 'attribute_id', 'id');
   }
   use HasSlug;
   /**
     * Get the options for generating the slug.
     */
    function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }

}
