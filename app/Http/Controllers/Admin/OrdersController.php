<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\Orders;
use App\Models\OrdersDetails;
use App\Models\TrackOrder;


class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $title='Orders';
    public function __construct(){
        $this->middleware('auth');
        $this->common=new CommonController();
    }
    public function show(Request $request){
        $data['title'] = $this->title; 
        $data['payment_status']='';
        if($request->has('payment_status') && $request->get('payment_status') !=""){
            $data['payment_status'] =$request->get('payment_status');
        }
        return view('admin.orders.list',$data);
    }
    public function view($id=0){
      $content['title'] = $this->title; 
      $content['r']= Orders::with(['order_details','shipping','user'])->where('id',$id)->first();
      $content['tracking'] = TrackOrder::where('item_id',$id)->where('type','Order')->where('post_by','Admin')->get();

      return view('admin.orders.view',$content);
    }

    public function update(Request $request,$id){
        
        $form_data = $request->all();
        $data = Orders::find($id);
        if($data->update($form_data)){
            $request->session()->flash('success', 'Order updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function track_order(Request $request,$id){
        $form_data = $request->all();
        
        

        
        $form_data['item_id'] = $id;
        $form_data['post_by'] = 'Admin';
        $form_data['type'] = 'Order';

        $orderData['status'] = $form_data['track_type'];
        $orderData['comment'] = $form_data['track_message'];
        $dataOrderObj = Orders::find($id);
        $dataOrderObj->update($orderData);
        //echo "<pre>"; print_r($form_data); die();
        $data = new TrackOrder($form_data);
        if($data->save($form_data)){
            if($form_data['track_type'] == "Cancelled"){
                $user_email = \App\User::where('id',$dataOrderObj->user_id)->pluck('email')->first();
                $shop = New ShopController();
                $shop->send_invoice_email($id,$user_email,'Cacnel Invoice Order - #');
            }
            //$request->session()->flash('success', 'Order updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }

    }

    function showList(){
        $record = Orders::query();
        return Datatables::of($record)
            ->editColumn('total',function($record){
                return currency().number_format($record->total,2);
            })
            ->editColumn('payment_status',function($record){
                if($record->payment_status =="non-paid"){
                    return "<span class='badge badge-pill badge-soft-danger font-size-12'>Pending</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-success font-size-12'>Paid</span>";
                }
            })

            ->editColumn('date',function($record){
                return date('M-d-y H:i a',strtotime($record->created_at));
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.orders.show_full',$record->id).'" class="on-default"><i class="fa fa-search-plus"></i></a> &nbsp;';

                return $actions;
            })
            ->rawColumns(['actions','payment_status','total'])
            ->make(true);
    }

    function delete($id){

        echo Attribute::where("id",$id)->delete();
        $this->delete_attribute_value($id);
        die();
    }

    function order_track(Request $request){
        $tracking  = TrackOrder::where('type','Product')->where('post_by','Vendor')->where('item_id',$request->input('id'))->get();
        $content['tracking'] = $tracking;
        return view('ajax.orders.trackorder',$content);
    }

    function information(Request $request){
        $var['var'] ='';
        $attach['attach']='';
        $record = OrdersDetails::where('id',$request->input('id'))->first();
        if(!empty($record->product_attachments)){
            $attach['attach'] = json_decode($record->product_attachments);
        }

        if(!empty($record->product_variations)){
            $var['var'] = json_decode($record->product_variations);
            $var['full'] = json_decode($record->product_variations);
            $var['total_price'] = $var['var']->total_price;
            unset($var['var']->total_price);
        }

        if(!empty($record)){
            if($request->input('type') == "attachment"){
                return view('ajax.orders.attachments',$attach);
            }elseif($request->input('type') == "variations"){
                
                
                //echo "<pre>"; print_r($var); die();
                return view('ajax.orders.variations',$var)->with('callback',$this);
            }
        }

    }

    function get_attribute_name($id,$type='label'){
        return \App\Model\Attribute::where('id',$id)->pluck($type)->first();
    }

    function export(Request $request){
        $query = Orders::query();
        if($request->has('start_date') && $request->get('start_date') !=""){
           
            $query->where('');
        }
        if($request->has('end_date') && $request->get('end_date') !=""){
            
        }
        if($request->has('payment_status') && $request->get('payment_status') !=""){
            
            $query->where('payment_status',$request->get('payment_status'));
        }

        $result = $query->get();
        if(!empty($result)){
            $cnt=0;
            foreach($result as $r){
                $rows[$cnt][] = userinfo($r->user_id,'name').' '.userinfo($r->user_id,'last_name');
                $rows[$cnt][] = userinfo($r->user_id,'email');
                $rows[$cnt][] = $r->id;
                $rows[$cnt][] = $r->tax;
                $rows[$cnt][] = $r->deliver_charge;
                $rows[$cnt][] = $r->total;
                $rows[$cnt][] = $r->payment_status;
                $rows[$cnt][] = $r->status;
                $rows[$cnt][] = $r->transaction_id;
                $rows[$cnt][] = $r->payment_type;
                $rows[$cnt][] = $r->created_at;
                $cnt++;
            }
            $columnNames = [
                'Customer',
                'Customer Email',
                'OrderID',
                'Tax',
                'Deliver Charge',
                'Total',
                'Payment Status',
                'Status',
                'Transaction ID',
                'Payment Mode',
                'Order Date'
            ];
        }

        return $this->common->getCsv($columnNames, $rows,'orderReport.csv');
       

    }
}
