<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\AssignService;
use App\Models\Invite;
use App\Models\User;
use Hash;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    function notifications(){
        $content['package'] = AssignService::where('is_current',1)
        ->where('status',1)
        ->where('service_type','Package')
        ->get();
        if(!empty($content['package'])){
            foreach($content['package'] as $package){
                $days = get_remain_days_package(date('d-m-Y',strtotime($package->created_at)),$package->duration); 
                if( $days ){   

                    if($days < 8){
                        $title= package_info($package->service_id,'name');
                        $content = "This package will be expire in ".$days;
                        $this->email_send($title,$content);
                    }
                }else{                   
                    $title= package_info($package->service_id,'name');
                    if(is_plan_grace_period()){
                        $content = "This package is already expire , so we active the grace period for 15 days";
                    }else{
                        $content = "This package is already expire. Even your grace period also expired.";
                    }
                    $this->email_send($title,$content,1);
                }
            }
        }
    }

    function email_send($package_title='',$content='',$grace=''){
        $email['title']= $package_title;
        $email['content'] = $content;
        $email['grace'] = $grace;
        $view = View('email.appexpire',$email);
        $content =$view->render();
        $to ="harrujasson@gmail.com";
        //$to = config('constants.support.email');
        $this->common->sendSMTPSystem($to, "Package Expire Alert - ".$package_title,$content);
    }
    function expire_application(){
        $record = $this->api->applicationCron();
        $data['error'] =  error_response($record);
        $data['record'] =  process_data_response($record);

        if(!empty($data['record'])){
            foreach($data['record'] as $r){

                if($r->expire_date !="" ){

                    $eq = $this->common->dateManuplationGet( date('Y-m-d',  strtotime($r->expire_date)), date('Y-m-d'),'equality');

                    if($eq != 1){
                         $diff = $this->common->dateManuplationGet( date('Y-m-d',  strtotime($r->expire_date)),date('Y-m-d'), 'day');

                            if($diff  <= 90){
                                $email['title']= $r->application_number;
                                $email['content'] = "This application has been going to expire @".date('m-d-Y',  strtotime($r->expire_date)).". Please take necessary action.";
                                $view = View('emailtemplate.appexpire',$email);
                                $content =$view->render();
                                $this->common->sendSMTPSystem(config('constants.support.email'), "Application Expire Alert",$content);
                            }
                    }
                }
            }
        }
    }
}
