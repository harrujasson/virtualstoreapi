<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use DateTime;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Session;
use App\Model\Attribute;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct(){
        $this->common=new CommonController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    function texture_color_load(Request $request){
        $colors = \App\Model\Attributevalue::where('parent_id',$request->input('value'))->get();
        if(!empty($colors)){
            $return = array();
            foreach($colors as $r){
                $return[] = $r->data;
            }
            echo \GuzzleHttp\json_encode($return);
        }
    }


    function loadCroper(Request $request){
        ini_set('allow_url_fopen',1);
        $data['picture']=$request->input('pic');
        $data['ratio'] = $request->input('ratio');
        return view('ajax.cropperLoad',$data);
    }
    function imageCrop(Request $request){
        $value="";

       if($request->file('croppedImage')){
            $file=$request->file('croppedImage');
            $destinationPath = 'public/uploads/slider';
            $temp = explode(".",$file->getClientOriginalName());
            $filenamename=  $request->input('filename');
            $file->move($destinationPath,$filenamename);


            $this->common->resize_crop($destinationPath.'/'.$filenamename,$destinationPath.'/thumb/',$filenamename,113);
            $this->common->resize_crop($destinationPath.'/'.$filenamename,$destinationPath.'/medium/',$filenamename,600);
            $this->common->resize_crop($destinationPath.'/'.$filenamename,$destinationPath.'/large/',$filenamename,1000);
            $value=$filenamename;
            echo $value;
            die();
       }
    }

    function email_check(Request $request){
        return User::where('email',$request->input('email'))->count();
    }

}
