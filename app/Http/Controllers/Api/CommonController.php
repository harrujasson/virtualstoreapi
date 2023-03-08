<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Resources\Product as ProductResource;

class CommonController extends Controller
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

    function store_register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|unique:users',
            'mid' =>'required|unique:users',
            'password' =>'required',
            'dns'=>'required|unique:users',
        ],  $this->message_errors());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $form = $request->all();
        $data['name'] = $form['first_name'];
        $data['dns'] = $form['dns'];
        $data['mid'] = $form['mid'];
        $data['last_name'] = $form['last_name'];
        $data['email'] = $form['email'];
        $data['phone'] = $form['phone'];
        $data['password'] = Hash::make($form['password']);
        $data['role'] = 3;        
        $data['status'] = 1;
        $data['secret_key'] = md5(date('dmyh:i:s').rand(65741,587957));
        //echo "<pre>"; print_r($data); die();
        
        $user = new User($data);
        if($user->save()){
            return response()->json(['success' => 'Store created'], $this->successStatus);
        }else{
            return response()->json(['error' => 'Something went wrong.'], $this->error);
        }
    }
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
            'mid.unique'=>'This merchant ID already register',
            'dns.unique'=>'This Domain already register',
            'password.required'=>'Password Required'
        ];
    }
}
