<?php
session_start();


use app\Classes\Auth;
use app\Classes\Request;
use app\Exceptions\NotfoundException;
use app\Templates\CreatePage;
use app\Templates\DeletePage;
use app\Templates\EditPage;
use app\Templates\PostPage;
use app\Templates\NotfoundPage;



require "./vendor/autoload.php";

try{
    Auth::chekAuthenticated();
    $request = new Request();
    switch ($request->get('action')){
        
        case 'posts';
    
            $page = new PostPage ;
            break;
    
        case 'logout' ;

            Auth::logoutUser();
            break;
    
        case 'edit' ;

            $page = new EditPage();
            break;

        case 'create' ;

            $page = new CreatePage();
            break;

        case 'delete' ;

            $page = new DeletePage();
            break;


        default ;
    
            throw new NotfoundException('Page not found !');
    }

}catch(DomainException | NotfoundException $exception){

    $page = new NotfoundPage($exception->getMessage()); 


}catch(Exception $exception){

    $page = new DomainException($exception->getMessage());
 

}finally{
    $page->Render_page();
}

