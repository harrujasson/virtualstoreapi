<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\supportRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Session;

use Auth;
use Cart;
use App\Library\Beep;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

   


    function transaction_status_update_create($order_id=0,$transaction_id='',$status='',$mode=''){
        $data['transaction_id'] = $transaction_id;
        $data['payment_status'] = $status;
        $data['payment_type'] = $mode;

        $data_save = \App\Model\Orders::find($order_id);
        if($data_save->update($data)){
            return 1;
        }
    }
    function transaction_status_update_status($id='',$payment_id,$trans,$status,$mode=''){
        $data['payment_status'] = 'Paid';
        $data['payment_id'] = $payment_id;
        $data['transaction_id'] = $trans;
        $data['payment_type'] = $mode;
       
        $data_save = \App\Models\Orders::find($id);
      
        if($data_save->update($data)){
           
            $order_info =$data_save->first();
            $user_email = \App\Models\User::where('id',$order_info->user_id)->pluck('email')->first();
            $shop = New ShopController();
            $shop->send_invoice_email($id,$user_email);
            return 1;
        }
    }
    
    function payment_status_process_update($id,$data,$type='Online'){
        $record = \App\Models\Paymentorder::find($id);
        $record->update($data);

        $this->transaction_status_update_status($record->record_id,$id,$data['pay_id'], 'Paid',$type);

    }
    function transaction_failed(){
        $data['transaction_id'] = '';
        $data['failed'] = 1;
        return view('front.payment.status',$data);
    }
    function transaction_cancel(){
        return view('front.payment.cancel');
    }
   
    function beep_payment($domain,$order_id=0){
        $order_id = decode($order_id);
        $order_details = \App\Models\Orders::where('id',$order_id)->first();
        if(!empty($order_details)){
            $order['record_id'] = $order_id;
            $order['table_name'] = 'order';
            $order['table_field'] = 'orders';
            $order['order_amount'] = $order_details->total+$order_details->tax;
            $data  = new \App\Models\Paymentorder($order);
            $data->save();
            $invoice_id = $data->id;
            $order['invid'] = encode($invoice_id);
            //echo $order['invid']; die();
            $payment = new Beep();
            $price = $order_details->total+$order_details->tax;
            
            $payemntdata['order_id'] = $order['invid'];
            //$data['order_amount'] = $price;
            $payemntdata['order_amount'] = 1;
            $url =  $payment->make_payment($payemntdata);
            if(!empty($url)){
                echo "<script>window.location.href='".$url."'</script>";
            }
            die();
        }else{
            return redirect('/');
        }
    }
    function beep_payment_method_response($domain,Request $request){
        $response = $request->all();
        //echo "<pre>"; print_r($response); die();
            if($request->has('Type')!="failure"){
               
                $id = decode($request->get('order_id'));
                $order_details = \App\Models\Paymentorder::where('id',$id)->first();
                
                if(!empty($order_details)){
                    $payment_save['pay_id'] = $request->get('order_id');
                    $payment_save['status']= 'Paid';
                    $payment_save['transaction_id']= $request->get('order_id');
                   
                    $this->payment_status_process_update($id,$payment_save,'Online');
                    \Cart::destroy();
                    return redirect(route('payment.payment_success',[get_route_url(),$request->get('order_id')]));
                }else{
                    \Session::flash('error', "Payment has been failed. Plesae try after some time.");
                    return redirect(route('payment.payment_cancel',[get_route_url()]));
                }
            }else{
                \Session::flash('error', "Payment has been failed. Plesae try after some time.");
                return redirect(route('payment.payment_cancel',[get_route_url()]));
            }
        }
        

 

    function success($id=''){
        $data['failed'] = 0;
        $data['transaction_id'] = $id;
        return view('front.payment.status',$data);
    }
}
