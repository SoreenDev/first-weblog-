<?php

namespace app\Entities;

class UserEntity{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $date;

    public function __construct($array){


        $this->id = $array['id'];
        $this->firstname = $array['first_name'];
        $this->lastname = $array['last_name'];
        $this->email =$array['email'];
        $this->password =$array['password'];
        $this->date =$array['date'];
 
    }

    public function toArray(){
        
        return [
            'id' => $this->id,
            'first_name' => $this->firstname,
            'last_name' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'date' => $this->date,
        ];

    }

    public function get_id(){
        return $this->id;
    }

    public function get_firstname(){
        return $this->firstname;
    }

    public function get_lastname(){
        return $this->lastname;
    }
    public function get_fullname(){
        return $this->firstname." ".$this->lastname ;
    }

    public function get_email(){
       
        return $this->email;
    }
    public function get_password(){
        return $this->password;
    }
    
    public function get_date(){
        return $this->date;
    }

    public function Time_Stamp(){
        return strtotime($this->date);
    }

}
