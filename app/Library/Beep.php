<?php 
namespace App\Library;

Class beep{
    private $url ='https://pay.beep.solutions/generateorder';
    private $redirect_url='https://pay.beep.solutions/order?Token=';
    private $returnUrl = '';
    private $user='jr75o562u3cahls0w30g8112';
    private $apiToken='nts6mxg4d0ueh05ab249c108';

    function __construct(){
    }
    function make_payment($data){
        $data['returnUrl'] =route('payment.beep_payment_response',[get_route_url()]);
        $data['user'] =$this->user;
        $data['apiToken'] =$this->apiToken;
      
        $responseraw = $this->call($data);
        $response =  json_decode($responseraw);
        if($response->success == 1){
            $token = $response->result->Token;  
            return $this->redirect_url.$token;  
        }
    }
    function call($data){
        $datas = json_encode($data);   
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = $datas;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
}


?>