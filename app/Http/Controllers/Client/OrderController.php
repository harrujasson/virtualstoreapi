<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\Order;
use Auth;


class OrderController extends Controller
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
        return view('client.order.list');
    }
    function showList(){        
        $record = Order::with(['user','package'])->where('user_id',Auth::id());    
          
        return Datatables::of($record) 

            ->editColumn('payment_status',function($record) {
                if($record->payment_status == "Paid"){
                 return "<span class='badge badge-soft-success'>Paid</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>Pending</span>";
                }
            })
            ->editColumn('status',function($record) {
                if($record->status == "1"){
                 return "<span class='badge badge-soft-success'>Active</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>De-Active</span>";
                }
            })
            ->editColumn('amount',function($record) {
                return currency().number_format($record->amount,2);
            })
            
            ->editColumn('package',function($record) {
                if(!empty($record->package)){
                    $status ='';
                    if($record->package->status){
                        $status = " <span class='badge badge-soft-success'>Active</span>";
                    }else{
                        $status = " <span class='badge badge-soft-danger'>De-Active</span>";
                    }
                    return $record->package->name .$status;
                }
            })
            ->editColumn('user',function($record) {
                if(!empty($record->user)){
                    return $record->user->name.' '.$record->user->last_name;
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('client.orders.view',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a>';                
                return $actions;
            })
            ->rawColumns(['actions','status','amount','package','payment_status'])
            ->make(true);            
    }
    function view($id=''){
        $content['r'] = Order::with(['user','package','merchant'])->where('id',$id)->first();;           
        return view('client.order.view',$content);
    }
}
