<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Auth;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageService;
use App\Library\Beep;
use App\Models\AssignService;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('client.dashboard');
    }

    function profile(){
        $content['r'] = User::where('id',Auth::id())->first();
        return view('client.profile',$content);
    }
    function my_profile_save(Request $request){
        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.Auth::id()
        ]);
        $form_data = $request->all();
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',1 );
        }
        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated');
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

        return view('client.my_product',$content);
    }
    function package(){
        $data['record'] = Package::where('status',1)->where('created_by',Auth::user()->merchant_id)->get();
        return view('client.package',$data);
    }
    function package_bill($id=''){

        $id = decode($id);
        $data['r'] = Package::where('status',1)->where('id',$id)->where('created_by',Auth::user()->merchant_id)->first();
        $data['service'] = PackageService::where('status',1)->where('created_by',Auth::user()->merchant_id)->where('type','Service')->get();        
        $data['id'] = encode($id);
        return view('client.package_bill',$data);
    }

    function package_bill_process(Request $request,$id){

        $id = decode($id);
        $info = Package::where('status',1)->where('created_by',Auth::user()->merchant_id)->where('id',$id)->first();
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

    function transaction(){
        return view('client.transaction');
    }
}
