<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use App\Models\Config;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $title='Store Configuration';
    protected $mid;
    public $domain;
    
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->domain = $request->subdomain; 
        $this->mid = $this->dnsloader($request->subdomain); 
        if(!$this->mid){
            return redirect()->to(base_site());
        } 
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
       
        return view('admin.dashboard');
    }
    function config(){
        $data['title'] = $this->title; 
        $data['r'] =Config::where('user_id',Auth::id())->where('mid',$this->mid)->first();
        //echo "<pre>"; print_r($data['r']); die();
        return view('admin.config',$data);
    }
    function config_save($domain,Request $request){
        $form_data = $request->all();
        if($request->file('logo')){
            $form_data['logo']=  $this->common->fileUpload($request->file('logo'),  './uploads/profile',1 );
        }
        if($request->file('invoice_logo')){
            $form_data['invoice_logo']=  $this->common->fileUpload($request->file('invoice_logo'),  './uploads/profile',1 );
        }

        unset($form_data['_token']);

        $is_exist  = Config::where('user_id',Auth::id())->where('mid',$this->mid)->count();

        if($is_exist){

            $form_data['user_id'] = Auth::id();
            $data  = Config::where('user_id',Auth::id());
            $status = $data->update($form_data);
        }else{
            $form_data['user_id'] = Auth::id();
            $form_data['mid'] = $this->mid;
            $data = new Config($form_data);
            $status = $data->save();
        }
        
        if($status){
            $request->session()->flash('success', 'Information has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
        
    }

    function profile(){   
        $data['title'] = $this->title;  
        
        $content['r'] = User::where('id',Auth::id())->where('mid',$this->mid)->first();
       
       
        return view('admin.profile',$content);
    }
    function my_profile_save($domain,Request $request){
        
        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.Auth::id(),
        ]);

        $form_data = $request->all();
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',1 );
        }
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }


}
