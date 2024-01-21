<?php
namespace app\Entities;

class SettingEntity{

    private $id;
    private $title;
    private $keywords;
    private $description;
    private $author;
    private $logo;
    private $footer;

    public function __construct($array){

        $this->id = $array['id'];
        $this->title = $array['title'];
        $this->keywords = $array['keywords'];
        $this->description = $array['description'];
        $this->author = $array['author'];
        $this->logo = $array['logo'];
        $this->footer = $array['footer'];

    }

    public function toArray(){ 
        return[
        'id' => $this->id ,
       'title' => $this->title ,
       'keyWords' => $this->keywords ,
       'description' => $this->description ,
       'author' => $this->author ,
       'logo' => $this->logo ,
       'footer' => $this->footer
       ] ;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_keywords(){
        return $this->keywords;
    }

    public function get_description(){
        return $this->description;
    }

    public function get_author(){
        return $this->author;
    }

    public function get_logo(){
        return $this->logo;
    }

    public function get_footer(){
        return $this->footer;
    }
}