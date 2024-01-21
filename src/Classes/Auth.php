<?php

namespace app\Classes;

use app\Entities\UserEntity;
use Composer\Autoload\ClassLoader;

class Auth {

    public static function  loginUser($user){
        
        Session::set('user',$user->toArray());

    }

    public static function logoutUser(){

        Session::forget('user');
        redirect('index.php',['action'=>'login']);

    }

    public static function getLoggedinUser(){

        return new UserEntity(Session::get('user'));

    }

    public static function isAuthenticated(){
        return Session::has('user')?true:false;
    }
    public static function chekAuthenticated(){

        if (!self::isAuthenticated())
            redirect('index.php',['action'=>'login']);

    }
}