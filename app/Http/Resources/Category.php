<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;


class Category extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'belong_category_main_id' => $this->main_id,            
            'belong_category_parent_id' => $this->parent,            
            
            'picture_image_file'=>  $this->picture,
            'picture_image_url'=>  asset("uploads/category/". $this->picture),

            'mobile_image_file'=>  $this->mobile_picture,
            'mobile_image_url'=>  asset("uploads/category/". $this->mobile_picture),

            'desktop_image_file'=>  $this->desktop_picture,
            'desktop_image_url'=>  asset("uploads/category/". $this->desktop_picture),
            'status'=>  $this->status,
            //'category_belong'=>$this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
