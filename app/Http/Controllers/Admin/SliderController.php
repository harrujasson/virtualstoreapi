<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\Slider;
use App\Http\Controllers\CommonController;

class SliderController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.slider.create');
    }
    public function show(){
        return view('admin.slider.list');
    }
    public function edit($id){
      $content['r']=  Slider::find($id);
      return view('admin.slider.edit',$content);
    }

    public function store(Request $request){

        $request->validate([
            'picture' => 'required'
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  'uploads/product/' );
        }
        if($request->file('picture_mobile')){
            $form_data['picture_mobile']=  $this->common->fileUpload($request->file('picture_mobile'),  'uploads/product/' );
        }

        $data = new Slider($form_data);
        if($data->save()){
            $request->session()->flash('success', 'slider created successfully!');
            return redirect(route('admin.slider.create'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.slider.create'));
        }
    }
    public function update(Request $request,$id){
        
        $form_data = $request->all();
        $data = slider::find($id);
        if($request->file('picture')){
            $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  'uploads/product/' );
        }
        if($request->file('picture_mobile')){
            $form_data['picture_mobile']=  $this->common->fileUpload($request->file('picture_mobile'),  'uploads/product/' );
        }

        if($data->update($form_data)){
            $request->session()->flash('success', 'slider updated successfully!');
            return redirect(route('admin.slider.manage'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.slider.manage'));
        }
    }

    function showList(){
        $record = Slider::query();
        return Datatables::of($record)
            ->editColumn('picture',function($record) {
                if($record->picture!=""){
                    if($record->slide_type == "picture"){
                        return "<img class='rounded-circle avatar-sm' width='50' src='". asset("uploads/product/".$record->picture)."'>";
                    }else{
                        return "<i class='bx bx-video-recording'></i>";
                    }
                    
                }
            })
            ->editColumn('status',function($record) {
                if($record->status){
                    return "<span class='badge badge-pill badge-soft-success font-size-15'>Published</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-danger font-size-15'>Approval Pending</span>";
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.slider.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.slider.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','picture','status'])
            ->make(true);
    }

    function delete($id){
        echo Slider::where("id",$id)->delete();
        die();
    }
}
