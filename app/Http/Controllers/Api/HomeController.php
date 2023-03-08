<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\AssignService;
use App\Models\Invite;
use App\Models\User;
use App\Models\Merchant;
use Hash;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class HomeController extends Controller
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
    function register_merchant(Request $request){

        $validator = Validator::make($request->all(), [
            'email' =>'required|email|unique:users',
            'password' =>'required'
        ],  $this->message_errors());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $form = $request->all();
        $data['name'] = $form['first_name'];
        $data['last_name'] = $form['last_name'];
        $data['email'] = $form['email'];
        $data['phone'] = $form['phone'];
        $data['password'] = Hash::make($form['password']);
        $data['role'] = 2;
        $data['address'] = $form['address'];
        $data['city'] = $form['city'];
        $data['state'] = $form['state'];
        $data['country'] = $form['country'];
        $data['zipcode'] = $form['zipcode'];
        $data['status'] = 1;

        $user = new User($data);
        if($user->save()){
            $user_id = $user->id;
            $merchant['user_id'] = $user->id;
            $merchant['name'] = $form['merchant_name'];
            $merchant['email'] = $form['merchant_email'];
            $merchant['trading_name'] = $form['merchant_trading_name'];
            $merchant['registration_number'] = $form['merchant_registration_number'];
            $merchant['registration_date'] = $form['merchant_registration_date'];
            $merchant['business_type_id'] = $form['merchant_business_type_id'];
            $merchant['address'] = $form['merchant_address'];
            $merchant['postcode_id'] = $form['merchant_postcode_id'];
            $merchant['mailing_address'] = $form['merchant_mailing_address'];
            $merchant['phone_number'] = $form['merchant_phone_number'];
            $merchant['registration_type'] = $form['merchant_registration_type'];
            $merchant['website'] = $form['merchant_website'];
            $merchant['status'] = 1;
            $merchant = new Merchant($merchant);
            $merchant->save();
            return response()->json(['success' => 'Merchant profile created'], $this->successStatus);
        }else{
            return response()->json(['error' => 'Something went wrong.'], $this->error);
        }

        
    }

    function message_errors(){
        return [
            'name.required'=>'Name Required',
            'email.required'=>'Email required',
            'password.required'=>'Password Required'
        ];
    }
}
