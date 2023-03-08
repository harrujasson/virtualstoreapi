<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\PackageService;
use Auth;


class PackageServiceController extends Controller
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
        return view('admin.package_service.create');
    }
    public function show(){
        return view('admin.package_service.list');
    }
    public function edit($id){
      $content['r']=  PackageService::where('created_by',Auth::id())->where('id',$id)->first();
      return view('admin.package_service.edit',$content);  
    }
    
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required' ,
            'price' => 'required',           
        ],  $this->message_errors());
        
        $form_data = $request->all();
        $form_data['created_by'] = Auth::id();
        
        $data = new PackageService($form_data);       
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
            'price' => 'required',           
        ],  $this->message_errors());

        $form_data = $request->all();
        $data = PackageService::find($id); 
        
        if($data->update($form_data)){
            $request->session()->flash('success', 'Package has been updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    
    function showList(){        
        $record = PackageService::where('created_by',Auth::id());    
          
        return Datatables::of($record) 

            ->editColumn('status',function($record) {
                if($record->status == "1"){
                 return "<span class='badge badge-soft-success'>Active</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>De-Active</span>";
                }
            })
            ->editColumn('price',function($record) {
                
                return currency().number_format($record->price,2);
                
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.service.editForm',$record->id).'" class="on-default"><i class="fas fa-pencil-alt"></i></a> &nbsp;';
                //$actions.= '<a href="javascript:void(0);" data-url="'. route('admin.service.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status','price'])
            ->make(true);            
    }   
    
    function delete($id){
        echo PackageService::where('created_by',Auth::id())->where("id",$id)->delete();  
        die();
    }

    function message_errors(){
        return [
            'name.required'=>'Service Name Required',
            'name.price'=>'Price Required'
        ];
    }

    
}
