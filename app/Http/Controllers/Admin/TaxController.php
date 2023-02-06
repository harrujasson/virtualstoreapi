<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\Tax;
use App\Http\Controllers\CommonController;

class TaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $title='Tax';
    
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
        $content['title']  = $this->title;
        return view('admin.tax.create',$content);
    }
    public function show(){
        $content['title']  = $this->title;
        return view('admin.tax.list',$content);
    }
    public function edit($id){
     $content['title']  = $this->title;
      $content['r']=  Tax::find($id);
      return view('admin.tax.edit',$content);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'rate' => 'required'
        ]);

        $form_data = $request->all();

        $data = new Tax($form_data);
        if($data->save()){
            $request->session()->flash('success', 'Tax created successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'rate' => 'required'
        ]);
        $form_data = $request->all();
        $data = Tax::find($id);

        if($data->update($form_data)){
            $request->session()->flash('success', 'Tax updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }

    function showList(){
        $record = Tax::query();
        return Datatables::of($record)
            ->editColumn('status',function($record) {
                if($record->status==0){
                        return '<span class="badge badge-soft-danger" key="t-new">De-Active</span>';
                }else{
                    return '<span class="badge badge-soft-success" key="t-new">Active</span>';
                }
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.tax.editForm',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.tax.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                return $actions;
            })
            ->rawColumns(['actions','status'])
            ->make(true);
    }

    function delete($id){
        $data = Tax::find($id);
        $form['status'] = 0;
        echo $data->update($form);
        die();
    }
}
