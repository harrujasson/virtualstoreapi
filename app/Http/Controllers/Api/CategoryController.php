<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryProduct;
use Hash;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
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
    function all(Request $request){

        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        $result = Category::where('status',1);
        if($mid){
            $result->where('mid',$mid);
        }
        $list['data'] =  CategoryResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);
    } 

    function single(Request $request,$slug=''){
        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        $result = Category::where('slug',$slug)->where('status',1);
       
        if($mid){
            $result->where('mid',$mid);
        }
        $list['data'] =  CategoryResource::collection($result->get());
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
