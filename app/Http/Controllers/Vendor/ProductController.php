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
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use App\Model\AttributeSize;

class ProductController extends Controller
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
    public function create(){
        $content['category'] = Category::all();
        $content['attribute'] = Attribute::all();
        $content['tax'] = \App\Model\Tax::where('status',1)->get();
        $content['attribute_size'] = AttributeSize::where('status',1)->get();
        return view('vendor.product.create',$content)->with('call_cat_fn',$this);
    }
    public function show(){
        $content['category'] = Category::all();
        return view('vendor.product.list',$content);
    }
    public function edit($id){
      $content['r']=  Product::with(['category','attribute','attribute_variations'])->where('id',$id)->first();
      $content['category'] = Category::all();
      $content['tax'] = \App\Model\Tax::where('status',1)->get();
      $content['attribute'] = Attribute::all();
      $content['attribute_size'] = AttributeSize::where('status',1)->get();

      return view('vendor.product.edit',$content)->with('call_cat_fn',$this);
    }

    public function store(Request $request){
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
        $form_data['created_by'] = Auth::id();
        $form_data['created_by_type'] = 'Vendor';

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

        if($request->has('readytoship')){
            $form_data['readytoship']=1;
        }else{
            $form_data['readytoship']=0;
        }

        if($request->has('makeanorder')){
            $form_data['makeanorder']=1;
        }else{
            $form_data['makeanorder']=0;
        }


        $data = new Product($form_data);
        if($data->save()){
            //echo "<pre>"; print_r($form_data); die();
            $product_id = $data->id;

            if($request->has('attr_val_variation')){
                $index_attr_main =0;
                foreach($request->input('attr_val_variation') as $key=>$attr_value){
                    $index_attr =0;
                    foreach($attr_value as $keyv=>$vval){
                       $content_variation['product_id'] = $product_id;
                       $content_variation['attribute_id'] =$key;
                       $content_variation['attr_value_name'] = $keyv;
                       $content_variation['attr_value_name_price'] = $vval['color'];
                       $content_variation['attr_value_name_label'] = $vval['color_name'];
                       $content_variation['attr_value_name_picture'] = $vval['color_picture'];
                       $data_variations = new AttributeVariationsValue($content_variation);
                       $data_variations->save();
                    }
                }
            }
            if($request->has('category')){
                foreach($request->input('category') as $cat){
                    $category['product_id'] = $product_id;
                    $category['category_id'] = $cat;
                    $data_cat =  new CategoryProduct($category);
                    $data_cat->save();
                }
            }

            if($request->has('attr')){
                foreach($request->input('attr') as $attr_main_key=>$attr_main_value){
                    $att_main_record['product_id'] = $product_id;;
                    $att_main_record['attribute_id'] = $attr_main_key;
                    if(is_array($attr_main_value)){
                        $att_main_record['attribute_value'] = implode(",", $attr_main_value);
                    }else{
                        $att_main_record['attribute_value'] = $attr_main_value;
                    }

                    $data_main_attr =  new AttributeProduct($att_main_record);
                    $data_main_attr->save();
                }
            }

            if($request->has('file_attr')){
                foreach ($request->file('file_attr') as $key_file=>$file_value)  {
                    $att_main_record['product_id'] = $product_id;
                    $att_main_record['attribute_id'] = $key_file;
                    $fil_upload = $this->common->fileUpload($file_value,  '/uploads/product/',1 );
                    $att_main_record['attribute_value'] = $fil_upload;


                    $data_main_attr =  new AttributeProduct($att_main_record);
                    $data_main_attr->save();

                    /*If variations*/
                    if($request->has('attr_val_variation')){
                       $content_variation_1['product_id'] = $product_id;
                       $content_variation_1['attribute_id'] =$key_file;
                       $content_variation_1['attr_value_name'] = $fil_upload;
                       $data_variations_1 = new AttributeVariationsValue($content_variation_1);
                       $data_variations_1->save();
                    }
                }
            }


            $request->session()->flash('success', 'Product created successfully!');
            return redirect(route('vendor.product.create'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('vendor.product.create'));
        }
    }
    public function update(Request $request,$id){

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
        if($request->file('size_chart')){
            $form_data['size_chart']=  $this->common->fileUpload($request->file('size_chart'),  'uploads/product/' );
        }
        if($request->file('body_picture')){
             $form_data['body_picture']=  $this->common->fileUpload($request->file('body_picture'),  'uploads/product/');
        }
        if($request->has('gallery_picture')){
            $form_data['gallery_picture'] = json_encode($form_data['gallery_picture']);
        }else{
            $form_data['gallery_picture'] =null;
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

        if($request->has('readytoship')){
            $form_data['readytoship']=1;
        }else{
            $form_data['readytoship']=0;
        }

        if($request->has('makeanorder')){
            $form_data['makeanorder']=1;
        }else{
            $form_data['makeanorder']=0;
        }

        $data = Product::find($id);

        if($data->update($form_data)){
            $product_id = $id;
            $this->delete_product_attributes($product_id);


            if($request->has('attr_val_variation')){
                $index_attr_main =0;
                foreach($request->input('attr_val_variation') as $key=>$attr_value){
                    $index_attr =0;
                    foreach($attr_value as $keyv=>$vval){
                       $content_variation['product_id'] = $product_id;
                       $content_variation['attribute_id'] =$key;
                       $content_variation['attr_value_name'] = $keyv;
                       $content_variation['attr_value_name_price'] = $vval['color'];
                       $content_variation['attr_value_name_label'] = $vval['color_name'];
                       $content_variation['attr_value_name_picture'] = $vval['color_picture'];
                       $data_variations = new AttributeVariationsValue($content_variation);
                       $data_variations->save();
                    }
                }
            }
            if($request->has('category')){
                foreach($request->input('category') as $cat){
                    $category['product_id'] = $product_id;
                    $category['category_id'] = $cat;
                    $data_cat =  new CategoryProduct($category);
                    $data_cat->save();
                }
            }

            if($request->has('attr')){
                foreach($request->input('attr') as $attr_main_key=>$attr_main_value){
                    $att_main_record['product_id'] = $product_id;;
                    $att_main_record['attribute_id'] = $attr_main_key;
                    if(is_array($attr_main_value)){
                        $att_main_record['attribute_value'] = implode(",", $attr_main_value);
                    }else{
                        $att_main_record['attribute_value'] = $attr_main_value;
                    }

                    $data_main_attr =  new AttributeProduct($att_main_record);
                    $data_main_attr->save();
                }
            }

            if($request->has('file_attr')){
                foreach ($request->file('file_attr') as $key_file=>$file_value)  {
                    $att_main_record['product_id'] = $product_id;
                    $att_main_record['attribute_id'] = $key_file;
                    $att_main_record['attribute_value'] = $this->common->fileUpload($file_value,  'public/uploads/product/',1 );
                    $data_main_attr =  new AttributeProduct($att_main_record);
                    $data_main_attr->save();

                    /*If variations*/
                    if($request->has('attr_val_variation')){
                       $content_variation_1['product_id'] = $product_id;
                       $content_variation_1['attribute_id'] =$key_file;
                       $content_variation_1['attr_value_name'] = $att_main_record['attribute_value'];
                       $data_variations_1 = new AttributeVariationsValue($content_variation_1);
                       $data_variations_1->save();
                    }
                }
            }

            $request->session()->flash('success', 'Product updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function showList(){
        $record = Product::query();
        if(Input::get('filterextend')!==false){
            if(Input::get('filterextend')!=""){
                $record->where('status','=',Input::get('filterextend'));
            }
        }
        $record = $record->with('category')->where('created_by',Auth::id());
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
                $actions = '<a href="'. route('vendor.product.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('vendor.product.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','picture','stock','price','status'])
            ->make(true);
    }

    function delete($id){
        $this->delete_product_attributes($id);
        echo Product::where("id",$id)->delete();
        die();
    }

    function child_cat($id){
        return Category::where('parent',$id)->get();
    }


    function attribute_load(Request $request){
        $content['attr'] = Attribute::where('id',$request->input('attr'))->first();
        $content['attr_value'] = Attributevalue::where('attribute_id',$request->input('attr'))->get();
        if($request->input('variation') =="1"){
           return view('ajax.product.attribute_variation',$content);
        }else{
           return view('ajax.product.attribute',$content);
        }
    }

    function attribute_load_exist(Request $request){
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
    function attribute_value_call_exist($product_id,$attr_id,$value){
        $record =  AttributeVariationsValue::where('product_id',$product_id)->where('attribute_id',$attr_id)->where('attr_value_name',$value)->first();
        if(!empty($record)){
            return $record->attr_value_name_price;
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
