<?php

namespace app\Templates;

use app\Classes\Session;
use app\Models\Post;

class DeletePage extends Template
{
    public function __construct(){
        parent::__construct();
        
        if(!$this->Request->has('id'))
            redirect('panel.php',['action'=>'posts']) ;
        $id =$this->Request->id ;

        $postModel = new Post();
        $post = $postModel->get_data_byID($id);
        Session :: flush('message','post was deleted');

        $postModel->DeleteData($post->get_id());
        deleteFile($post->get_image());
        redirect('panel.php',['action'=>'posts']) ;


        
    }

 public function Render_page()
 {
    
 }
}