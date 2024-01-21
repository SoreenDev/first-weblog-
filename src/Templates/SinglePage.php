<?php

namespace app\Templates;
use app\Exceptions\NotfoundException;
use app\Models\Post;

Class SinglePage extends Template{

    private $Post;
    private $LastPost;
    private $TopPost;

    public function __construct()
    {
        parent :: __construct();
         
        if(! $this -> Request->has('id'))
            throw new NotFoundException('page Not found ! ');
        
        $id = $this->Request->id;
        $postModel = new Post();
        $this->Post = $postModel->get_data_byID($id);

        $this->Title = $this->Setting->get_title(). " - " . $this->Post->get_title(); 

        $this->TopPost = $postModel->Sort_Data(function($first,$scend){
            return $first->get_view() > $scend->get_view()? -1 : 1 ;
        });

        $this->LastPost = $postModel->Sort_Data(function($first,$scend){
            return $first->Time_Stamp() > $scend->Time_Stamp()? -1 : 1 ;
        });

    }

    public function Render_page()
    {
        ?>
        <html lang="en">
            <?php $this->get_Head(); ?>
             <body>
                <main>

                    <?php $this->get_Header(); ?>
                    <?php $this->get_Navbar(); ?>

                    <section id="content">

                        <?php $this->get_Sidebar($this->TopPost,$this->LastPost) ?>

                        <div id="articles">
                            
                                <article>
                                    <div class="caption">
                                        <h3><?= $this->Post->get_title();?></h3>
                                        <ul>
                                            <li>Date: <span><?= $this->Post->get_date();?></span></li>
                                            <li>Views: <span><?= $this->Post->get_view();?> view</span></li>
                                        </ul>
                                        <p>
                                            <?= $this->Post->get_content();?>
                                        </p>
                                    </div>
                                    <div class="image">
                                        <img src="<?= asset($this->Post->get_image());?>" alt="<?= $this->Post->get_title();?>">
                                    </div>
                                    <div class="clearfix"></div>
                                </article>
                            
                        </div>    

                    </section>
                    <?php $this->get_Footer() ?>
                </main>
             </body>
        </html>
        <?php
    }

}