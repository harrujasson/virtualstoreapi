<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $title='Orders';
    protected $mid;
    public $domain;
    public function __construct(Request $request){
        $this->middleware('auth');
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
     * @return \Illuminate\Http\Response
     */
    function index(){
        return view('customer.dashboard');
    }
    function myprofile(){
        $content['r'] = User::where('id',Auth::id())->first();
        return view('customer.profile',$content);
    }
    function myprofile_save($domain,Request $request){

        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.Auth::id(),
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',0 );
        }
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        $data =  User::find(Auth::id());
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    function orders(){
        $data['title'] = $this->title; 
        return view('customer.orders.list',$data);
    }
    function order_show($domain,$id){
        $content['title'] = $this->title; 
        $content['r'] = \App\Models\Orders::with(['order_details','shipping','user'])->where('id',$id)->where('user_id',Auth::id())->first();
        $content['tracking'] = \App\Models\TrackOrder::where('item_id',$id)->where('type','Order')->where('post_by','Admin')->get();
        return view('customer.orders.view',$content);
    }
    function showList(){
        $record = \App\Models\Orders::where('user_id',Auth::id());
        return Datatables::of($record)
           ->editColumn('date',function($record) {
               if($record->created_at!='0000-00-00'){
                  return date('d-M-y H:i a',strtotime($record->created_at));
               }
            })
            ->editColumn('total',function($record) {
                   return currency().' '. number_format( $record->total,2 );
             })
            
            ->editColumn('payment_status',function($record) {
                if($record->payment_status =="non-paid"){
                    return "<span class='badge badge-pill badge-soft-danger font-size-12'>Pending</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-success font-size-12'>Paid</span>";
                }
            })
            ->editColumn('status',function($record) {
                if($record->cancel =="1"){
                    return "<span class='badge badge-pill badge-soft-danger font-size-12'>Cacnelled</span>";
                }else{

                    if($record->status!=''){
                        return "<span class='badge badge-pill badge-soft-success font-size-12'>".$record->status."</span>";
                    }else{
                        return  "<span class='badge badge-pill badge-soft-warning font-size-12'>Under Process</span>";
                    }
                }
                
             })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('customer.order_show',[get_route_url(),$record->id]).'" class="on-default"><i class="fas fa-search-plus"></i></a>';
                return $actions;
            })
            ->rawColumns(['actions','payment_status','status','total'])
            ->make(true);
    }
    /*Wishlist*/
    function add_wishlist($domain,$slug=''){
        $product_info = \App\Models\Product::where('slug',$slug)->first();
        if(!empty($product_info)){
            $wishlist['user_id'] = Auth::id();
            $wishlist['product_id'] = $product_info->id;
            $data = new Wishlist($wishlist);
            if($data->save()){
                Session::flash('success', 'Product added in wishlist successfully!');
                return redirect()->back();
            }else{
                Session::flash('error', 'Error!');
                return redirect()->back();
            }
        }
    }
    function add_wishlist_ajax($domain,$slug=''){
        $product_info = \App\Models\Product::where('slug',$slug)->first();
        if(!empty($product_info)){
            $wishlist['user_id'] = Auth::id();
            $wishlist['product_id'] = $product_info->id;
            $data = new Wishlist($wishlist);
            if($data->save()){
                $status['status'] = 1;
                $status['total'] = total_wishlist();
                return json_encode($status);
            }else{
                $status['status'] = 0;
                return json_encode($status);
            }
        }
    }


    function wishlist(){
        $data['title'] = 'My Wishlist'; 
        $data['record'] =   \App\Models\Wishlist::with('products')->where('user_id',Auth::id())
                ->groupBy('product_id')
                ->select('product_id', DB::raw('count(*) as total'))
                ->get();
        
        return view('customer.wishlist',$data);
    }
    function wishlist_remove($domain,$id=0){
         $delete =\App\Models\Wishlist::where('user_id',Auth::id())->where('product_id',$id)->delete();
         if($delete){
            Session::flash('success', 'Product has been removed from your wishlist successfully!');
            return redirect()->back();
        }else{
            Session::flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function cancel_order($domain,Request $request, $id){
        $form_data = $request->all();
        $form_data['cancel'] = 1;
        $data = \App\Models\Orders::find($id);
        if($data->update($form_data)){
            $request->session()->flash('success', 'Order has been cacnelled successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }


}
