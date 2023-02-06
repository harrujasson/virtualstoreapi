<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\User;
use App\Model\VendorBiz;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct(){
        $this->middleware('auth');
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        return view('vendor.home');
    }
    function myprofile(){
        $content['r'] = User::where('id',Auth::id())->first();
        $content['vendor'] = VendorBiz::where('user_id',Auth::id())->first();
        return view('vendor.profile',$content);
    }
    function myprofile_save(Request $request){

        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.Auth::id(),
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',0 );
        }
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            return redirect(route('vendor.myprofile'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('vendor.myprofile'));
        }
    }

    function vendor_details_save(Request $request){

        $form_data = $request->all();

        unset($form_data['_token']);

        if($request->file('company_picture')){
            $form_data['company_picture']=  $this->common->fileUpload($request->file('company_picture'),  './uploads/profile',0 );
        }
        if($request->file('gst_certificate_copy')){
            $form_data['gst_certificate_copy']=  $this->common->fileUpload($request->file('gst_certificate_copy'),  './uploads/profile',0 );
        }
        if($request->file('pan_copy')){
            $form_data['pan_copy']=  $this->common->fileUpload($request->file('pan_copy'),  './uploads/profile',0 );
        }
        if($request->file('copy_passbook')){
            $form_data['copy_passbook']=  $this->common->fileUpload($request->file('copy_passbook'),  './uploads/profile',0 );
        }
        //echo "<pre>"; print_r($form_data); die();
        $data =  VendorBiz::where("user_id",Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            if($request->has('account_number')){
                return redirect(route('vendor.myprofile')."#account");
            }else{
                return redirect(route('vendor.myprofile')."#business");
            }

        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('vendor.myprofile')."#business");
        }
    }

}
