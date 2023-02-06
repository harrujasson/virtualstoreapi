<?php

namespace App\Http\Middleware;

use Closure;
use Auth; 
use Redirect;
use App\Models\User;

class ApiKeyCheck{
    private $fix_pass = '34f038ad8dc5f7a35fdabd4dd13430a1';
    function handle($request, Closure $next ){ 

        $headers = apache_request_headers();  
        if(isset($headers['Pass-Key']) && $headers['Pass-Key'] != "" ){
            if($this->fix_pass == $headers['Pass-Key']){
                return $next($request);
            }else{
                return response()->json(['error' => 'Invalid Pass Key.'], 401);
            }
        } else{
            return response()->json(['error' => 'Missing Pass Key.'], 401);
        } 
    }
    
}

