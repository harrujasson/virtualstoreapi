<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model{
  
   
   protected $table="comments";
 
   protected $fillable=[
       'name','email','comment','rating','picture','blog_id','type','send_type'
   ];   
   

   function replys(){
        return $this->hasMany('App\Model\CommentsReply', 'comment_id', 'id');
   }
}
