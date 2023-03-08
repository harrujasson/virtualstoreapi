<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\Package;
use App\Models\PackageService;
use Auth;


class PackageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    public function __construct()
    {

        $this->common=new CommonController();
    }

    public function create(){
        $data['service'] = PackageService::where('status',1)->where('type','Package')->where('created_by',Auth::id())->get();
        return view('admin.package.create',$data);
    }
    public function show(){
        return view('admin.package.list');
    }
    public function edit($id){
      $content['r']=  Package::where('id',$id)->where('created_by',Auth::id())->first();
      $content['service'] = PackageService::where('status',1)->where('type','Package')->where('created_by',Auth::id())->get();
      return view('admin.package.edit',$content);  
    }
    
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required' ,
            'regular_price' => 'required',           
        ],  $this->message_errors());
        
        $form_data = $request->all();
        $form_data['created_by'] = Auth::id();
       
        if($request->has('service_id')){
            $form_data['service_id'] = implode(",",$form_data['service_id']);
        }
        $data = new Package($form_data);       
        if($data->save()){
            $request->session()->flash('success', 'Package has been created successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }     
    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required' ,
            'regular_price' => 'required',           
        ],  $this->message_errors());

        $form_data = $request->all();
        if($request->has('service_id')){
            $form_data['service_id'] = implode(",",$form_data['service_id']);
        }
        $data = Package::find($id); 
        
        if($data->update($form_data)){
            $request->session()->flash('success', 'Package has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    
    function showList(){        
        $record = Package::where('created_by',Auth::id());    
          
        return Datatables::of($record) 

            ->editColumn('status',function($record) {
                if($record->status == "1"){
                 return "<span class='badge badge-soft-success'>Active</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>De-Active</span>";
                }
            })
            ->editColumn('price',function($record) {
                if($record->sale_price != ""){
                    $price = currency().number_format($record->sale_price,2);
                    $price.= ' <del class="text-muted font-10">'.currency().number_format($record->regular_price,2).'</del>';
                    return $price;
                }else{
                    return currency().number_format($record->regular_price,2);
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.package.editForm',$record->id).'" class="on-default"><i class="fas fa-pencil-alt"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.package.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status','price'])
            ->make(true);            
    }   
    
    function delete($id){
        echo Package::where("id",$id)->delete();  
        die();
        
    }

    function message_errors(){
        return [
            'name.required'=>'Package Name Required',
            'name.regular_price'=>'Regular Price Required'
        ];
    }

    
}
