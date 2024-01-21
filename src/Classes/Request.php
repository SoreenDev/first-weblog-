<?php

namespace app\Classes;

Class Request{

    public $Attributes= [];
    private $Method ;
    private $Url ;

    public function __construct(){

        $this->Method = $_SERVER['REQUEST_METHOD'];
        $this->Url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if ($this->Method == 'POST'){

            foreach($_POST as $key => $value){
                $this->Attributes[$key]=$value;
            }
            
            foreach($_FILES as $key => $value){
                $this->Attributes[$key]= new Upload($value);
            }
        }

        foreach($_GET as $key => $value){
            $this->Attributes[$key]=$value;
        }

    }

    public function __get($name){

        if (array_key_exists($name,$this->Attributes)){ return $this->Attributes[$name];}

        return null;
    }

    public function has($name){

        return(isset($this->Attributes[$name]))? true : false;

    }
    public function get($name){

        if (array_key_exists($name,$this->Attributes)){ return $this->Attributes[$name];}

        return null;
    }

    public function get_Method(){
        return $this->method;
    }
    
    public function get_Urls(){
        return $this->Url;
    }

    public function isPostMethod(){

        return strtolower($this->Method) == "post" ? true : false ;

    }

}