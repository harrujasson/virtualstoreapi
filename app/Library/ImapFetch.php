<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Library;

/**
 * Description of ImapFetch
 *
 * @author talwin
 */
class ImapFetch {
    
    protected $conn;
    protected $host;
    protected $username;
    protected $password;


    function __construct($params =array()) {
        if(!empty($params)){
            $this->host = $params['host'];
            $this->username = $params['username'];
            $this->password = $params['password'];
        }
        
    }
    
    function connect(){
        $this->conn  = @imap_open($this->host, $this->username, $this->password);
        if($this->conn){
            return true;
        }else{
            return 0;
        }
    }
    function information(){
        $output = array();
        $emails = imap_search($this->conn,'NEW');
        if($emails){
            
            /* put the newest emails on top */            
            rsort($emails);
            $cnt=0;
            foreach($emails as $email_number) {
                
                /* get information specific to this email */
                $overview = imap_fetch_overview($this->conn,$email_number,0);
                $ov[]=imap_fetch_overview($this->conn,$email_number,0);
                $header = imap_headerinfo($this->conn, $email_number);
                
                /* get mail message */
                $message = imap_fetchbody($this->conn,$email_number,1);
                $output[$cnt]['header'] = $header;
                $output[$cnt]['subject']= $overview[0]->subject;
                $output[$cnt]['content'] = $message;
                $cnt++;
            }
            return $output;
            
        }
    }
}
