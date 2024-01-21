<?php

namespace app\Models;

use app\Entities\UserEntity;

class User extends Model{

    protected $Filename = "users";
    protected $EntityClass = UserEntity::class;

    public function authenticatUser($email,$password){
        
        $data = $this->Database->get_Data();
        $user = array_filter($data, function($item) use($email,$password){

            if($item->get_email() == $email and $item->get_password() == $password)
                return true ;
            return false;
        
        });
        $user = array_values($user);

        if(count($user))
            return $user[0];
        return false ;

    }

}