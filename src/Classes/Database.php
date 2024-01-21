<?php

namespace app\Classes ;

class Database{

    private $Database_File_addres;
    private $Data=1;

    public function __construct(string $FileName, $entityclass){

        $this->Database_File_addres = "./database/". $FileName .".json";

        $file = fopen($this->Database_File_addres,"r+"); // 1- file ro aval be sorat khandani baz mikoim
        $database = fread($file, filesize($this->Database_File_addres)); // 2- kol faile ra mikhanim
        fclose($file);
        $data = json_decode($database , true);

        $this->Data= array_map(function($item) use ($entityclass){
            return new $entityclass($item);
        },$data);

    }

    public function Set_Data($newData){

        $this->Data = $newData;

        $newData = array_map(function($item){
        
            return $item->toArray();

        },$newData);

        $newData = json_encode($newData);

        $file = fopen($this->Database_File_addres,'w+ ');
        fwrite($file,$newData);
        fclose($file);
        return  true;
    }
    public function get_Data(){
        return $this->Data;
    }
}