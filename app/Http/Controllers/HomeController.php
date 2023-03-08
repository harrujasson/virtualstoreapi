<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page=8;
    protected $common;
    protected $mid;
    public $domain;
    public function __construct(Request $request){   
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
    public function index($account){  
        
        $data['feature']=Product::where('mid',$this->mid)->take(12)->get();   
        return view('front.home',$data)->with('callback',$this);
    }
    function testdomain($account,$id=0){
        echo $account; echo $id; die();
        echo route('testdomain',[$account,'147']); die();
        echo "MID ".$this->mid; die();
    }
    
}
