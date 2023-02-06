<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrdersDetails;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Shipping;

use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
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
        $result = Orders::query();
        if($mid){
            $result->where('mid',$mid);
        }

        if($request->has('payment_status')){
            $result->where('payment_status',$request->get('payment_status'));
        }
        if($request->has('payment_type')){
            $result->where('payment_type',$request->get('payment_type'));
        }
        if($request->has('payment_type')){
            $result->where('payment_type',$request->get('payment_type'));
        }
        $list['data'] =  OrderResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);
    } 

    function single(Request $request,$id=''){
        $mid  = 0;
        if($request->has('mid')){
            $mid = $request->get('mid');
        }
        $id = decode($id);
        $result = Orders::where('id',$id);
        if($mid){
            $result->where('mid',$mid);
        }
        $list['data'] =  OrderResource::collection($result->get());
        return response()->json(['success'=>$list], $this->successStatus);
    }
    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' =>'required',
            'order_details' =>'required',
            'total' =>'required',
            'tax_total' =>'required',
            'deliver_charge'=>'required',
            'order_note'=>'required',
            'product_ship_to'=>'required',
        ],  $this->message_order_errors());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $order_id = 0;
        $user_id = decode($request->input('client_id'));
        $order['user_id'] = $user_id;
        $order['product'] = $request->input('order_details');
        $order['deliver_charge']= $request->input('deliver_charge');
        $order['total']=$order['deliver_charge']+ $request->input('total');
        $order['tax']= $request->input('tax_total');
        $order['payment_status'] ='non-paid';
        $order['order_note']=$request->input('order_note');
        $order['product_ship_to'] =$request->input('product_ship_to');

        $mid  = 0;
        if($request->has('mid')){
            $order['mid'] = $request->get('mid');
        }else{
            $order['mid'] =0;
        }

        $order_save = new Orders($order);
        if($order_save->save()){
            $order_id = $order_save->id;
            $content = $request->input('order_details');
            $content = json_decode($content);
            if(!empty($content)){
                foreach($content as $p){
                    $variations='';
                    $total_tax = 0;
                    $order_details['order_id'] = $order_id;
                    $order_details['product_id'] = $p->id;
                    $order_details['product_name'] = $p->name;
                    $order_details['price'] = $p->price;
                    $order_details['qty'] = $p->qty;
                    if($p->options->tax){

                        $order_details['tax_rate'] = $p->options->tax_rate;
                        $total_tax = $p->options->tax * $p->qty;
                        $order_details['tax'] = $total_tax;

                    }else{
                        $order_details['tax_rate']=0;
                        $order_details['tax']=0;
                    }
                    
                    $order_details['product_variations']='';
                    $order_details['product_attachments'] ='';
                    $order_details['total'] = ($p->price * $p->qty) + $total_tax;

                    $order_details_save = new OrdersDetails($order_details);
                    $order_details_save->save();

                }
            }
        }

        $ship['order_id'] = $order_id;
        $ship['user_id'] = $user_id;

        if($request->has('ship')){

            $ship['ship_name'] = $request->input('ship_name');
            $ship['ship_street'] = $request->input('ship_street');
            $ship['ship_address'] = $request->input('ship_address');
            $ship['ship_city'] = $request->input('ship_city');
            $ship['ship_state'] = $request->input('ship_state');
            $ship['ship_country'] = $request->input('ship_country');
            $ship['ship_postcode'] = $request->input('ship_postcode');

        }else{
            $user = User::where('id',$user_id)->first();
            $ship['ship_name'] = $user->name;
            $ship['ship_street'] = $user->street;
            $ship['ship_address'] = $user->address;
            $ship['ship_city'] = $user->city;
            $ship['ship_state'] = $user->state;
            $ship['ship_country'] = $user->country;
            $ship['ship_postcode'] = $user->postcode;
        }

        $ship_save = new Shipping($ship);
        $ship_save->save();
        return response()->json(['success'=>"Order has been generated successfully",'order_id'=>encode($order_id)], $this->successStatus);

    }
    function payment_verify(Request $request,$id=''){

        $validator = Validator::make($request->all(), [
            'payment_status' =>'required',
            'payment_id' =>'required',
            'transaction_id' =>'required',
            'payment_type' =>'required',
        ],  $this->message_errors());

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $id = decode($id);

        $data['payment_status'] = $request->input('payment_status');
        $data['payment_id'] = $request->input('payment_id');
        $data['transaction_id'] = $request->input('transaction_id');
        $data['payment_type'] = $request->input('payment_type');

        $data_save = Orders::find($id);
        if($data_save->update($data)){
            return response()->json(['success'=>"Order has been updated successfully"], $this->successStatus);
        }else{
            return response()->json(['error'=>"Something went wrong"], $this->error);
        }
    }
    function message_errors(){
        return [
            'payment_status.required'=>'Payment Status required',
            'payment_id.required'=>'Payment ID required',
            'transaction_id.required'=>'Transaction ID Required',
            'payment_type.required'=>'Payment Type Required'
        ];
    }
    function message_order_errors(){
        return [
            'client_id.required'=>'Client ID Required',
            'order_details.required'=>'Order Details Required',
            'total.required'=>'Total Required',
            'tax_total.required'=>'Tax Required',
            'deliver_charge.required'=>'Deliver charge Required',
            'order_note.required'=>'Order Note Required',
            'product_ship_to.required'=>'Shipping Required'
        ];
    }
}
