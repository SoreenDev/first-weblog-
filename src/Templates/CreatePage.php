<?php

namespace app\Templates;

use app\Classes\Session;
use app\Classes\Validator;
use app\Entities\PostEntity;
use app\Models\Post;

class CreatePage extends Template
{
    private $Error = [];
    public function __construct()
    {
        parent::__construct();
        $this->Title = $this->Setting->get_title(). ' - Admin panel - Create post';

        if($this->Request->isPostMethod()){
            $data = $this->validator->validate([
                'title'=>['required','min:3','max:100'],
                'category'=>['required','in:sport,political,social'],
                'content'=>['required','min:3','max:5000'],
                'image'=>['nullable','required','file','type:jpg,png','size:2048']
            ]);

            if(! $data->has_Error()){
                $this->createPost();
            }else{
                $this->Error = $data->get_Error();
            }
        }
    }

    public function createPost()
    {
        $postModel = new Post();
        
        $post = new PostEntity([

            'id' => $postModel->get_LastData()->get_id()+1,
            'title' => $this->Request->title,
            'content' => $this->Request->content,
            'category' => $this->Request->category,
            'view' => 0,
            'image'=> $this->Request->image->upload(),
            'date' => date("Y-m-d H:i:s")
        ]);

        $postModel->CreateData($post);
        Session :: flush('message','new post was created');

        redirect('panel.php',['action'=>'posts']);
    }

    public function Render_page()
    {
        ?>
            <html>
                <?= $this->get_Admin_head() ?>
                <body>
                    <main>
                        
                        <?= $this->getAdminNavar() ?>

                        <section class="content">
                            <?php if(count($this->Error)){ ?>
                                    <div class="errors">
                                        <ul>
                                            <?php foreach($this->Error as $Error){?>
                                                <li><?= $Error?></li>
                                            <?php } ?>
                                        </ul> 
                                    </div>
                            <?php } ?>
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" value="<?= $this->Request->has('title')?$this->Request->title:'' ?>">
                                </div>
                                <div>
                                    <label for="category">Category</label>
                                    <select name="category" id="category">
                                        <option value="political" <?= ($this->Request->has('category') and $this->Request->category == 'political')?'selected':'' ?>>Political</option>
                                        <option value="sport" <?= ($this->Request->has('category') and $this->Request->category == 'sport')?'selected':'' ?>>Sport</option>
                                        <option value="social" <?= ($this->Request->has('category') and $this->Request->category == 'social')?'selected':'' ?>>Social</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" cols="30" rows="10" value=""><?= $this->Request->has('content')?$this->Request->content:'' ?></textarea>
                                </div>
                                <div>
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image">
                                </div>
                                <div>
                                    <input type="submit" value="Create post">
                                </div>
                            </form>
                        </section>
                    </main>
                </body>
            </html>
        <?php
    }
}
