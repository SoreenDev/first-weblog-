<?php

namespace app\Classes;

Class Session{

    public static function get($name){

        return isset($_SESSION[$name]) ? $_SESSION[$name] : null ;

    }

    public static function set($name,$value){

        $_SESSION[$name] = $value ;

    }

    public static function has($name){

        return isset($_SESSION[$name]) ? true : false ;

    }

    public static function forget($name){

        unset($_SESSION[$name]);
        return true ;

    }

    public static function flush($name,$value = null){

        if(self::has($name)){

            $session = self::get($name);
            self::forget($name);
            return $session;
        }else{

            Self::set($name,$value) ;

        }

        

    }

}