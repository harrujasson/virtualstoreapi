<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dnsloader($subdomain =''){   
            if(Session::has('subdomain') && Session::get('subdomain') == $subdomain) {
                return Session::get('mid');
            }else{
                $mid =  dnsinfo($subdomain,'mid');
                Session::put('mid',$mid);
                Session::put('subdomain',$subdomain);
                return $mid;
            }
        
    }
}
