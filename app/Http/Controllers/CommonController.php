<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Library\PHPMailer;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $from;
    public $fromemail;
    public $reply;
    public $replyemail;
    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
        $this->fromemail = \Illuminate\Support\Facades\Config::get('constant.emailsinfo.from');
        $this->from = \Illuminate\Support\Facades\Config::get('constant.emailsinfo.fromname');
        $this->replyemail = \Illuminate\Support\Facades\Config::get('constant.emailsinfo.reply');
        $this->reply = \Illuminate\Support\Facades\Config::get('constant.emailsinfo.replyname');


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    function getRecord($table,$where=array()){
        $query= DB::table($table);
        if(!empty($where)){
            $query->where($where);
        }
        return $query->get();

    }
    function getRecordByField($table,$where=array(),$field){
        $query= DB::table($table);
        if(!empty($where)){
            $query->where($where);
        }
        $record = $query->first();
        if($record){
           return $record->$field;
        }

    }
    function getRecordid($table,$id){
        return DB::table($table)->where('user_id',$id)->value('id');
    }


    function dateManuplationGet($start,$end,$return=""){

            $dateOne = new DateTime($start);
            $dateTwo = new DateTime($end);
            $interval = $dateOne->diff($dateTwo);

            $minutes = $interval->format("%i");

            $hours = $interval->h;
            $hours = $hours + ($interval->days*24);
            $day=$interval->days;
            $last_days=$interval->d;
            $seconds=$dateTwo->getTimestamp() - $dateOne->getTimestamp();
            if($return=="hour"){
                return $hours;
            }elseif($return=="day"){
                return $day;
            }elseif($return=="seconds"){
                return $seconds;
            }elseif($return=="minutes"){
                return $minutes;
            }elseif($return=="last days"){
                return $last_days;
            }elseif($return=="equality"){

                if ($dateOne < $dateTwo)
                   return -1;  // lt
                 else if ($dateOne == $dateTwo)
                   return 0;  // eq
                 else if ($dateOne > $dateTwo)
                   return 1;  // gt
                 else
                   return "Nothing";
            }
            else{
                return $interval;
            }
    }

    /*Ajax upload*/
    function pictureUploadProperty(Request $request){
        if($request->file('myfile')){
            $name= $this->fileUpload($request->file('myfile'), 'uploads/'.$request->input('directory') );
            echo json_encode($name);
            die();
       }
    }
    function pictureDeleteProperty(Request $request){
            $destination = 'uploads/'.$request->input('directory')."/".$request->input("op");
            $this->fileDel($destination);

    }
    function pictureUpload(Request $request){
        if($request->file('myfile')){
            $name= $this->fileUpload($request->file('myfile'), 'uploads/'.$request->input("op").'/' );
            $data['name'] = $name;
            $data['src'] = asset('uploads/'.$request->input("op").'/'.$name);
            echo json_encode($data);
            die();
       }
    }
    function fileUploadAjax($file,$destination){
            $destinationPath = $destination;
            $temp = explode(".",$file->getClientOriginalName());
            $filenamename=  md5(rand(1, 1000).date("d/m/y h:i:s").'multi').'.'.end($temp);
            //$filenamename=  $file->getClientOriginalName();
            $file->move($destinationPath,$file->getClientOriginalName());

            //$file->copy($destinationPath.'/'.$filenamename, $destinationPath.'/orginal/'.$filenamename);
            //$success = \File::copy($destinationPath.'/'.$filenamename,$destinationPath.'orignal/'.$filenamename);
            return $filenamename;
    }

    /*End ajax**/

    /*Upload Picture*/
    function imageUploadSave(Request $request){
       if($request->file('myfile')){
            $path = "uploads/template/temp";
            $name= $this->common->fileUpload($request->file('myfile'),  $path );
            return $name;
       }
    }
    function pictureDelete(Request $request){

            $destination = 'uploads/'.$request->input('action')."/".$request->input("name");
            //echo $destination; die();
            $this->fileDel($destination);

    }
    function fileUpload($file,$destination){
            $destinationPath = $destination;
            /*$temp = explode(".",$file->getClientOriginalName());
            $filenamename=  md5(rand(1, 1000).date("d/m/y h:i:s").'multi').'.'.end($temp);
            $file->move($destinationPath,$filenamename); */



            $count = count(glob($destinationPath . '/*' . $file->getClientOriginalName()));
            $fileRestName = str_replace(" ", "_", $file->getClientOriginalName());
            $filenamename = ($count > 0) ? $count . '-' . $fileRestName: $fileRestName;
            $file->move($destinationPath, $filenamename);
            return $filenamename;
    }
    function fileDel($file){
        if(file_exists($file)){
            unlink($file);
        }
    }

    function allowed_ext($type="media"){
        if($type=="file"){
            return array("application/pdf","application/msword","application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        }elseif($type=="media"){
            return array("image/png","image/jpeg","image/jpg","image/gif");
        }elseif($type=="zip"){
            return array("application/octet-stream");
        }elseif($type=="zip&file"){
            return array("application/octet-stream","application/pdf","application/msword","application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        }elseif($type=="audio"){
            return array(
                'mpeg', 'x-mpeg', 'mpeg3', 'x-mpeg-3', 'aiff',
                'mid', 'x-aiff', 'x-mpequrl','midi', 'x-mid',
                'x-midi','wav','x-wav','xm','x-aac','basic',
                'flac','mp4','x-matroska','ogg','s3m','x-ms-wax',
                'xm'
            );
        }
    }

    function filetypecheck($file_type,$allowed=array()){
        if(!in_array($file_type, $allowed)) {
          return 1;
        }else{
          return 0;
        }
    }

    function encode($val){
        return str_replace(array('+', '/','='), array('', '',''), strrev(substr(md5(999),3,4).base64_encode(strrev("`".$val."~".substr(md5($val),0,10).'p04b54'))));
       }
   
       function decode($code){
        $val = strrev(base64_decode(str_replace(array('', '',''), array('+', '/','='),strrev($code))));
        $val = ltrim(current(explode('~',$val)),'`');
        return $val;
       }
       function makeDirCheck($path){
           if(!File::isDirectory($path)){
               File::makeDirectory($path, 0777, true, true);
               return $path;
           }else{
               return $path;
           }
       }
   
       function sendSMTPSystem($to,$subject="",$content="",$attachment=""){
           
           $hostname = env("MAIL_HOST", "");
           $port = env("MAIL_PORT", "");
           $username = env("MAIL_USERNAME","");
           $password = env("MAIL_PASSWORD", "");
           $secure = env("MAIL_ENCRYPTION", "");
           //echo "<pre>"; 
           //echo "HOST: ". $hostname." PORT: ".$port." USERNAME: ".$username." PASSW: ".$password." SECURE: ".$secure;
          // die();
          $mail = new PHPMailer(true);
   
          try{
               $mail->isSMTP();                                   
               $mail->Host = $hostname; 
               $mail->SMTPAuth = false;                           
               $mail->Username = $username;  
               $mail->Password = $password; 
               $mail->SMTPSecure = $secure;
               //$mail->SMTPDebug = true;
               $mail->Port = $port;
               $mail->protocol = 'mail';
               $mail->SMTPAuth = true;
               $mail->ContentType = 'text/html; charset=utf-8';
               $mail->SMTPOptions = array(
                   'ssl' => array(
                       'verify_peer' => false,
                       'verify_peer_name' => false,
                       'allow_self_signed' => true
                   )
               );
   
               
   
               //Recipients
               $mail->setFrom($this->fromemail, $this->from);
               $mail->addAddress($to);               // Name is optional
               $mail->addReplyTo($this->replyemail, $this->reply);
   
               if($attachment!=""){
                   $mail->addAttachment($attachment);
               }
   
               //Content
               $mail->isHTML(true);                                  // Set email format to HTML
               $mail->Subject = $subject;
               $mail->Body    = $content;
               $mail->AltBody = $content;
               
               $mail->send();
               return '1';
           } catch (Exception $e) {
               return 'Message could not be sent. Mailer Error: '. $e->getMessage();
           }
      }

    public function getCsv($columnNames, $rows, $fileName = 'file.csv') {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    function getCsvArray($file=''){
        $arrayData=  array();
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $arrayData[] = $data;
            }
            fclose($handle);
        }
        return $arrayData;
    }

   
}
