<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\Shipping;
use App\Models\Review;
use PDF;
use App;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Input;
use Cart;

use App\Models\Category;


class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $page=9;
    protected $mid;
    public $domain;
    public function __construct(Request $request){
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function shop(Request $request){

        //$this->send_invoice_email('9');die();
        $content['search'] ='';
        $content['price_start'] ='';
        $content['price_end'] ='';
        $price = 0;
        $query = Product::where('status',1)->where('mid',$this->mid);
        
        if($request->has('search') && $request->get('search')!="") {
            $content['search'] =$request->get('search');
            $query->where('title', 'like', '%'.$content['search'].'%');
        }
        $sortby = $request->has('sortby') ? $request->get('sortby') : null;
        if($sortby!=null){
            switch($sortby){
                Case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                Case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                Case 'price_asc':
                    $query->orderBy('regular_price', 'asc');
                    break;
                Case 'price_desc':
                    $query->orderBy('regular_price', 'desc');
                    break;
                Case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }else{
            $query->orderBy('created_at', 'desc');
        }
        $content['sort'] = $sortby;
        $content['products'] = $query->paginate($this->page);
      
        $content['category'] = sidebar_category();
        return view('front.product.shop',$content);
    }

    function category_list(Request $request, $slug =""){
         if($slug==''){
            return redirect(route('shop',[get_route_url()]));
        }

        $content['search'] ='';
        $content['price_start'] ='';
        $content['price_end'] ='';
        $content['size_options'] =array();
        $content['color'] ='';
        $price = 0;


        $catInfo = App\Model\Category::where('slug',$slug)->where('mid',$this->mid)->first();
        $catname = $catInfo->name;

          

        $cat_id = App\Model\Category::where('slug',$slug)->where('mid',$this->mid)->pluck('id')->first();        
        $parent_cat_id = App\Model\Category::where('slug',$slug)->where('mid',$this->mid)->pluck('parent')->first();
        if($cat_id){

        $query = Product::whereHas('category',function($query) use ($cat_id){
                $query->where('category_id',$cat_id);
        })->where('mid',$this->mid)->with('category')->where('status',1);


        if($request->has('search') && $request->get('search')!="") {
            $content['search'] =$request->get('search');
            $query->where('title', 'like', '%'.$content['search'].'%');
        }
        if($request->has('price_start') && $request->get('price_start')!="") {
            $content['price_start'] =$request->get('price_start');
            $price =1;
        }
        if($request->has('price_end') && $request->get('price_end')!="") {
            $content['price_end'] =$request->get('price_end');
            $price=1;
        }
        if($price){
            $query->whereBetween('regular_price',[$request->get('price_start'),$request->get('price_end')]);
        }

        if($request->has('size_options') && $request->get('size_options')!="") {
            $content['size_options'] =$request->get('size_options');

            $productid = array();
            $variations =   AttributeSizeOption::whereIn('name',$request->get('size_options'))->get();

            if(!empty($variations)){
                foreach($variations as $var){
                    $productid[] = $var->attribute_size_id;
                }
                if(!empty($productid)){
                    $query->whereIn('id',$productid);
                }
            }

        }
        if($request->has('color') && $request->get('color')!="") {
            $content['color'] =$request->get('color');
            $productid = array();
            $variations =   AttributeProduct::where('attribute_value',$request->get('color'))->get();

            if(!empty($variations)){
                foreach($variations as $var){
                    $productid[] = $var->product_id;
                }
                if(!empty($productid)){
                    $query->where(function($q) use($productid){
                        $q->whereIn('id',$productid);
                    });
                }
            }
        }



            /*Sort check*/
            $sortby = Input::has('sortby') ? Input::get('sortby') : null;
            if($sortby!=null){
                switch($sortby){
                    Case 'title_asc':
                        $query->orderBy('title', 'asc');
                        break;
                    Case 'title_desc':
                        $query->orderBy('title', 'desc');
                        break;
                    Case 'price_asc':
                        $query->orderBy('regular_price', 'asc');
                        break;
                    Case 'price_desc':
                        $query->orderBy('regular_price', 'desc');
                        break;
                    Case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            }else{
                $query->orderBy('created_at', 'desc');
            }

            $content['sort'] = $sortby;
            $content['products'] = $query->paginate($this->page);
            $content['catname'] = $catname;
            $content['cat_id'] = $cat_id;
            $content['parent_cat_id'] =$parent_cat_id;
            $content['category'] = sidebar_category();
            $content['attribute_size'] = AttributeSize::with('options_value')->where('status',1)->get();
            $content['attribute'] = Attribute::with('attribute_value')->where('slug','color')->first();
            $content['catinfo'] =$catInfo;
            //echo "<pre>"; print_r($content['catinfo']); die();

            return view('front.product.shop_cat',$content);
        }else{
            Session::flash('error', 'For the time this category not available. Please try with other category');
            return redirect(route('shop',get_route_url()));
        }


    }

    function details($request,$slug =''){
        if($slug==''){
            return redirect()->back();
        }
      
        
        $content['r'] = Product::where('slug',$slug)->where('mid',$this->mid)->first();               
        $content['related']  ='';
        //echo "<pre>"; print_r($content['r']); die();

        if(!empty($content['r'])){
            $cat = App\Models\CategoryProduct::where('product_id',$content['r']->id)->first();

            if($cat){
                $cat_id = $cat->category_id;

                $content['related'] = Product::whereHas('category',function($query) use ($cat_id){
                        $query->where('category_id',$cat_id);
                })
                ->where('mid',$this->mid)
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            }
        }
       
        $content['review'] = Review::where('approve',1)->where('product_id',$content['r']->id)->orderBy('id','desc')->paginate(3);
        
        //echo "<pre>"; print_r($content['review']); die();

        $content['title'] =$content['r']->title;
        $description = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($content['r']->short_description)));

        $content['description'] =substr($description,0,300);
        $content['keyword']='';
        //$content['cat_info'] = array_to_string(get_product_category($content['r']->id));
        $content['cat_info'] = '';
        $content['pic_cnt']='';
        return view('front.product.detail',$content)->with('call_back_fun',$this);

    }
    public function review(Request $request){
        $form_data = $request->all(); 
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  'uploads/reviews/' );
        }   
        if($request->has('product_slug')){
            $form_data['product_id'] = productinfo_by_slug($request->input('product_slug'),'id');
        }

        if($form_data['rating'] < 3){
            $form_data['approve'] = 0;
        }else{
            $form_data['approve']  = 1;
        }

        $data = new Review($form_data);
        if($data->save()){           
            $status['status'] = 'success';
            return response()->json($status);
        }else{
            $status['status'] = 'error';            
            return response()->json($status);           
        }
        
        
        
    }
    function get_attribute_name($id,$type='label'){
        return \App\Model\Attribute::where('id',$id)->pluck($type)->first();
    }
    function get_attribute_variations_value_price($product_id,$attribute_id){
        return \App\Model\AttributeVariationsValue::where('product_id',$product_id)
                ->where('attribute_id',$attribute_id)
                ->where('attr_value_name_price','!=','')
                ->get();
    }
    function get_attribute_variations_value_price_single($product_id,$attribute_id,$attr_value_name,$field='attr_value_name_price'){
        return \App\Model\AttributeVariationsValue::where('product_id',$product_id)
                ->where('attribute_id',$attribute_id)
                ->where('attr_value_name',$attr_value_name)
                ->pluck($field)
                ->first();
    }
    /*Load product popup ajax*/
    function load_product(Request $request){
        if($request->has('slug')){
            $content['r'] = Product::with(['attribute'])
                ->where('slug',$request->input('slug'))->where('mid',$this->mid)->first();
            return view('ajax.product_popup_detail',$content)->with('call_back_fun',$this);
        }
    }
    function load_product_save(Request $request){
        if(!$request->has('slug')){
            echo "0";
            die();
        }
        if($request->input('slug') == ""){
            echo "0";
            die();
        }
        $slug = $request->input('slug');
        $product=  Product::where('slug',$slug)->where('mid',$this->mid)->first();

        if(!empty($product)){
            $status = $this->cart_add($product,$request);
            //$request->session()->flash('success', 'Product added in cart successfully!');
            echo "1";
            //die();
        }else{
            echo '0';
            die();
        }
    }
    function load_product_wishlist(Request $request){
       if(!$request->has('slug')){
            echo "0";
            die();
        }
        if($request->input('slug') == ""){
            echo "0";
            die();
        }
        if(Auth::check()){
           $customer = new HomeController();
           if($customer->add_wishlist_ajax($request->input('slug'))){
               echo "1";
           }else{
               echo "0";
           }
        }else{
            echo "2";
            die();
        }
    }
    /*End Load product popup ajax*/

    function cart_add($product,$request){
       
        $variations['price']=0;
        $variations['data']='';
        $product_final_price=0;
        $tax=0;
        $tax_rate=0;
        $qty = $request->input('qty');

        if($product->sale_price!=0){
            $product_final_price = $product->sale_price + $variations['price'];
            //echo "After slae ".$product_final_price . "  ".$variations['price'];
        }else{
            $product_final_price = $product->regular_price + $variations['price'];
            //echo "After Ragular ".$product_final_price;
        }
        if(!empty($product->tax_id)){
            $tax = $this->tax_calculate($product->tax_id,$product_final_price);
            $tax_rate = $this->tax_rate($product->tax_id);
            $variations['tax'] = $tax;
            $variations['tax_rate'] = $tax_rate;
        }



        $data = ['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product_final_price, 'tax'=>$tax, 'tax_rate'=>$tax_rate, 'options' => $variations];
        //echo "<pre>"; print_r($variations); print_r($data); echo $product_final_price; die();
        $status =  Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product_final_price, 'tax'=>$tax, 'tax_rate'=>$tax_rate, 'options' => $variations]);
        return $status;

    }
    function cart_add_details($domain,Request $request, $slug =''){  
        if($slug==''){
            return redirect(route('shop',[get_route_url()]));
        }  
        
        if(configinfo('status') == 0){
            $request->session()->flash('error', 'Product not available');
            return redirect()->back();
        }

        $product=  Product::where('slug',$slug)->where('mid',$this->mid)->first();

        if(!empty($product)){
            $this->cart_add($product,$request);
            if($request->input('form_type') == "cart"){
                $request->session()->flash('success', 'Product added in cart successfully!');
                return redirect(route('product_show',[get_route_url(),$slug]));
            }else{
                return redirect(route('checkout',[get_route_url()]));
            }
            
        }else{
            $request->session()->flash('error', 'Something went wrong . Please try after some time');
            return redirect(route('product_show',[get_route_url(),$slug]));
        }
    }
    
    function cart_list(){
        $content['product'] = \Cart::content();
        $content['product_count'] = \Cart::count();
        return view('front.product.cart',$content)->with('call_back',$this);
    }


    function tax_calculate($tax_id,$amount=0){
      $tax_rate = \App\Models\Tax::where('id',$tax_id)->where('mid',$this->mid)->pluck('rate')->first();
      return $amount * $tax_rate /100;
    }
    function tax_rate($tax_id){
       return \App\Models\Tax::where('id',$tax_id)->where('mid',$this->mid)->pluck('rate')->first();
    }
    function cart_item_remove($id=0){
        \Cart::remove($id);
        Session::flash('success', 'Cart updated successfully!');
        return redirect()->back();
    }
    function cart_item_update(Request $request){
        for($i=0;$i<count($request->input('qty'));$i++){
            \Cart::update($_POST['id'][$i], ['qty' => $_POST['qty'][$i]]); 
        }
        $request->session()->flash('success', 'Cart updated successfully!');
        return redirect()->back();
    }


    function cart_remove(){
        \Cart::destroy();
    }
    function get_product_info($id=0,$field){
        return Product::where('id',$id)->where('mid',$this->mid)->pluck($field)->first();
    }
    function checkout(){
        if(configinfo('status') == 0){
            $request->session()->flash('error', 'Product not available');
            return redirect()->back();
        }
        $content['product'] = \Cart::content();
        $count = \Cart::count();
        if($count){
            return view('front.product.checkout',$content)->with('call_back',$this);
        }else{
            Session::flash('error', 'Please first add some product in basket');
            return redirect(route('shop',[get_route_url()]));
        }

    }

    function order_generate($domain,Request $request){



        if($request->has('ship')){
            $request->validate([
                'ship_name' => 'required',
                'ship_street' => 'required',
                'ship_city' => 'required',
                'ship_postcode' => 'required'
            ]);
        }

        if(Auth::check() ==false){

            $request->validate([
                'email' => 'required|email|unique:users,email',
                'name' => 'required',
                'password' => 'required',
                'street' => 'required',
                'city' => 'required',
                'postcode' => 'required',
                'phone' => 'required',

            ]);

            $user_content['name'] = $request->input('name');
            $user_content['email'] = $request->input('email');
            $user_content['password'] = bcrypt($request->input('password'));
            $user_content['role'] = 2;
            $user_content['status'] = 1;
            $user_content['company_name'] = $request->input('company');
            $user_content['street'] = $request->input('street');
            $user_content['address'] = $request->input('address');
            $user_content['city'] = $request->input('city');
            $user_content['state'] = $request->input('state');
            $user_content['country'] = $request->input('country');
            $user_content['postcode'] = $request->input('postcode');
            $user_content['phone'] = $request->input('phone');
            $userinfo = new \App\Models\User($user_content);
            $userinfo->save();
            $user_id = $userinfo->id;
            Auth::loginUsingId($user_id, TRUE);
        }else{
            $user_id = Auth::id();
        }



        $order['user_id'] = $user_id;
        $order['product'] = json_encode(\Cart::content());
        $order['deliver_charge']= deliver_charge();
        $order['total']=deliver_charge()+ $this->get_cart_figure('amount_total');
        $order['tax']= $this->get_cart_figure('tax_total');
        $order['payment_status'] ='non-paid';
        $order['mid'] = $this->mid;
        $order['order_note']=$request->input('order_note');
        if($request->has('ship')){
            $order['product_ship_to'] ='different';
        }else{
            $order['product_ship_to'] ='profile';
        }
        $order_save = new \App\Models\Orders($order);
        $content_cart = \Cart::content();
        if($order_save->save()){


            $order_id = $order_save->id;

            $content_cart = \Cart::content();
            //echo "<pre>"; print_r($content_cart); echo "</pre>"; die();
            if(!empty($content_cart)){
                foreach($content_cart as $p){
                    $variations='';
                    $total_tax = 0;
                    $order_details['order_id'] = $order_id;
                    $order_details['product_id'] = $p->id;
                    $order_details['product_name'] = $p->name;
                    $order_details['price'] = $p->price;
                    $order_details['qty'] = $p->qty;
                    if($p->options->tax){

                        $order_details['tax_rate'] = $p->options->tax_rate;
                        $total_tax = $p->options->tax * $p->qty;
                        $order_details['tax'] = $total_tax;

                    }else{
                        $order_details['tax_rate']=0;
                        $order_details['tax']=0;
                    }
                    
                    $order_details['product_variations']='';
                    $order_details['product_attachments'] ='';
                    $order_details['total'] = ($p->price * $p->qty) + $total_tax;

                    $order_details_save = new \App\Models\OrdersDetails($order_details);
                    $order_details_save->save();

                }
            }


             $ship['order_id'] = $order_id;
             $ship['user_id'] = $user_id;
             //$ship['ship_phone'] = Auth::user()->phone;

            /*If shipping choose*/
            if($request->has('ship')){

                $ship['ship_name'] = $request->input('ship_name');
                $ship['ship_street'] = $request->input('ship_street');
                $ship['ship_address'] = $request->input('ship_address');
                $ship['ship_city'] = $request->input('ship_city');
                $ship['ship_state'] = $request->input('ship_state');
                $ship['ship_country'] = $request->input('ship_country');
                $ship['ship_postcode'] = $request->input('ship_postcode');

            }else{
                $ship['ship_name'] = Auth::user()->name;
                $ship['ship_street'] = Auth::user()->street;
                $ship['ship_address'] = Auth::user()->address;
                $ship['ship_city'] = Auth::user()->city;
                $ship['ship_state'] = Auth::user()->state;
                $ship['ship_country'] = Auth::user()->country;
                $ship['ship_postcode'] = Auth::user()->postcode;
            }

            $ship_save = new Shipping($ship);
            $ship_save->save();
            //
            //$this->send_invoice_email($order_id,Auth::user()->email);
            if($request->input('paymenttype') == "online"){
                return redirect(route('payment.beep_process',[get_route_url(),encode($order_id)]));
            }elseif($request->input('paymenttype') == "credit"){
                /****Credit Process */
            }else{
                \Cart::destroy();
                //$this->send_invoice_email($order_id,Auth::user()->email);
                return redirect(route('order_success_offline',[get_route_url(),$order_id]));
            }

        }else{
            return redirect(route('order_fail',[get_route_url()]));
        }
    }
    function order_success($id=0){
        $content['order_id'] = $id;
        return view('front.product.success',$content);
    }

    function send_invoice_email($order_id=0,$to=''){
        $record['r'] = \App\Models\Orders::with(['order_details','shipping'])->where('id',$order_id)->first();
        
        $invoice_address = configinfo('invoice_address');
        $invoice_logo = configinfo('invoice_logo');
        
        if(configinfo('invoice_address') == ""){
            $invoice_address = configinfo('address');
        }
        if(configinfo('invoice_logo') == ""){
            $invoice_logo = configinfo('logo');
        }
        $record['inv_address'] =$invoice_address;
        $record['inv_logo'] =$invoice_logo;
        $record['inv_phone'] =configinfo('phone');
        $record['inv_email'] =configinfo('email');
        
        $path = './invoice/invoice_order_'.$order_id.'.pdf';
        $pdf = PDF::loadView('email_template.invoice_pdf', $record);
        $status = $pdf->save($path);

        $view = view('email_template.invoice',$record);
        $content =$view->render();
        
        /*Email code send*/
        //$this->common->sendSMTPSystem($to, "Invoice Order - #".$order_id,$content,$path);
        return 1;
    }


    function order_fail(){
        die("Fail order");
    }

    function get_cart_figure($field=""){
        $content = \Cart::content();
        if(!empty($content)){
            $tax_total = 0;
            $total_amount =0;

            foreach($content as $p){
                if($p->options->tax){
                    $tax = $p->options->tax * $p->qty ;
                    $tax_total+= $tax;
                }
            }

            $total_amount=number_format_set(\Cart::subtotal()) +$tax_total;

            if($field =="tax_total"){
                return $tax_total;
            }elseif($field =="amount_total"){
                return $total_amount;
            }
        }
    }



}
