<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{


   protected $table="product";
   protected $fillable=[
       'slug',
       'mid',
       'mid',
       'created_by',
       'title',
       'short_description',
       'description',
       'regular_price',
       'sale_price',
       'sku_id',
       'tax_id',
       'stock',
       'weight',
       'width',
       'height',
       'length',
       'purchase_note',
       'ribon',
       'feature_picture',
       'gallery_picture',
       'variations',
       'body_picture',
       'new_arrival',
       'seo_info',
       'status',
       'attribute_size_id',
       'mfg_distt',
       'mfg_state',
       'mfg_country',
       'video_url',
       'feature',
       'size_chart',
       'weight_type'
   ];


   use HasSlug;
   /**
     * Get the options for generating the slug.
     */
    function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
    function category(){
        return $this->hasMany('App\Models\CategoryProduct','product_id','id');
    }
    function attribute(){
        return $this->hasMany('App\Models\AttributeProduct','product_id','id');
    }
    function attribute_variations(){
        return $this->hasMany('App\Models\AttributeVariationsValue','product_id','id');
    }
    function tax(){
        return $this->hasMany('App\Model\Tax','id','tax_id');
    }
    function attribute_size(){
        return $this->hasOne('App\Models\AttributeSize','id','attribute_size_id');
    }

    function vendor_orders(){
        return $this->hasMany('App\Model\OrdersDetails','product_id','id');
    }

}
