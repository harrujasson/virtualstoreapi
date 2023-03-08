<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\User;
use App\Model\VendorBiz;
use App\Http\Controllers\CommonController;
use App\RoleAssign;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Model\Product;
use App\Model\Category;
use Illuminate\Support\Facades\Input;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct(){
        $this->middleware('auth');
        $this->common=new CommonController();
    }

    public function show(){
        return view('admin.vendor.list');
    }
    function view($id=''){
        $content['r']=  User::find($id);
        $content['id'] = $id;
        $content['vendor'] = VendorBiz::where('user_id',$id)->first();

        return view('admin.vendor.view',$content);
    }
    function showList(){
        $record = User::where('role',3);
        if(Input::get('filterextend')!==false){
            if(Input::get('filterextend')!=""){
                $record->where('status','=',Input::get('filterextend'));
            }
        }
        return Datatables::of($record)
           ->editColumn('status',function($record) {
            if($record->status==0){
                    return '<span class="badge rounded-pill bg-danger" key="t-new">De-Active</span>';
            }else{
                return '<span class="badge rounded-pill bg-success" key="t-new">Active</span>';
            }

            })
            ->editColumn('created_at',function($record) {
                return date("Y-m-d", strtotime($record->created_at));
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.vendors.view',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status'])
            ->make(true);
    }


    function profile_update(Request $request,$id){

        $request->validate([
            'name' => 'bail|required',
            'email' => 'required|string|email|unique:users,email,'.$id,
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile',0 );
        }
        if($request->input('new_password')!=""){
            $form_data['password'] = bcrypt($request->input('new_password'));
        }
        $data =  User::find($id);
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function vendor_details_save(Request $request,$id){

        $form_data = $request->all();

        unset($form_data['_token']);

        if($request->file('company_picture')){
            $form_data['company_picture']=  $this->common->fileUpload($request->file('company_picture'),  './uploads/profile',0 );
        }
        if($request->file('gst_certificate_copy')){
            $form_data['gst_certificate_copy']=  $this->common->fileUpload($request->file('gst_certificate_copy'),  './uploads/profile',0 );
        }
        if($request->file('pan_copy')){
            $form_data['pan_copy']=  $this->common->fileUpload($request->file('pan_copy'),  './uploads/profile',0 );
        }
        if($request->file('copy_passbook')){
            $form_data['copy_passbook']=  $this->common->fileUpload($request->file('copy_passbook'),  './uploads/profile',0 );
        }
        $data =  VendorBiz::where("user_id",$id);
        if($data->update($form_data)){
            $request->session()->flash('success', 'Profile has been updated successfully!');
            if($request->has('account_number')){
                return redirect(route('admin.vendors.view',$id)."#account");
            }else{
                return redirect(route('admin.vendors.view',$id)."#business");
            }

        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.vendors.view',$id)."#business");
        }
    }

    function showListProduct($id){
        $record = Product::query();
        if(Input::get('filterextend')!==false){
            if(Input::get('filterextend')!=""){
                $record->where('status','=',Input::get('filterextend'));
            }
        }
        $record->with('category')->where('created_by',$id);
        return Datatables::of($record)
           ->editColumn('picture',function($record) {
               if($record->feature_picture!=""){
                   return "<img class='rounded-circle avatar-sm' width='50' src='". asset("uploads/product/".$record->feature_picture)."'>";
               }
            })
            ->editColumn('stock',function($record) {
                if($record->stock){
                    return "<span class='badge badge-pill badge-soft-success font-size-15'>In-Stock</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-danger font-size-15'>Out-Stock</span>";
                }
            })
            ->editColumn('status',function($record) {
                if($record->status){
                    return "<span class='badge badge-pill badge-soft-success font-size-15'>Published</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-danger font-size-15'>Approval Pending</span>";
                }
            })
            ->editColumn('category',function($record){
                return $this->getCateName($record->category);
            })
            ->editColumn('price',function($record) {

                return currency().$record->vendor_price;;
            })
            ->editColumn('publish_date',function($record) {
                return date('m-d-Y', strtotime($record->created_at));
            })
            ->addColumn('actions',function($record) {
                $actions = '<a target="_blank" href="'. route('admin.product.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','picture','stock','price','status'])
            ->make(true);
    }
    function getCateName($catArr){
        if(!empty($catArr)){
            $cat_info = array();
            foreach($catArr as $cat){
                $cat_info[] = Category::where('id',$cat->category_id)->pluck('name')->first();
            }
            return implode(", ", $cat_info);
        }
    }
}
