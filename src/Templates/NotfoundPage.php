<?php
namespace app\Templates;

Class NotfoundPage extends Template{

    private $Message ; 

    public function __construct($message){

        parent :: __construct();
        $this->Message = $message ;
        $this->Title = $message;

    }

    public function Render_page()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <?= $this->get_Head() ?>
            <body>
                <main>
                    <section id="content">
                        <div>
                            <?= $this->Message ; ?>
                            <br>    
                            <a href="index.php">---- Back to home ! ----</a>
                        </div>
                    </section>
                </main>
            </body>
        </html>
        <?php
    }

}