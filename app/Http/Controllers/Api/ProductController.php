<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use Hash;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $successStatus = 200;
    public $error = 401;
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function product_all(Request $request){

        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        $result = Product::where('status',1)->with('category');
        if($mid){
            $result->where('mid',$mid);
        }
        $list['data'] =  ProductResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);
    } 

    function product_category(Request $request,$slug=''){
        $cat_id = Category::where('slug',$slug)->pluck('id')->first(); 
        if(!$cat_id){
            return response()->json(['error'=>'Invalid category'], $this->error);
        }

        $result = Product::whereHas('category',function($query) use ($cat_id){
            $query->where('category_id',$cat_id);
        })->with('category')->where('status',1);

        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        if($mid){
            $result->where('mid',$mid);
        }

        $list['data'] =  ProductResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);

    }
    function product_single(Request $request,$slug=''){
        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        $result = Product::where('slug',$slug)->with('category')->where('status',1);
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        if($mid){
            $result->where('mid',$mid);
        }
        $list['data'] =  ProductResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);
    }



    function message_errors(){
        return [
            'name.required'=>'Name Required',
            'email.required'=>'Email required',
            'password.required'=>'Password Required'
        ];
    }
}
