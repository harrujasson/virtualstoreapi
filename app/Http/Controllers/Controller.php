<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dnsloader($subdomain =''){   
            if(Session::has('subdomain') && Session::get('subdomain') == $subdomain) {
                return Session::get('mid');
            }else{
                Auth::logout();
                Session::flush();
                $mid =  dnsinfo($subdomain,'mid');
                session()->forget('subdomain');
                session()->forget('mid');
                session()->put('mid',$mid);
                session()->put('subdomain',$subdomain);
                session()->save();
                return $mid;
            }
        
    }
}
