<?php
session_start();
use app\Classes\Request;
use app\Exceptions\DoseNotExistsException;
use app\Exceptions\NotfoundException;
use app\Templates\CategoryPage;
use app\Templates\MainPage;
use app\Templates\NotfoundPage;
use app\Templates\SerchPage;
use app\Templates\SinglePage;
use app\Templates\LoginPage;


require "./vendor/autoload.php";

try{
    $request = new Request();
    switch ($request->get('action')){
        
        case 'single';
    
            $page = new SinglePage() ;
            break;
    
        case 'serch' ;
    
            $page = new SerchPage() ;
            break;

        case 'login' ;
    
            $page = new LoginPage() ;
            break;
        
        case 'category';
    
            $page = new CategoryPage() ;
            break;
    
        case null ;
    
            $page = new MainPage() ;
            break;
    
        default ;
    
            throw new NotfoundException('Page not found !');
    }

}catch(DoseNotExistsException | NotfoundException $exception){

    $page = new NotfoundPage($exception->getMessage()); 


}catch(Exception $exception){

    $page = new DomainException($exception->getMessage());
 

}finally{
    $page->Render_page();
}

