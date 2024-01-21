<?php

namespace app\Templates;

use app\Classes\Auth;
use app\Classes\Session;
use app\Models\User;
use Error;

Class LoginPage extends Template{
    private $Error =[] ;

    public function __construct(){

        parent :: __construct();
        if(Auth::isAuthenticated())
            redirect('panel.php',['action'=>'posts']);

        $this->Title = $this->Setting->get_title() . "Login to system !";

        if ($this->Request->isPostMethod()){
             
            $data =$this->validator->validate([
                "email" => ["required","email"],
                "password" =>["required", "min:6"]
            ]);

            if (! $data->has_Error()){

                $userModele = new User();
                $user = $userModele->authenticatUser($this->Request->email,$this->Request->password);
                if($user){
                    Auth::loginUser($user);
                    redirect('panel.php',['action'=>'posts']);
                }else{
                    $this->Error [] = 'invalid credential';  
                }


            }else{
                $this->Error = $data->get_Error();
            }


        }
        

    }

    public function Render_page()
    {
        ?>
            <html>
               <?= $this->get_Admin_head() ?>
                <body>
                    <main>

                        <form method="POST" action="<?= URL("index.php",["action"=>"login"]) ?>" >

                            <div class="login">

                                <h3>Login to system</h3>

                                <?php if(count($this->Error)){ ?>
                                    <div class="errors">
                                        <ul>
                                            <?php foreach($this->Error as $Error){?>
                                                <li><?= $Error?></li>
                                            <?php } ?>
                                        </ul> 
                                    </div>
                                <?php } ?>
                                <div>
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email">
                                </div>
                                <div>
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password">
                                </div>
                                <div>
                                    <input type="submit" value="Login">
                                </div>
                                

                            </div>

                        </form>

                    </main>
                </body>
            </html>
        <?php
    }

}