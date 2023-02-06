<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Model\Blog;
use App\Model\BlogCategory;
use App\Http\Controllers\CommonController;

class BlogController extends Controller
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
        $content['category'] = BlogCategory::where('status',1)->get();
        return view('admin.blog.create',$content);
    }
    public function show(){
        return view('admin.blog.list');
    }
    public function edit($id){
      $content['r']=  Blog::find($id);      
      $content['category'] = BlogCategory::where('status',1)->get();
      return view('admin.blog.edit',$content);
    }

    public function store(Request $request){
        
        $request->validate([
            'title' => 'required'
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
             $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  'uploads/blog/',0 );
        }   
        if($request->has('editor_pick')){
            $form_data['editor_pick'] = 1;
        }else{
            $form_data['editor_pick'] = 0;
        }     
        $data = new Blog($form_data);
        if($data->save()){
            $request->session()->flash('success', 'blog created successfully!');
            return redirect(route('admin.blog.create'));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.blog.create'));
        }
    }
    public function update(Request $request,$id){
        $request->validate([
            'title' => 'required'
        ]);
        $form_data = $request->all();
        $data = Blog::find($id);

        if($request->file('picture')){
             $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/blog/',0);
        }
        if($request->has('editor_pick')){
            $form_data['editor_pick'] = 1;
        }else{
            $form_data['editor_pick'] = 0;
        }
        
        if($data->update($form_data)){
            $request->session()->flash('success', 'blog updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function showList(){
        $record = Blog::query();
        return Datatables::of($record)
           
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.blog.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.blog.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    function delete($id){
        echo Blog::where("id",$id)->delete();
        die();
    }
}
