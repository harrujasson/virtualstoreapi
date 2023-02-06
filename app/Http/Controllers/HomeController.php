<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use App\Models\Product;
use App\Models\Category;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page=8;
    protected $common;
    public function __construct(){
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){  
        $data['feature']=Product::take(12)->get();
        return view('front.home',$data)->with('callback',$this);
    }
    
}
