<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\Attribute;
use App\Model\Attributevalue;


class AttributeController extends Controller
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
        $content['attribute'] = Attribute::get();

        return view('admin.attribute.create',$content);
    }
    public function show(){
        return view('admin.attribute.list');
    }
    public function edit($id){
      $content['r']=  Attribute::find($id);
      $content['values'] = Attributevalue::where('attribute_id',$id)->get();      
      $content['attribute'] = Attribute::where('id','!=',$id)->get();
      return view('admin.attribute.edit',$content);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'label' => 'required'
        ]);
        $form_data = $request->all();


        $form_data['name'] = str_replace(' ', '_', $form_data['name']);

        $data = new Attribute($form_data);
        if($data->save()){

            if($request->has('attribute')){
                $i=0;
                $attributes = array();
                foreach($request->input('attribute') as  $key => $attr){
                    $i=0;
                    foreach($attr as $at){                
                        if($at!=""){
                            $attributes[$i][$key] = $at;
                            $i++;
                        }
                    }
                } 
                if(!empty($request->input('attribute'))){
                    $attr_value['attribute_id'] = $data->id;                    
                    foreach($attributes as $attr){                      

                        $attr_value['data'] = $attr['value'];
                        $attr_value['name'] = $attr['name'];
                        $attr_value['parent_id'] = '';
                        $attr_content = new Attributevalue($attr_value);
                        $attr_content->save();                        

                    }

                }
            }

            $request->session()->flash('success', 'Attribute created successfully!');
            return redirect(route('admin.attribute.create'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.attribute.create'));
        }
    }
    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required'
        ]);
               
        $form_data = $request->all();
        $data = Attribute::find($id);

        if($data->update($form_data)){

            if($request->has('attribute')){
                $i=0;
                $attributes = array();
                foreach($request->input('attribute') as  $key => $attr){
                    $i=0;
                    foreach($attr as $at){                
                        if($at!=""){
                            $attributes[$i][$key] = $at;
                            $i++;
                        }
                    }
                } 
                if(!empty($request->input('attribute'))){
                    $attr_value['attribute_id'] = $data->id;
                    $this->delete_attribute_value($data->id);
                    foreach($attributes as $attr){                      

                        $attr_value['data'] = $attr['value'];
                        $attr_value['name'] = $attr['name'];
                        $attr_value['parent_id'] = '';
                        $attr_content = new Attributevalue($attr_value);
                        $attr_content->save();                        

                    }

                }
            }

            $request->session()->flash('success', 'Attribute updated successfully!');
            return redirect(route('admin.attribute.manage'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.attribute.manage'));
        }
    }

    function showList(){
        $record = Attribute::query();
        return Datatables::of($record)
           ->editColumn('parent',function($record) {
               if($record->parent!=0){
                  $parent = Attribute::select('name')->where('id',$record->parent)->first();
                  if(!empty($parent)){
                    return $parent->name;
                  }
               }

            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.attribute.editForm',$record->id).'" class="on-default"><i class="fas fa-pencil-alt"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.attribute.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    function delete($id){

        echo Attribute::where("id",$id)->delete();
        $this->delete_attribute_value($id);
        die();
    }
    function delete_attribute_value($id){
        return Attributevalue::where('attribute_id',$id)->delete();
    }
}
