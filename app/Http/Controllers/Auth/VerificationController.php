<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Config;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->common=new CommonController();
    }
    public function verifyUser($token =''){
      
        Auth::logout();
        session_start();        
        session_destroy();
        
        $verifyUser = \App\User::where('id', $token)->first();
        
        if(!empty($verifyUser) ){
            
            if(!$verifyUser->email_verified_at) {
              $verifyUser->email_verified_at = now();
              $verifyUser->status = 1;
              $verifyUser->save();
              Session::flash('success', 'Your e-mail is verified. You can now login.');
              return redirect(route('login'));
            } else {
              
              Session::flash('error', 'Your e-mail is already verified. You can now login.');
              return redirect(route('login'));
            }
        } else {
          Session::flash('warning', 'Sorry your email cannot be identified.');
          return redirect(route('login'));
        }
    }
}
