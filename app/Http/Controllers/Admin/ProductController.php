<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Http\Controllers\CommonController;
use Barryvdh\DomPDF\Facade as PDF;
use Input;
use Storage;
use File;

use App\Models\Attribute;
use App\Models\Review;
use App\Models\Attributevalue;

use App\Models\AttributeProduct;
use App\Models\AttributeVariationsValue;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $mid;
    public $domain;
    protected $title='Product';
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
    public function create(){
        $content['title'] = $this->title; 
        $content['category_individual'] = Category::where('mid',$this->mid)->where('type','Individual')->get();
        $content['category_main'] = Category::where('mid',$this->mid)->where('type','Main')->where('status',1)->get();
        $content['tax'] = \App\Models\Tax::where('mid',$this->mid)->where('status',1)->get();
        $content['attribute'] = Attribute::all();
        return view('admin.product.create',$content)->with('call_cat_fn',$this);
    }
    public function show(){
        $content['title'] = $this->title; 
        $content['category'] = Category::where('mid',$this->mid)->get();
        return view('admin.product.list',$content);
    }
    public function edit($domain,$id){
      $content['title'] = $this->title; 
      $content['r']=  Product::with(['category'])->where('mid',$this->mid)->where('id',$id)->first();
      $content['category_individual'] = Category::where('mid',$this->mid)->where('type','Individual')->get();
      $content['category_main'] = Category::where('mid',$this->mid)->where('type','Main')->where('status',1)->get();
      $content['tax'] = \App\Models\Tax::where('mid',$this->mid)->where('status',1)->get();
      $content['review'] = \App\Models\Review::where('product_id',$id)->orderBy('id', 'DESC')->get();
      return view('admin.product.edit',$content)->with('call_cat_fn',$this);
    }

    public function publish($domain,Request $request,$id,$approve){        
        $data = Review::find($id);
        $data->approve = $approve;
        if($data->save()){
            $request->session()->flash('success', 'Review updated successfully!');
            return 1;
        }else{
            $request->session()->flash('error', 'Error!');
          return 0;
        }
    }

    public function store($domain,Request $request){
        $variation = array();
        $main_variation = array();
        $request->validate([
            'title' => 'required'
        ]);
        $form_data = $request->all();
        unset($form_data['category']);

        if($request->file('feature_picture')){
             $form_data['feature_picture']=  $this->common->fileUpload($request->file('feature_picture'),  'uploads/product/' );
        }
        if($request->file('size_chart')){
            $form_data['size_chart']=  $this->common->fileUpload($request->file('size_chart'),  'uploads/product/' );
        }
        if($request->file('body_picture')){
             $form_data['body_picture']=  $this->common->fileUpload($request->file('body_picture'),  'uploads/product/');
        }
        if($request->has('gallery_picture')){
            $form_data['gallery_picture'] = json_encode($form_data['gallery_picture']);
        }

        if($request->has('seo')){
            $form_data['seo_info'] = json_encode($request->input('seo'));
        }

        if($request->has('feature')){
            $form_data['feature']=1;
        }else{
            $form_data['feature']=0;
        }
        if($request->has('new_arrival')){
            $form_data['new_arrival'] =1;
        }else{
            $form_data['new_arrival'] =0;
        }
        $form_data['status'] = 1;
        $form_data['created_by'] = Auth::id();
        $form_data['created_by_type'] = 'Admin';
        $form_data['mid'] =Auth::user()->mid;
        $data = new Product($form_data);
        if($data->save()){
            //echo "<pre>"; print_r($form_data); die();
            $product_id = $data->id;
            
            if($request->has('category')){
                foreach($request->input('category') as $cat){
                    $category['product_id'] = $product_id;
                    $category['category_id'] = $cat;
                    $data_cat =  new CategoryProduct($category);
                    $data_cat->save();
                }
            }

            $request->session()->flash('success', 'Product created successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    public function update($domain,Request $request,$id){
        
        $variation = array();
        $main_variation = array();

        $request->validate([
            'title' => 'required'
        ]);

        $form_data = $request->all();

        unset($form_data['category']);
        unset($form_data['attr_val_variation']);
        unset($form_data['attr']);
        unset($form_data['file_attr']);

        if($request->file('feature_picture')){
             $form_data['feature_picture']=  $this->common->fileUpload($request->file('feature_picture'),  'uploads/product/' );
        }
        if($request->file('body_picture')){
             $form_data['body_picture']=  $this->common->fileUpload($request->file('body_picture'),  'uploads/product/');
        }
        if($request->has('gallery_picture')){
            $form_data['gallery_picture'] = json_encode($form_data['gallery_picture']);
        }else{
            $form_data['gallery_picture'] =null;
        }

        if($request->file('size_chart')){
            $form_data['size_chart']=  $this->common->fileUpload($request->file('size_chart'),  'uploads/product/' );
        }

        if($request->has('delete_body')){
            $form_data['body_picture']='';
        }
        if($request->has('new_arrival')){
            $form_data['new_arrival'] =1;
        }else{
            $form_data['new_arrival'] =0;
        }
        if($request->has('seo')){
            $form_data['seo_info'] = json_encode($request->input('seo'));
        }

        if($request->has('feature')){
            $form_data['feature']=1;
        }else{
            $form_data['feature']=0;
        }


        $data = Product::find($id);

        if($data->update($form_data)){
            $product_id = $id;
            if($request->has('category')){
                CategoryProduct::where('product_id',$product_id)->delete();
                foreach($request->input('category') as $cat){
                    $category['product_id'] = $product_id;
                    $category['category_id'] = $cat;
                    $data_cat =  new CategoryProduct($category);
                    $data_cat->save();
                }
            }
            $request->session()->flash('success', 'Product updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }


     
    }

    function showList($domain,Request $request){
        $record = Product::where('mid',Auth::user()->mid);
        if($request->get('filterextend')!==false){
            if($request->get('filterextend')!=""){
                $record->where('status','=',$request->get('filterextend'));
            }
        }
        
        $record = $record->with('category');
        return Datatables::of($record)
           ->editColumn('picture',function($record) {
               if($record->feature_picture!=""){
                   return "<img class='thumb-sm rounded-circle me-2' src='". asset("uploads/product/".$record->feature_picture)."'>";
               }
            })
            ->editColumn('stock',function($record) {
                if($record->stock){
                    return "<span class='badge  badge-soft-success'>In-Stock</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>Out-Stock</span>";
                }
            })
            ->editColumn('status',function($record) {
                if($record->status==0){
                    return '<span class="badge badge-soft-danger" key="t-new">De-Active</span>';
                }else{
                    return '<span class="badge badge-soft-success" key="t-new">Active</span>';
                }
            })
            ->editColumn('category',function($record){
                return $this->getCateName($record->category);
            })
            ->editColumn('price',function($record) {
                $price_arr[] = currency().$record->regular_price;
                $price_arr[] = currency().$record->sale_price;
                return implode(" - ", $price_arr);
            })
            ->editColumn('publish_date',function($record) {
                return date('m-d-Y', strtotime($record->created_at));
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.product.editForm',[get_route_url(),$record->id]).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.product.deleteAjax',[get_route_url(),$record->id]).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','picture','stock','price','status'])
            ->make(true);
    }

    function delete($domain,$id){
        echo Product::where("id",$id)->delete();
        die();
    }

    function child_cat($id){
        return Category::where('parent',$id)->get();
    }
    function child_parent_cat($id=0){
        return Category::where('type','Parent')->where('main',$id)->get();
    }
    function child_normal_cat($main_id=0,$parent_id=0){
        return Category::where('type','Normal')->where('main',$main_id)->where('parent',$parent_id)->get();
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

    function attribute_load($domain,Request $request){
        $content['attr'] = Attribute::where('id',$request->input('attr'))->first();
        $content['attr_value'] = Attributevalue::where('attribute_id',$request->input('attr'))->get();
        if($request->input('variation') =="1"){
            
           return view('ajax.product.attribute_variation',$content);
        }else{
           return view('ajax.product.attribute',$content);
        }
    }
    function attribute_load_exist($domain,Request $request){
        $ids  = AttributeProduct::where('product_id',$request->input('product_id'))->pluck('attribute_id')->all();
        if(!empty($ids)){
            $content['attr_all'] = Attribute::whereIn('id',$ids)->get();
            $content['product_id'] = $request->input('product_id');
            if($request->input('variation') =="1"){
               return view('ajax.product.attribute_variation_edit',$content)->with("attr_call_edit",$this);
            }else{
               return view('ajax.product.attribute_edit',$content)->with("attr_call_edit",$this);
            }
        }
    }
    function attribute_value_exist($attr_id=0){
       return Attributevalue::where('attribute_id',$attr_id)->get();
    }
    function attribute_value_call_exist($product_id,$attr_id,$value,$fld='attr_value_name_price'){
        $record =  AttributeVariationsValue::where('product_id',$product_id)->where('attribute_id',$attr_id)->where('attr_value_name',$value)->first();
        if(!empty($record)){
            return $record->$fld;
        }
    }
    function attribute_value_exist_fill($product_id,$attr_id){
        $record = AttributeProduct::where('product_id',$product_id)->where('attribute_id',$attr_id)->first();
        if(!empty($record)){
            return $record->attribute_value;
        }
    }

    function delete_product_attributes($id){
        CategoryProduct::where('product_id',$id)->delete();
        AttributeVariationsValue::where('product_id',$id)->delete();
        AttributeProduct::where('product_id',$id)->delete();
    }
}
