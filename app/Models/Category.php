<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{


   protected $table="category";
   protected $fillable=[
       'slug', 'mid', 'name','parent','picture','type','main','status','mobile_picture','desktop_picture'
   ];

   function category(){
        return $this->hasMany('App\Models\CategoryProduct','category_id','id');
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
