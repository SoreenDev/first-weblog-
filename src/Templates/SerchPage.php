<?php
namespace app\Templates;

use app\Exceptions\NotfoundException;
use app\Models\Post;
use app\Templates\Template;

Class SerchPage extends Template{

    private $topPost;
    private $lastPost;
    private $Posts ;

    public function __construct()
    {
        parent::__construct();

        if(! $this->Request->has('word'))
            throw new NotfoundException('Not found Page!');
        $word = $this->Request->word;

        $this->Title = $this->Setting->get_title()." - Result : " . $word;
        
        $PostModel = new Post();

        $this->Posts = $PostModel->Filter_Data(function($item)use($word){
            return str_contains($item->get_title(),$word) or str_contains($item->get_content(),$word)?true:false;
        });
        $this->topPost = $PostModel->Sort_Data(function($first,$scend){
            return $first->get_view() > $scend->get_view()? -1 : 1 ;
        });

        $this->lastPost = $PostModel->Sort_Data(function($first,$scend){
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

                        <?php $this->get_Sidebar($this->topPost,$this->lastPost) ?>

                        <div id="articles">
                            <?php foreach($this->Posts as $post) {  ?>
                                <article>
                                    <div class="caption">
                                        <h3><?= $post->get_title();?></h3>
                                        <ul>
                                            <li>Date: <span><?= $post->get_date();?></span></li>
                                            <li>Views: <span><?= $post->get_view();?> view</span></li>
                                        </ul>
                                        <p>
                                            <?= $post->Excerpt();?>
                                        </p>
                                        <a href="<?= url("index.php",["action"=>"single","id" => $post->get_id()])?>">More...</a>
                                    </div>
                                    <div class="image">
                                        <img src="<?= asset($post->get_image());?>" alt="<?= $post->get_title();?>">
                                    </div>
                                    <div class="clearfix"></div>
                                </article>
                            <?php } ?>
                        </div>    

                    </section>
                    <?php $this->get_Footer() ?>
                </main>
             </body>
        </html>
        <?php
    }

}