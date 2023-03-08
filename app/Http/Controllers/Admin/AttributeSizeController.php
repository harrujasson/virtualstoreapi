<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\AttributeSize;
use App\Model\AttributeSizeOption;


class AttributeSizeController extends Controller
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

        return view('admin.attributesize.create');
    }
    public function show(){
        return view('admin.attributesize.list');
    }
    public function edit($id){
      $content['r']=  AttributeSize::find($id);
      $content['options'] = AttributeSizeOption::where('attribute_size_id',$id)->get();
      return view('admin.attributesize.edit',$content);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'label' => 'required'
        ]);
        $form_data = $request->all();
        $data = new AttributeSize($form_data);
        if($data->save()){

            if($request->has('attributeoptions')){
                if(!empty($request->input('attributeoptions'))){
                    $attr_value['attribute_size_id'] = $data->id;
                    foreach($request->input('attributeoptions') as $attr){
                        if($attr['name'] !=""){
                            $attr_value['name'] = $attr['name'];
                            $attr_content = new AttributeSizeOption($attr_value);
                            $attr_content->save();
                        }
                    }
                }
            }
            $request->session()->flash('success', 'AttributeSize created successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'label' => 'required'
        ]);
        $form_data = $request->all();
        $data = AttributeSize::find($id);

        if($data->update($form_data)){
            $this->delete_attribute_value($id);
            if($request->has('attributeoptions')){
                if(!empty($request->input('attributeoptions'))){
                    $attr_value['attribute_size_id'] = $data->id;
                    foreach($request->input('attributeoptions') as $attr){
                        if($attr['name'] !=""){
                            $attr_value['name'] = $attr['name'];
                            $attr_content = new AttributeSizeOption($attr_value);
                            $attr_content->save();
                        }
                    }
                }
            }

            $request->session()->flash('success', 'AttributeSize updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function showList(){
        $record = AttributeSize::query();
        return Datatables::of($record)
            ->editColumn('status',function($record) {
                if($record->status){
                    return "<span class='badge badge-pill badge-soft-success font-size-15'>Active</span>";
                }else{
                    return "<span class='badge badge-pill badge-soft-danger font-size-15'>De-Active</span>";
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.attribute_size.editForm',$record->id).'" class="on-default"><i class="fas fa-pencil-alt"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.attribute_size.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status'])
            ->make(true);
    }

    function delete($id){

        echo AttributeSize::where("id",$id)->delete();
        $this->delete_attribute_value($id);
        die();
    }
    function delete_attribute_value($id){
        return AttributeSizeOption::where('attribute_size_id',$id)->delete();
    }
}
