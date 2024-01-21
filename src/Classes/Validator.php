<?php

namespace app\Classes ;

Class Validator{

    private $Error = [] ; 
    private $Request ; 

    public function __construct($Request){

        $this->Request = $Request ; 
    }

    public function validate($array){

        foreach($array as $field=>$rules){

            if(in_array('nullable',$rules) and !$this->Request->{$field}->isFile())
                continue;

            foreach($rules as $rule){
                if($rule == 'nullable')
                    continue ;

                if(str_contains($rule,":")){

                    $rule=explode(":", $rule);
                    $rulename = $rule[0];
                    $rulevalue = $rule [1];
                    $this->{$rulename}($field,$rulevalue);
                    if($error = $this->{$rulename}($field,$rulevalue)){

                        $this->Error[$field] = $error ;
                        break ;
                    }
                }else{
                    if($error = $this->{$rule}($field) ){

                        $this->Error[$field] = $error ;
                        break ;
                    }
                }

            }

        }
        return $this ;
    }
    
    public function has_Error(){

        return count($this->Error)? true : false ;
    }

    public function get_Error(){

        return $this->Error; 

    }

    private function required($field){
        
        // dar empty() mibayes as geter estefade nemod
        if(is_null($this->Request->{$field}) or empty($this->Request->get($field)))
            return "Please Fill $field";
        return false ;
    }

    private function email($field){

        if(!filter_var($this->Request->{$field}, FILTER_VALIDATE_EMAIL))
            return "` $field ` is invali email !";
        return false ;
    }

    private function min($field , $value){

        if(strlen($this->Request->{$field}) < $value)
            return "` $field ` chars length is smaller than ` $value `";
        return false ;

    }

    private function max($field , $value){

        if(strlen($this->Request->{$field}) > $value)
            return "` $field ` chars length is bigger than ` $value `";
        return false ;
    }

    public function in($field,$items){

        $items = explode(',',$items);
        if(! in_array($this->Request->{$field},$items))
            return "Selected `$field` is invalid";
        else
            return false ;

    }

    public function size($field ,$len){
        if($this->Request->{$field}->getSize()>$len)
            return " `$field` must be smaller thane $len KB";
        return false ;
    }   

    public function type($field,$types){

        $items = explode(',',$types);
        if(!in_array($this->Request->{$field}->getExtension(),$items))
            return " `$field` format is invalid! " ;
        return false ;

    }

    public function file($file){

        if(!$this->Request->{$file} instanceof Upload)
            return " `$file` is not file!" ;
        if(!$this->Request->{$file}->isFile())
            return " `$file` is not file!" ;
        return FALSE ;
    }






}