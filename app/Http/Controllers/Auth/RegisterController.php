<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CommonController;
use Illuminate\Contracts\Session\Session;
use App\Model\VendorBiz;


class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct()
    {
        $this->middleware('guest');
        $this->common=new CommonController();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    function message_errors(){
        return [
            'name.required'=>'Name required',
            'email.required'=>'Email required',
            'email.unique'=>'Email already exist',
            'password.required' => 'Password required'

        ];
    }

    function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' =>'required|unique:users',
            'password' =>'required'
        ],$this->message_errors());
        $formdata= $request->all();

        $formdata['password'] = Hash::make($request->input('password'));
        $formdata['role']  = 2;

        if($request->file('picture')){
            $formdata['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',1 );
        }



        $user = new User($formdata);
        if($user->save()){
            $request->session()->flash('success', 'User has been created');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
   
    function vendor_register(){

        return view('auth.vendor_register');
        
    }
    function vendor_register_save(Request $request){
        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email',
        ]);
        $form_data = $request->all();
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',0 );
        }
        $form_data['password'] = bcrypt($request->input('password'));

        $data =  new User($form_data);
        $data->role = 3;
        $data->status = 0;
        //echo "<pre>"; print_r($form_data); print_r($data); die();
        if($data->save($form_data)){
            $user_id =  $data->id;

            $form_data['user_id'] = $user_id;
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
            $vendor_data = new VendorBiz($form_data);
            $vendor_data->save($form_data);
            return redirect(route('vendor_register_success'));

        }
    }
  
    function vendor_success(){
        return view('auth.vendor_success');
    }
}
