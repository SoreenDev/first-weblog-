<?php

namespace app\Models;

use app\Classes\Database;
use app\Exceptions\DoseNotExistsException;

abstract class Model{

    protected $Database;
    protected $Filename;
    protected $EntityClass;

    public function __construct(){

        $this->Database = new Database($this->Filename,$this->EntityClass);

    }

    public function get_ALL_data(){
    
        return $this->Database->get_Data();
    }

    public function get_data_byID($id){

        $data = $this->Database->get_Data();

        $array = array_filter($data , Function ($item) use($id){
            return $item->get_id() == $id; 
        });

        $array = array_values($array);
        if(count($array)){
            return $array[0];
        }else{
            throw new DoseNotExistsException("Dose not exist any {$this->EntityClass} !");
        }
    }

    public function get_LastData(){
            
        $data = $this->Database->get_Data();

        uasort($data,function($first,$second){
            return ($first->get_id()>$second->get_id())? -1: 1;
        }); // bad as sort shodan chek mikone

        $data = array_values($data);

        if(count($data)){
            return $data[0];
        }else{            throw new DoseNotExistsException("Dose not exist any {$this->EntityClass} !");    }
    }

    public function get_FirstData(){
            
        $data = $this->Database->get_Data();

        uasort($data,function($first,$second){
            return ($first->get_id() < $second->get_id())? -1 : 1;
        }); // bad as sort shodan chek mikone

        $data = array_values($data);

        if(count($data)){
            return $data[0];
        }else{            throw new DoseNotExistsException("Dose not exist any {$this->EntityClass} !");    }
    }

    public function Sort_Data($callback){

        $data = $this->Database->get_Data();

        uasort($data,$callback);

        $data = array_values($data);

        if(count($data)){
            return $data;
        }else{            throw new DoseNotExistsException("Dose not exist any {$this->EntityClass} !");    }

    }

    public function Filter_Data($callback){

        $data = $this->Database->get_Data();

        $data = array_filter($data,$callback);

        $data = array_values($data);

        if(count($data)){
            return $data;
        }else{            throw new DoseNotExistsException("Dose not exist any {$this->EntityClass} !");    }

    }

    public function CreateData($now){

        $data=$this-> Database ->get_Data();
        $data[] = $now;
        $this->Database->Set_Data($data);
        return true;

    }

    public function DeleteData($id){

        $data=$this->Database->get_Data();
        $newData = array_filter($data,function($item) use($id){
            return $item->get_id() == $id?false:true;
        });
        $newData=array_values($newData);

        $this->Database->Set_Data($newData);
        return true;
    }

    public function editData($edit){
        $data= $this->Database->get_Data();
        $newData = array_map(function($array)use($edit){
            return $array->get_id() == $edit->get_id() ?$edit:$array;
        },$data);

        $newData = array_values($newData);

        $this->Database->Set_Data($newData);
        return true;
    }

}