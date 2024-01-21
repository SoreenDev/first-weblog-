<?php

namespace app\Entities;

class PostEntity{

    private $id ;
    private $title ;
    private $content ;
    private $category ;
    private $view ;
    private $image ;
    private $date;

    public function __construct($array){

        $this->id = $array["id"];
        $this->title = $array['title'];
        $this->content = $array['content'];
        $this->category = $array['category'];
        $this->view = $array['view'];
        $this->image = $array['image'];
        $this->date = $array['date'];
    }

    public function toArray(){

        return[

            'id' => $this->id ,
            'title' => $this->title ,
            'content' => $this->content ,
            'category' => $this->category ,
            'view' => $this->view ,
            'image' => $this->image ,
            'date' => $this->date 

        ];

    }

    public function set_id($id){
        $this->id=$id;
    }

    public function set_title($title){
        $this->title=$title;
    }

    public function set_content($content){
        $this->content=$content;
    }

    public function set_category($category){
        $this->category=$category;
    }

    public function set_view($view){
        $this->view=$view;
    }

    public function set_image($image){
        $this->image=$image;
    }

    public function set_date($date){
        $this->date=$date;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_content(){
        return $this->content;
    }

    public function Excerpt($count=200){
        return substr($this->content,0,$count)." ...";
    }
    
    public function get_category(){
        return $this->category;
    }
    
    public function get_view(){
        return $this->view;
    }

    public function get_image(){
        return $this->image;
    }

    public function get_date(){
        return $this->date;
    }
    public function Time_Stamp(){
        return strtotime($this->date);
    }

}