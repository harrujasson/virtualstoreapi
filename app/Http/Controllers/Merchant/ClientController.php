<?php

namespace App\Http\Controllers\Merchant;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\User;
use App\Models\Invite;
use Auth;


class ClientController extends Controller
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

    public function show(){
        return view('merchant.client.list');
    }
    public function view($id){
      $content['r']=  User::where('id',$id)->where('merchant_id',Auth::id())->first();      
      return view('merchant.client.view',$content);  
    }
    
    function showList(){        
        $record = User::where('merchant_id',Auth::id())->where('role',3);    
          
        return Datatables::of($record) 

            ->editColumn('status',function($record) {
                if($record->status == "1"){
                 return "<span class='badge badge-soft-success'>Active</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>De-Active</span>";
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('merchant.client.view',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a>';
                return $actions;
            })
            ->rawColumns(['actions','status'])
            ->make(true);            
    }   
    
    function delete($id){
        echo client::where('created_by',Auth::id())->where("id",$id)->delete();  
        die();
    }

    function message_errors(){
        return [
            'name.required'=>'client Name Required',
            'name.regular_price'=>'Regular Price Required'
        ];
    }

    
}
