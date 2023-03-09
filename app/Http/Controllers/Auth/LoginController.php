<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $mid;
    public $domain;
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        $this->domain = $request->subdomain; 
        $this->mid = $this->dnsloader($request->subdomain); 
        
        if(!$this->mid){
            return redirect()->to(base_site());
        } 
    }
    
    function login_form($domain){
        return view('auth.login');
    }
    public function login($domain,Request $request) {
        $this->validate($request, [
           'email' => 'required|string|email|max:255',
           'password' => 'required|string|min:6',
           ]
         );

       $remember = ($request->input('remember')) ? true : false;

       $email=$request->input('email');
       $password=$request->input('password');
         
       $auth = Auth::attempt(
           [
               'email'  => strtolower($request->input('email')),
               'password'  => $request->input('password'),
               'status' => 1,
               'mid'=>$this->mid,
           ], $remember
       );
       
       if($auth){

           if($remember){

               Cookie::queue("login_email", $email);
               Cookie::queue("login_password", $password);
           }

           
           session_start();
           $_SESSION['user_id']=Auth::id();
           if(Auth::user()->role=='3'){
               return redirect(route('admin.my_profile',[get_route_url()]));
           }elseif(Auth::user()->role=='2'){
               return redirect(route('customer.home',[get_route_url()]));
           }

       }else{
           $request->session()->flash('error', 'Your email/password combination was incorrect.!');
           return redirect(route('login',[get_route_url()]));
       }

   }

   public function login_front(Request $request) {

        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $auth = Auth::attempt(
            [
                'email'  => strtolower($request->input('email')),
                'password'  => $request->input('password'),
                'status' => 1,
                'mid'=>$this->mid,
            ]
        );

        if($auth){
            session_start();
            $_SESSION['user_id']=Auth::id();
            $request->session()->flash('success', 'Login successfully!');
            return json_encode(array('status'=>1));
            //return redirect()->back();
        }else{
            $request->session()->flash('error', 'Your email/password combination was incorrect.!');
            //return redirect(route('login'));
            return json_encode(array('status'=>0));
        }
        

    }
   function logout(Request $request) {
       Auth::logout();
       session_start();
       session_destroy();
       return redirect(route('login',[get_route_url()]));
   }
}
