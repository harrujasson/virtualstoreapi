<?php

namespace App\Http\Middleware;

use Closure;
use Auth; 
use Redirect;
use App\Models\User;

class MerchantPermissions{
   
    function handle($request, Closure $next ){         
        
        if(Auth::check()){
            $user = Auth::user();
            if($user->isMerchant()){
                return $next($request);
            }
        }
        $request->session()->flash('error', 'Invalid Login');                
        return Redirect::route('login');                
        
    }
}
