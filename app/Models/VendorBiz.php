<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class VendorBiz extends Model{


   protected $table="vendor_details";
   protected $fillable=[
    'user_id',
    'company_owner_name',
    'company_owner_last_name',
    'company_email',
    'company_picture',
    'company_status',
    'company_name',
    'company_street',
    'company_address',
    'company_city',
    'company_zipcode',
    'company_phone',
    'company_type',
    'company_pan',
    'company_gst',
    'company_otherinformatiion',
    'number_of_product_sell',
    'company_iec',
    'account_number',
    'ifsc_code',
    'gst_certificate_copy',
    'pan_copy',
    'copy_passbook',
    'account_name',
    'bank_address',
    'swift_code',
    'slug',
    'company_description'
   ];

   use HasSlug;
   /**
     * Get the options for generating the slug.
     */
    function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
            ->generateSlugsFrom('company_name')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }
}
