<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\BlogCategory;
use App\Http\Controllers\CommonController;


class BlogcategoryController extends Controller
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
        $content['category'] = BlogCategory::all();
        return view('admin.blogcategory.create',$content);
    }
    public function show(){       
        return view('admin.blogcategory.list');
    }
    public function edit($id){
      $content['category'] = BlogCategory::all();
      $content['r']=  BlogCategory::find($id);     
      return view('admin.blogcategory.edit',$content);  
    }
    
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',            
        ]);        
        $form_data = $request->all();  
        $data = new BlogCategory($form_data);       
        if($data->save()){
            $request->session()->flash('success', 'Aticle created successfully!');
            return redirect(route('admin.blog_category.add_new'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.blog_category.add_new'));
        }
    }  
    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required',
        ]);
        $form_data = $request->all();
        $data = BlogCategory::find($id);  
           
        
        if($data->update($form_data)){
            $request->session()->flash('success', 'Aticle updated successfully!');
            return redirect(route('admin.blog_category.manage'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.blog_category.manage'));
        }
    }
    
    function showList(){        
        $record = BlogCategory::query();        
        return Datatables::of($record) 
            ->editColumn('parent',function($record) {
                if($record->parent!=0){
                $parent = BlogCategory::select('name')->where('id',$record->parent)->first();
                if(!empty($parent)){
                    return $parent->name;
                }
                }

            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.blog_category.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.blog_category.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);            
    }   
    
    function delete($id){        
        echo BlogCategory::where("id",$id)->delete();          
        die();
    }
}
