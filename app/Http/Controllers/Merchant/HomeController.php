<?php

namespace App\Http\Controllers\Merchant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Package;
use App\Models\PackageService;
use App\Models\Order;
use Auth;
use App\Library\Beep;
use App\Models\AssignService;
use App\Models\Vstore;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){       
        $content['pending'] =Order::where('payment_status','Pending')->count();
        $content['paid'] =Order::where('payment_status','Paid')->count();
        $content['fail'] =Order::where('payment_status','Failed')->count();   
        $content['dns'] = Vstore::where('user_id',Auth::id())->first();
        return view('merchant.dashboard',$content);
    }

    function activate_store(Request $request){
        

        $slug_string = strtolower($request->input('dns_name'));
        $slug = str_replace(" ","-",$slug_string);
        
        $exist= Vstore::where('dns_name',$slug)->count();
        if($exist){
            return json_encode(array('success'=>0,'exist'=>'1','message'=>'This DNS already exisst. Please try with different name!'));
        }

        $data['user_id'] = Auth::id();
        $data['merchant_id'] = Auth::user()->merchant_id;
        $data['dns_name'] = $slug;

        $api['mid'] =  Auth::user()->merchant_id;
        $api['dns'] = $slug;
        $api['first_name'] = $request->input('first_name');
        $api['last_name'] = $request->input('last_name');
        $api['email'] = Auth::user()->email;
        $api['phone'] = $request->input('phone');
        $api['password'] = $request->input('password');
        
        
        $response =  $this->register_general_store_api($api);
        
        if(isset($response->error)){
            $error_api_message = '<ol>';
            foreach($response->error as $apierr){
                $error_api_message.='<li>'.$apierr[0].'</li>';
            }
            $error_api_message.= '</ol>';
            return json_encode(array('success'=>0,'exist'=>'0','message'=>$error_api_message));
        } 
        $ins = new Vstore($data);
        if($ins->save()){
            return json_encode(array('success'=>1,'exist'=>'0','message'=>'DNS has been created successfully!'));
        }else{
            return json_encode(array('success'=>0,'exist'=>'0','message'=>'Something went wrong, please try after some time!'));
        }
    }

    function register_general_store_api($data=  array()){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://general-store.cybernauticstech-development.com/api/v1/store-register',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Pass-Key: 34f038ad8dc5f7a35fdabd4dd13430a1'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }

    function profile(){
        $content['r'] = User::where('id',Auth::id())->first();
        return view('merchant.profile',$content);
    }
    function my_profile_save(Request $request){
        $request->validate([
            'new_password' => 'required'
        ]);
        $form_data = $request->all();
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }

        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Password has been updated');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    
    function my_product(){
        $content['package'] = AssignService::where('user_id',Auth::id())
        ->where('is_current',1)
        ->where('status',1)
        ->where('service_type','Package')
        ->first();

        $content['service_in'] = AssignService::where('user_id',Auth::id())
        ->where('is_current',1)
        ->where('status',1)
        ->where('service_type','Service')
        ->get();

        return view('merchant.my_product',$content);
    }
    function package(){
        $data['record'] = Package::where('status',1)->get();
        return view('merchant.package',$data);
    }
    function package_bill($id=''){

        $id = decode($id);
        $data['r'] = Package::where('status',1)->where('id',$id)->first();
        $data['service'] = PackageService::where('status',1)->where('type','Service')->get();        
        $data['id'] = encode($id);
        return view('merchant.package_bill',$data);

    }

    function package_bill_process(Request $request,$id){

        $id = decode($id);
        $info = Package::where('status',1)->where('id',$id)->first();
        if(!empty($info)){
            $package_price = $info->regular_price;
            $service_price = 0;
            if($info->sale_price!="" ){
                $package_price = $info->sale_price;
            }
            $package_info_all =  $info;
            $service_info = array();
            unset($package_info_all['created_at']);
            unset($package_info_all['updated_at']);
            $packageinfo['package_info'] = json_encode($package_info_all);
            $packageinfo['service_id']='';
            if($request->has('service_list')){
                foreach($request->input('service_list') as $ser){
                    $service_price+= service_info($ser,'price');
                    $service_info[] = service_info($ser,'all');
                    
                }
                $packageinfo['service_id'] = implode(',',$request->input('service_list'));
            }
            $final_price = $package_price+ $service_price;

            $packageinfo['service_info'] = json_encode($service_info);
            $packageinfo['package_id'] = $id;
            $packageinfo['user_id'] = Auth::id();            
            $packageinfo['amount'] = $final_price;
            $this->process_order($final_price,$packageinfo);
        }else{
            redirect()->back();
        }
    }
        
    function process_order($price,$package){
        
        $order = new Order($package);
        if($order->save()){
            $payment = new Beep();
            $data['order_id'] = $order->id;
            //$data['order_amount'] = $price;
            $data['order_amount'] = 1;
            $url =  $payment->make_payment($data);
            if(!empty($url)){
                echo "<script>window.location.href='".$url."'</script>";
            }
            die();
        }
        
        
    }
    
    
}
