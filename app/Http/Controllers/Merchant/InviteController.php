<?php

namespace App\Http\Controllers\Merchant;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Models\Invite;
use Auth;


class InviteController extends Controller
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

    public function create(){
        return view('merchant.invite.create');
    }
    public function show(){
        return view('merchant.invite.list');
    }
    public function store(Request $request){
        
        $request->validate([
            'email' =>'required|unique:users',
        ],  $this->message_errors());
        
        $form_data = $request->all();
        $form_data['merchant_id'] = Auth::id();        
        $data = new Invite($form_data);       
        if($data->save()){

            $id = encode($data->id);
            $email['company'] = Auth::user()->name;
            $email['id'] = $id;
            $view = view('email.invite',$email);
            $content =$view->render();
            //echo $content; die();
            //$to = $form_data['email'];
            //$this->common->sendSMTPSystem($to,'Invite Link',$content);

            $request->session()->flash('success', 'Innvite has been sent successfully!');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Error!');
            return redirect()->back();
        }
    } 
    function showList(){        
        $record = Invite::where('merchant_id',Auth::id());    
          
        return Datatables::of($record) 

            ->editColumn('status',function($record) {
                if($record->status == "1"){
                 return "<span class='badge badge-soft-success'>Active</span>";
                }else{
                    return "<span class='badge badge-soft-danger'>De-Active</span>";
                }
            })
            ->addColumn('actions',function($record) {
                if($record->status == "0"){
                    $actions= '<a href="javascript:void(0);" data-url="'. route('merchant.client.invitation.deleteAjax',$record->id).'" class="on-default sa-warning"><i class="fas fa-trash-alt"></i></a> &nbsp;';
                    return $actions;
                }
                
            })
            ->rawColumns(['actions','status'])
            ->make(true);            
    }   
    
    function delete($id){
        echo Invite::where('merchant_id',Auth::id())->where("id",$id)->delete();  
        die();
    }

    function message_errors(){
        return [
            'email.required'=>'Email Required',
            'email.unique'=>'This email already register'
        ];
    }

    
}
