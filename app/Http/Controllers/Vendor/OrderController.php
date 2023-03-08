<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\Category;
use App\Model\Attribute;
use App\Model\Attributevalue;
use App\Model\Product;
use App\Model\CategoryProduct;
use App\Model\AttributeProduct;
use App\Model\AttributeVariationsValue;
use App\Http\Controllers\CommonController;
use App\Model\OrdersDetails;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use App\Model\TrackOrder;

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

    function orders(){
        $data['record'] = \App\Model\Product::with(['vendor_orders'])->where('created_by',Auth::id())->where('created_by_type','Vendor')->get();

        return view('vendor.orders.list',$data);
    }
    function order_show($id){
        $content['r'] = OrdersDetails::where('id',$id)->first();
        $content['tracking'] = TrackOrder::where('item_id',$content['r']->product_id)->where('type','Product')->where('post_by','Vendor')->get();
        return view('vendor.orders.view',$content);
    }

    function track_order(Request $request,$id){
        $form_data = $request->all();
        $form_data['item_id'] = $id;
        $form_data['post_by'] = 'Vendor';
        $form_data['type'] = 'Product';

        $orderData['status'] = $form_data['track_type'];
        $orderData['comment'] = $form_data['track_message'];
        $data = new TrackOrder($form_data);
        if($data->save($form_data)){
            //$request->session()->flash('success', 'Order updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }

    }
}
