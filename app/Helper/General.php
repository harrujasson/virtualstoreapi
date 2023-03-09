<?php


use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Config;
use App\Models\BlogCategory;
use App\Models\Tax;
use Illuminate\Support\Facades\Session;
function category_menu(){
    $result = Category::with('category')->where('parent',0)->where('status',1)->get();
    if(!$result->isEmpty()){
        return $result;
    }
}
function category_menu_main(){
    $result = Category::with('category')->where('type','Main')->where('status',1)->get();
    if(!$result->isEmpty()){
        return $result;
    }
}
function category_main_parent_menu($id=0){
    $result = Category::where('type','Parent')->where('main',$id)->where('status',1)->get();
    if(!$result->isEmpty()){
        return $result;
    }
}
function category_child_parent_menu($main_id = 0, $parent_id = 0){
    $result = Category::where('type','Normal')->where('main',$main_id)->where('status',1)->where('parent',$parent_id)->get();
    if(!$result->isEmpty()){
        return $result;
    }
}

function child_category($id=0){
    $child = Category::where('parent',$id)->where('status',1)->get();
    if(!$child->isEmpty()){
        return $child;
    }
}

function category_by_slug($slug='',$fld='id'){
    $result = category::where('slug',$slug)->where('status',1)->first();
    if(!empty($result)){
        return $result->$fld;
    }
}
function category_by_id($id='',$fld='slug'){
    $result = category::where('id',$id)->where('status',1)->first();
    if(!empty($result)){
        return $result->$fld;
    }
}
function get_category_info_by_slug($slug=''){
    $result = category::where('slug',$slug)->where('status',1)->first();
    if(!empty($result)){
        return $result;
    }
}
function sidebar_category(){
    $sidebar = Category::with('category')->where('status',1)->get();
    if(!$sidebar->isEmpty()){
        return $sidebar;
    }

}
function get_cat_count_product($cat_id=0){
    return CategoryProduct::where('category_id',$cat_id)->count();
}
function productinfo($id=0,$field=''){
   return App\Models\Product::where('id',$id)->pluck($field)->first();
}
function getbullet_point($sku=''){
    return App\Models\Bulletpoint::where('sku',$sku)->get();
}
function total_wishlist(){
    if(Auth::check()){
        $info =   \App\Models\Wishlist::where('user_id',Auth::id())
                ->groupBy('product_id')
                ->select('product_id', DB::raw('count(*) as total'))
                ->get();
        return count($info);

     }else{
         return 0;
     }
}
function userinfo($id=0,$fld=''){
    $user = User::where('id',$id)->first();
    if(!empty($user)){
        if($fld == ""){
            return $user;
        }else{
            return $user->$fld;
        }
    }
}
function deliver_charge(){
    $charge  = configinfo('deliver_charge');
    if($charge!=""){
        return number_format($charge,2);
    }else{
        return 0;
    }
}
function store_available(){
    $status =  configinfo('status');
    if($status == 0){
        return 'not_available';
    }
}


function latest_product(){
    $latest_product = Product::whereHas('category', function ($query) {
        $query->where('category_id','=','6');
    })->orderBy('created_at', 'desc')->take(4)->get();
     return $latest_product;
}
function currency(){
    return "BN ";
}
function seo_info_extract($info='',$fld=''){
    if($info!=""){
        $raw = json_decode($info);
        if(!empty($raw)){
            return $raw->$fld;
        }
    }
}
function seo_set_get_tags($tagname='', $value=''){
    $common = new CommonController();
    return $common->headTags($tagname,$value);
}
function seo_info_get($string_json =''){
    if($string_json!=""){
        return  json_decode($string_json);
    }
}
function seo_info_fill_field($seo='',$field=''){
    if(!empty($seo)){
        if(isset($seo->$field)){
            return $seo->$field;
        }
    }
}


function get_menu_active(){
    return Route::current()->getName();
}

function number_format_set($string=''){
    if($string!=""){
        return floatval(preg_replace("/[^-0-9\.]/","",$string));
    }else{
        return 0;
    }

}
function number_format_m($price='',$dots=''){
    if($price!=""){
        $price = (double) $price;
        return number_format($price, 2);
    }else{
        return 0;
    }
}



function check_product_vendor($id=0){
    return Product::where('id',$id)->where('created_by_type','Vendor')->count();
}

function order_status_icon($status = ''){
    if(!empty($status)){
        switch($status){
            case "Processing":
                return 'mdi-timer-sand';
                break;
            case "Pending Payment":
                return 'mdi-cash-multiple';
                break;
            case "On Hold":
                return 'mdi-blur-off';
                break;
            case "Cancelled":
                return 'mdi-file-remove';
                break;
            case "Refund":
                return 'mdi-cash-refund';
                break;
            case "Shipped":
                return 'mdi-truck-fast';
                break;
            case "Completed":
                return 'mdi-checkbox-marked-circle-outline';
                break;
            case "Failed":
                return 'bx-x-circle';
                break;
        }
    }
}

function order_info($id=0,$fld='id'){
    $result = Orders::where('id',$id)->first();
    if(!empty($result)){
        return $result->$fld;
    }
}
function product_attribute_size_list($id=0){
    return AttributeSizeOption::where('attribute_size_id',$id)->get();
}
function product_attribute_size_info($id=0){
    $result = AttributeSizeOption::where('id',$id)->first();
    if(!empty($result)){
        return $result->name;
    }
}
function encode($val=''){
    if($val){
       return str_replace(array('+', '/','='), array('', '',''), strrev(substr(md5(999),3,4).base64_encode(strrev("`".$val."~".substr(md5($val),0,10).'p04b54'))));
    }
}

function decode($code=''){
    if($code){
        $val = strrev(base64_decode(str_replace(array('', '',''), array('+', '/','='),strrev($code))));
        $val = ltrim(current(explode('~',$val)),'`');
        return $val;
    }
}

function get_product_category($product_id=0){
    $cats =  App\Models\CategoryProduct::where('product_id',$product_id)->get();
    $data  = array();
    if(!empty($cats)){
        foreach($cats  as $cat){
            $data[] = category_by_id($cat->category_id);
        }
    }
    return $data;
}
function array_to_string($array = array()){
    if(!empty($array)){
        return implode(",",$array);
    }
}
function attributevalue($id = 0,$fld='name'){
    $result = App\Models\Attributevalue::where('id',$id)->first();
    if(!empty($result)){
        return $result->$fld;
    }
}
function attributevalue_color($id = 0,$data=''){
    $result = App\Models\Attributevalue::where('attribute_id',$id)->where('data',$data)->first();
    if(!empty($result)){
        return $result->name;
    }
}
function productinfo_by_slug($slug='',$field=''){
    return App\Models\Product::where('slug',$slug)->pluck($field)->first();
 }
 function bloginfo_by_slug($slug='',$field=''){
    return App\Models\Blog::where('slug',$slug)->pluck($field)->first();
 }

 function get_reviews($product_id=0,$type='average'){
    $numberOfReviews = 0;
    $totalStars = 0;
    $average=0;
    $result = App\Models\Review::where('product_id', $product_id)->where('approve',1)->get();
    if(!$result->isEmpty()){
        foreach($result as $review){            
            $totalStars += $review->rating;
            $numberOfReviews++;
        }
        $average =  number_format( $totalStars/$numberOfReviews ,1);
    }
    if($type == "total"){
        $totalStars;
    }elseif($type == "average"){
        return $average;
    }elseif($type == "total_numbers"){
        return $numberOfReviews;
    }
 }
 function get_reviews_by_numbers_percent($id = 0,$type = '1'){
    $total_reviews = get_reviews($id,'total_numbers');
    $info = get_reviews_by_numbers($id);
    if($type == 1){
        return  percent_calculate($total_reviews,$info[1]);
    }elseif($type == 2){
        return  percent_calculate($total_reviews,$info[2]);
    }elseif($type == 3){
        return  percent_calculate($total_reviews,$info[3]);
    }elseif($type == 4){
        return  percent_calculate($total_reviews,$info[4]);
    }elseif($type == 5){
        return  percent_calculate($total_reviews,$info[5]);
    }
 }
 function percent_calculate($total=0,$number=0){
    if($total > 0){
        return number_format($number / $total * 100,2);
    }
    
 }

 function get_reviews_by_numbers($product_id=0){
    $data[1] = 0;
    $data[2] = 0;
    $data[3] = 0;
    $data[4] = 0;
    $data[5] = 0;
    $result = App\Models\Review::where('product_id', $product_id)->where('approve',1)->get();
    if(!$result->isEmpty()){
        foreach($result as $review){      
            if($review->rating == 1){
                $data[1] = $data[1]+1;
            }elseif($review->rating == 2){
                $data[2] = $data[2]+1;
            }elseif($review->rating == 3){
                $data[3] = $data[3]+1;
            }elseif($review->rating == 4){
                $data[4] = $data[4]+1;
            }elseif($review->rating == 5){
                $data[5] = $data[5]+1;
            }
        }
    }
    return $data;
 }
 function auth_info($role =''){
    if($role==""){
        $role = Auth::user()->role;
    }
    if($role == "3"){
        return "admin";
    }elseif($role == "2"){
        return "customer";
    }
}
   function featured_image($img_url=''){
    return asset('uploads/blogs/'.$img_url);
    //return asset('blog/img/release-notes-default.jpg');
  }
function blog_split_string($string=''){
    return substr(strip_tags($string),0,200).'..';
  }

  function blogCategory($cat ='',$fld='name'){
    $record = BlogCategory::where('slug',$cat)->first();
    if(!empty($record)){
        if($fld!=""){
            return $record->$fld;
        }else{
            return $record;
        }
    }
  }

function tex_info($id=0,$fld=''){
    $result = Tax::where('id',$id)->first(); 
    if(!empty($result)){
        if($fld == ""){
            return $result;
        }else{
            return $result->$fld;
        }
    }
}

function dnsinfo($dns='',$fld=''){
    $user = User::where('dns',$dns)->first();
    if(!empty($user)){
        if($fld == ""){
            return $user;
        }else{
            return $user->$fld;
        }
    }
}

function get_route_url(){
    return session()->get('subdomain');
}

function configinfo($fld=''){
    $dns = get_route_url();
    $user_id = dnsinfo($dns,'id');
    $config = Config::where('user_id',$user_id)->first();
    if(!empty($config)){
        if($fld == ""){
            return $config;
        }else{
            return $config->$fld;
        }
    }
}
function base_site(){
    return 'https://cybernauticstech-development.com';
}