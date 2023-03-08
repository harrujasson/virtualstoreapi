<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;


class Product extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => encode($this->id),
            'slug' => $this->slug,
            'mid' => encode($this->mid),
            'title' => $this->title,
            'short_description'=>  $this->short_description,
            'full_description'=>  $this->description,
            'regular_price'=>  $this->regular_price,
            'sale_price'=>  $this->sale_price,
            'tax_rate'=>  tex_info($this->tax_id,'rate'),
            'tax_name'=>  tex_info($this->tax_id,'name'),
            'sku_id'=>  $this->sku_id,
            'stock'=>  $this->stock,
            'weight'=>  $this->weight,
            'weight_type'=>  $this->weight_type,
            'width'=>  $this->width,
            'height'=>  $this->height,
            'length'=>  $this->length,
            'purchase_note'=>  $this->purchase_note,
            'ribon'=>  $this->ribon,
            'feature_image_file'=>  $this->feature_picture,
            'feature_image_url'=>  asset("uploads/product/". $this->feature_picture),
            'gallery_images_file'=>  $this->gallery_picture,
            'gallery_images_url'=>  asset("uploads/product/"),
            'new_arrival'=>  $this->new_arrival,
            'is_feature'=>  $this->feature,
            'mfg_distt'=>  $this->mfg_distt,
            'mfg_state'=>  $this->mfg_state,
            'mfg_country'=>  $this->mfg_country,
            'video_url'=>  $this->video_url,
            'size_chart_file'=>  $this->size_chart,
            'size_chart_url'=>  asset("uploads/product/". $this->size_chart),
            'status'=>  $this->status,
            'category_belong'=>$this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
