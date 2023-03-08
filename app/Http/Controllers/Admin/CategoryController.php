<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\Category;
use App\Http\Controllers\CommonController;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $mid;
    public $domain;
    protected $title='Category';
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
        $content['title']  = $this->title;
        $content['main_category'] = Category::where('type','Main')->get();
        $content['category'] = Category::where('type','Parent')->get();
        return view('admin.category.create',$content);
    }
    public function show(){
        $content['title'] = $this->title;
        return view('admin.category.list',$content);
    }
    public function edit($domain, $id){
      $content['title'] = $this->title;
      $content['r']=  Category::find($id);
      $content['main_category'] = Category::where('mid',$this->mid)->where('type','Main')->get();
      $content['category'] = Category::where('type','Parent')->get();
      return view('admin.category.edit',$content);
    }

    public function store($domain, Request $request){

        $request->validate([
            'name' => 'required'
        ]);

        $form_data = $request->all();

        if($request->file('picture')){
             $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  'uploads/category/',0 );
        }
        if($request->file('mobile_picture')){
            $form_data['mobile_picture']=  $this->common->fileUpload($request->file('mobile_picture'),  'uploads/category/',0 );
        }
        if($request->file('desktop_picture')){
            $form_data['desktop_picture']=  $this->common->fileUpload($request->file('desktop_picture'),  'uploads/category/',0 );
        }
        $form_data['mid'] =Auth::user()->mid;
        $data = new Category($form_data);
        if($data->save()){
            $request->session()->flash('success', 'Category created successfully!');
            return redirect(route('admin.category.create',[get_route_url()]));
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect(route('admin.category.create',[get_route_url()]));
        }
    }
    public function update($domain,Request $request,$id){
        $request->validate([
            'name' => 'required'
        ]);
        $form_data = $request->all();
        $data = Category::find($id);

        if($request->file('picture')){
             $form_data['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/category/',0);
        }
        if($request->file('mobile_picture')){
            $form_data['mobile_picture']=  $this->common->fileUpload($request->file('mobile_picture'),  'uploads/category/',0 );
        }
        if($request->file('desktop_picture')){
            $form_data['desktop_picture']=  $this->common->fileUpload($request->file('desktop_picture'),  'uploads/category/',0 );
        }
        if($data->update($form_data)){
            $request->session()->flash('success', 'Category updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function showList(){
        $record = Category::where('mid',Auth::user()->mid);
        return Datatables::of($record)
           ->editColumn('parent',function($record) {
               if($record->parent!=0){
                  $parent = Category::select('name')->where('id',$record->parent)->first();
                  if(!empty($parent)){
                    return $parent->name;
                  }
               }

            })
            ->editColumn('main',function($record) {
                if($record->main!=0){
                   $main = Category::select('name')->where('id',$record->main)->first();
                   if(!empty($main)){
                     return $main->name;
                   }
                }

             })

             ->editColumn('status',function($record) {
                if($record->status==0){
                        return '<span class="badge badge-soft-danger" key="t-new">De-Active</span>';
                }else{
                    return '<span class="badge badge-soft-success" key="t-new">Active</span>';
                }
            })

            ->editColumn('picture',function($record) {
                if($record->picture!=""){
                    return '<img alt=""  class="thumb-sm rounded-circle me-2" src="'.asset('uploads/category/'.$record->picture).'">';
                }else{
                    return '<span class="thumb-sm justify-content-center d-flex align-items-center bg-warning rounded-circle me-2">
                        <i class="fas fa-user text-white"></i>
                    </span>';
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.category.editForm',[get_route_url(),$record->id]).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.category.deleteAjax',[get_route_url(),$record->id]).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status','picture'])
            ->make(true);
    }

    function delete($domain,$id){
        echo Category::where("id",$id)->delete();
        die();
    }

    function get_category(Request $request){
        if($request->input('id')!=""){

            $result = Category::where('main',$request->input('id'))->get();
            $data = array();
            if(!empty($result)){
                $i = 0;
                foreach($result as $r){
                    $data[$i]['id'] = $r->id;
                    $data[$i]['name'] = $r->name;
                    $i++;
                }
                return json_encode($data);
            }

        }

    }
}
