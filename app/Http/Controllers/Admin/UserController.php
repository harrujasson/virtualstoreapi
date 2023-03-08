<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use App\Models\User;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $common;
    protected $mid;
    public $domain;
    protected $title='Clients';
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->domain = $request->subdomain; 
        $this->mid = $this->dnsloader($request->subdomain); 
        if(!$this->mid){
            return redirect()->to(base_site());
        } 
        $this->common=new CommonController();
    }

    function create(){
        $data['title'] = $this->title; 
        return view('admin.user.create',$data);
    }
    public function show(){
        $data['title'] = $this->title; 
        return view('admin.user.list',$data);
    }
    function edit($id=''){
        $content['title'] = $this->title; 
        $content['r']=  User::find($id);
        return view('admin.user.edit',$content);
    }
    function showList(){
        $record = User::where('role',2);
        return Datatables::of($record)
            ->editColumn('name',function($record) {
                return $record->name.' '.$record->last_name;        
            })
           ->editColumn('status',function($record) {
            if($record->status==0){
                    return '<span class="badge badge-soft-danger" key="t-new">De-Active</span>';
            }else{
                return '<span class="badge badge-soft-success" key="t-new">Active</span>';
            }
            })
            ->editColumn('created_at',function($record) {
                return date("Y-m-d", strtotime($record->created_at));
            })
            ->editColumn('picture',function($record) {
                if($record->picture!=""){
                    return '<img alt=""  class="thumb-sm rounded-circle me-2" src="'.asset('uploads/profile/'.$record->picture).'">';
                }else{
                    return '<span class="thumb-sm justify-content-center d-flex align-items-center bg-warning rounded-circle me-2">
                        <i class="fas fa-user text-white"></i>
                    </span>';
                }
            })

            
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.user.edit',$record->id).'" class="on-default"><i class="fas fa-search-plus"></i></a> &nbsp;';
                $actions.= '<a href="javascript:void(0);" data-url="'. route('admin.user.delete',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';


                return $actions;
            })
            ->rawColumns(['actions','status','picture'])
            ->make(true);
    }

    function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email' =>'required|unique:users',
            'password' =>'required'
        ],$this->message_errors());
        $formdata= $request->all();

        $formdata['password'] = Hash::make($request->input('password'));
        $formdata['role']  = 2;
        

        if($request->file('picture')){
            $formdata['picture']=  $this->common->fileUpload($request->file('picture'),  './uploads/profile');
        }

        $user = new User($formdata);
        if($user->save()){
            $request->session()->flash('success', 'User has been created');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ],$this->message_errors());

        $data = User::where('id',$id)->first();
        $data->name = $request->input('name');
        $data->last_name = $request->input('last_name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->status = $request->input('status');
        $data->street = $request->input('street');
        $data->address = $request->input('address');
        $data->zipcode = $request->input('zipcode');
        $data->city = $request->input('city');
        $data->state = $request->input('state');
        $data->country = $request->input('country');

        if($request->input('new_password')!=""){
            $data->password = bcrypt($request->input('new_password'));
        }

        if($request->file('picture')){
            $data->picture=  $this->common->fileUpload($request->file('picture'),  './uploads/profile');
        }
        if($data->save()){
            $request->session()->flash('success', 'Profile has updated successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    }
    function delete($id = ''){
        echo User::where("id",$id)->delete();
        die();
    }

    function message_errors(){
        return [
            'name.required'=>'Name required',
            'email.required'=>'Email required',
            'email.unique'=>'Email already exist',
            'password.required' => 'Password required'

        ];
    }
}
