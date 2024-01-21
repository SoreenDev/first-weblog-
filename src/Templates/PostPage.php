<?php

namespace app\Templates;

use app\Classes\Session;
use app\Models\Post;
use app\Templates\Template;

class PostPage extends Template{

    private $posts;

    public function __construct(){

        parent::__construct();

        $this->Title = $this->Setting->get_title(). ' - Admin panel - all post';

        $postModel = new Post();
        $this->posts = $postModel->get_ALL_data();

    }

    public function showMessage()
    {
        if(Session::get('message')){
            ?>
                <div class="message">
                    <?= Session::flush('message') ?>
                </div>
            <?php
        }
    }

    public function Render_page()
    {
        ?>    
            <html>
                <?php $this->get_Admin_head(); ?>
                <body>
                    <main>
                        <?php $this->getAdminNavar(); ?>
                        <section class="content">

                            <?php $this->showMessage(); ?>
                            <?php if(count($this->posts)){ ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>View</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($this->posts as $post){?>

                                            <tr>
                                                <td><?=$post->get_id()?></td>
                                                <td><?=$post->get_title()?></td>
                                                <td><?=$post->get_category()?></td>
                                                <td><?=$post->get_view()?></td>
                                                <td><?=$post->get_date()?></td>
                                                <td>
                                                    <a href="<?= URL('panel.php',['action'=>'edit','id'=> $post->get_id() ]) ?>">Edit</a>
                                                    <a href="<?= URL('panel.php',['action'=>'delete','id'=> $post->get_id() ]) ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </section>
                    </main>
                </body>
            </html>
        <?php
    }

}