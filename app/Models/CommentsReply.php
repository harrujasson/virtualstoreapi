<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CommentsReply extends Model{
  
   
   protected $table="comments_reply";
 
   protected $fillable=[
       'comment','blog_id','comment_id','user_id'
   ];   
   
}
